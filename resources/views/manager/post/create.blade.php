@extends('manager.layouts.app')

@section('page_title')
    {{ (!empty($page_title) && isset($page_title)) ? $page_title : '' }}
@endsection

@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('admin/select2/dist/css/select2.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('admin/select2/dist/css/select2-bootstrap5.min.css') }}"/>
    <!-- Cropper CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"/>

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

                <div class="image-edit mb-3">
                    <label class="form-label" for="password">Profile Image</label>
                    <input type="file" id="image-cropper" accept=".png, .jpg, .jpeg" name="image"
                           class="form-control wizard-required image-cropper @error('password') is-invalid @enderror">
                    <input type="hidden" name="base64image" id="base64image">
                    @error('image')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                    <div class="image-preview container-image-preview">
                        <div id="image-preview-background"></div>
                    </div>
                </div>


                <button type="submit" class="btn btn-sm btn-success">
                    Submit
                </button>

            </form>


            {{-- Modal --}}
            <div class="modal fade bd-example-modal-lg imageCrop" id="model" tabindex="-1" role="dialog"
                 aria-labelledby="cropperModalLabel" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cropperModal">Crop Image</h5>
                            <button type="button" class="close btn-close" id="reset-image"
                                    data-coreui-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="img-container">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8">
                                        <img id="previewImage" src="" class="img-fluid w-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between flex-wrap">
                            <button type="button" class="btn btn-secondary" id="reset-image-close"
                                    data-coreui-dismiss="modal">Close
                            </button>
                            <button type="button" class="btn btn-primary crop" id="cropImage">Crop</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End: Modal --}}


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

    <!-- Cropper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

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
    <script>
        //Image Cropper
        $(document).ready(function () {
            var $modal = $('.imageCrop');
            var image = document.getElementById('previewImage');
            var cropper;

            $("body").on("change", ".image-cropper", function (e) {
                e.preventDefault();
                var files = e.target.files;
                var done = function (url) {
                    image.src = url;
                    $modal.modal('show');
                };
                var reader;
                var file;
                var URL;
                if (files && files.length > 0) {
                    file = files[0];
                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function (e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            $modal.on('shown.coreui.modal', function () {
                cropper = new Cropper(image, {
                    dragMode: 'move',
                    aspectRatio: 1 / 1,
                    autoCropArea: 0.65,
                    restore: false,
                    guides: false,
                    center: false,
                    highlight: false,
                    cropBoxMovable: false,
                    cropBoxResizable: false,
                    toggleDragModeOnDblclick: false,
                });
            }).on('hidden.coreui.modal', function () {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
            });

            $("body").on("click", "#cropImage", function () {
                if (!cropper) return;
                var canvas = cropper.getCroppedCanvas({width: 200, height: 300});
                canvas.toBlob(function (blob) {
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        $('#base64image').val(base64data);
                        document.getElementById('image-preview-background').style.backgroundImage = "url(" + base64data + ")";
                        $modal.modal('hide');
                    }
                });
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
