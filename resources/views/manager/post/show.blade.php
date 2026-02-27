@extends('manager.layouts.app')

@section('page_title')
    {{ $page_title ?? '' }}
@endsection

@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('admin/select2/dist/css/select2.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('admin/select2/dist/css/select2-bootstrap5.min.css') }}"/>
@endpush

@section('content')
    <div class="card mt-3">
        <div class="card-body">

            {{-- Header --}}
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">{{ $p_title ?? '' }}</h4>
                    <div class="small text-medium-emphasis">
                        {{ $p_summary ?? '' }}
                    </div>
                </div>

                <div class="btn-toolbar d-none d-md-block">
                    <a href="{{ $url ?? '' }}" class="btn btn-sm btn-primary">
                        {{ $url_text ?? '' }}
                    </a>
                </div>
            </div>

            <hr>

            {{-- Form --}}
            <form>

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $data->name ?? '' }}"
                           disabled>
                </div>

                {{-- Slug --}}
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $data->slug ?? '' }}"
                           disabled>
                </div>

                {{-- Category --}}
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select class="select2-category form-control" disabled></select>
                </div>

            </form>

            {{-- Description --}}
            @if(!empty($p_description))
                <div class="card-footer">
                    <p>{{ $p_description }}</p>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('footer-scripts')
    <script src="{{ asset('admin/select2/dist/js/select2.js') }}"></script>

    <script>
        $(document).ready(function () {

            let category = [{
                id: "{{ $data->category_id }}",
                text: "{{ $data->category->name ?? '' }}"
            }];

            $('.select2-category').select2({
                data: category,
                theme: "bootstrap5",
                placeholder: 'Select Category',
            });

        });
    </script>

    {{-- Toastr --}}
    @if(Session::has('messages'))
        <script>
            noti(@json(Session::get('messages')));
        </script>
    @endif
@endpush
