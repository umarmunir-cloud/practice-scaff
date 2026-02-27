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
            <form method="POST"
                  action="{{ route('manager.post.update', $data->id) }}"
                  enctype="{{ $enctype }}">

                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $data->name ?? '') }}"
                           onkeyup="generateSlug(this.value)">
                    @error('name')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>

                {{-- Slug --}}
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text"
                           name="slug"
                           id="slug"
                           class="form-control @error('slug') is-invalid @enderror"
                           value="{{ old('slug', $data->slug ?? '') }}"
                           readonly>
                    @error('slug')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>

                {{-- Category --}}
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">Select Category</option>
                        @foreach(\App\Models\Managercategory::all() as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $data->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-sm btn-success">
                    Update
                </button>

            </form>

        </div>
    </div>
@endsection

@push('footer-scripts')

    <script src="{{ asset('admin/select2/dist/js/select2.js') }}"></script>

    <script>
        /*
        |--------------------------------------------------------------------------
        | Slug Generator
        |--------------------------------------------------------------------------
        */
        function slugify(text) {
            return text.toString().toLowerCase().trim()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-');
        }

        function generateSlug(value) {
            $('#slug').val(slugify(value));
        }

        /*
        |--------------------------------------------------------------------------
        | Category Select2
        |--------------------------------------------------------------------------
        */

        $(document).ready(function () {

            // Preselected category
            let category = [{
                id: "{{ $data->category_id }}",
                text: "{{ $data->category->name ?? '' }}"
            }];

            $('.select2-category').select2({
                data: category,
                theme: "bootstrap5",
                placeholder: 'Select Category',
                ajax: {
                    url: "{{ route('manager.get.post-select') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {q: params.term};
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                }
                            })
                        };
                    }
                }
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
