@extends('manager.layouts.app')

@section('page_title')
    {{ (!empty($page_title) && isset($page_title)) ? $page_title : '' }}
@endsection

@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('admin/select2/dist/css/select2.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('admin/select2/dist/css/select2-bootstrap5.min.css') }}"/>
@endpush

@section('content')
    <div class="card mt-3">
        <div class="card-body">

            {{-- Start: Page Content --}}
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">
                        {{ (!empty($p_title) && isset($p_title)) ? $p_title : '' }}
                    </h4>
                    <div class="small text-medium-emphasis">
                        {{ (!empty($p_summary) && isset($p_summary)) ? $p_summary : '' }}
                    </div>
                </div>

                <div class="btn-toolbar d-none d-md-block">
                    <a href="{{ $url ?? '' }}" class="btn btn-sm btn-primary">
                        {{ $url_text ?? '' }}
                    </a>
                </div>
            </div>

            <hr>

            {{-- Start: Form --}}
            <form method="{{ $method ?? 'POST' }}" action="{{ $action ?? route('manager.post.store') }}"
                  enctype="{{ $enctype ?? 'multipart/form-data' }}">
                @csrf

                @if(isset($data))
                    @method('PUT')
                @endif

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           name="name"
                           id="name"
                           onkeyup="listingslug(this.value)"
                           placeholder="Name"
                           value="{{ old('name', $data->name ?? '') }}">

                    @error('name')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>

                {{-- Slug --}}
                <div class="mb-3">
                    <label class="form-label" for="slug">Slug</label>
                    <input type="text"
                           class="form-control @error('slug') is-invalid @enderror"
                           name="slug"
                           id="slug"
                           placeholder="Slug"
                           value="{{ old('slug', $data->slug ?? '') }}">

                    @error('slug')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>

                {{-- Category (Select2 Ajax like Permission) --}}
                <div class="mb-3">
                    <label class="form-label" for="category_id">Category</label>
                    <select class="select2-options-category-id form-control @error('category_id') is-invalid @enderror"
                            name="category_id">
                    </select>

                    @error('category_id')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>

                <button type="submit" class="btn btn-sm btn-success">
                    Submit
                </button>

            </form>
            {{-- End: Form --}}

            {{-- Page Description --}}
            @if(!empty($p_description) && isset($p_description))
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12">
                            <p>{{ $p_description }}</p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection


@push('footer-scripts')

    <script src="{{ asset('admin/select2/dist/js/select2.js') }}"></script>

    <script>
        // Slugify
        function slugify(text) {
            return text
                .normalize('NFD')
                .toLowerCase()
                .toString()
                .trim()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/_+/g, '');
        }

        function listingslug(text) {
            $('#slug').val(slugify(text));
        }

        $(document).ready(function () {

            // Select Category (Ajax like Permission)
            $('.select2-options-category-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Category',
                ajax: {
                    url: '{{ route("manager.get.category-select") }}',
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    data: function (params) {
                        return {
                            q: params.term,
                            type: 'public',
                            _token: '{{ csrf_token() }}'
                        };
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
                    },
                    cache: true
                }
            }).trigger('change.select2');

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });

        });
    </script>

    {{-- Toastr --}}
    @if(Session::has('messages'))
        <script>
            noti({!! json_encode((Session::get('messages'))) !!});
        </script>
    @endif

@endpush
