@extends('manager.layouts.app')

@section('page_title')
    {{ $page_title ?? '' }}
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

            {{-- Header --}}
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">{{ $p_title ?? '' }}</h4>
                    <div class="small text-medium-emphasis">{{ $p_summary ?? '' }}</div>
                </div>
                <div class="btn-toolbar d-none d-md-block">
                    <a href="{{ $url ?? '' }}" class="btn btn-sm btn-primary">{{ $url_text ?? '' }}</a>
                </div>
            </div>

            <hr>

            {{-- Form --}}
            <form method="POST"
                  action="{{ route('manager.post.update', $data->id) }}"
                  enctype="multipart/form-data">
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
                    @error('name')<strong class="text-danger">{{ $message }}</strong>@enderror
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
                    @error('slug')<strong class="text-danger">{{ $message }}</strong>@enderror
                </div>

                {{-- Category --}}
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select class="select2-options-category-id form-control @error('category_id') is-invalid @enderror"
                            name="category_id">
                        @if($data->category)
                            <option value="{{ $data->category_id }}" selected>{{ $data->category->name }}</option>
                        @endif
                    </select>
                    @error('category_id')<strong class="text-danger">{{ $message }}</strong>@enderror
                </div>

                {{-- Image Cropper --}}
                <div class="image-edit mb-3">
                    <label class="form-label">Profile Image</label>
                    <input type="file" id="image-cropper" accept=".png, .jpg, .jpeg" name="image"
                           class="form-control image-cropper @error('image') is-invalid @enderror">
                    <input type="hidden" name="base64image" id="base64image">
                    @error('image')<strong class="text-danger">{{ $message }}</strong>@enderror

                    <div class="image-preview container-image-preview mt-2">
                        <div id="image-preview-background"
                             style="background-image: url('{{ $data->image ? asset($data->image) : '' }}'); background-size: cover; height: 200px; width: 200px; border:1px solid #ccc;">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-sm btn-success">Update</button>
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

        </div>
    </div>
@endsection

@push('footer-scripts')
    <script src="{{ asset('admin/select2/dist/js/select2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <script>
        // Slugify
        function slugify(text) {
            return text.normalize('NFD').toLowerCase().trim()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/_+/g, '');
        }

        function generateSlug(text) {
            $('#slug').val(slugify(text));
        }

        $(document).ready(function () {

            // Category Select2
            $('.select2-options-category-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Category',
                ajax: {
                    url: '{{ route("manager.get.category-select") }}',
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    data: function (params) {
                        return {q: params.term, type: 'public', _token: '{{ csrf_token() }}'};
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {id: item.id, text: item.name}
                            })
                        };
                    },
                    cache: true
                }
            }).trigger('change.select2');

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });

            // Image Cropper
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
                if (files && files.length > 0) {
                    var file = files[0];
                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        var reader = new FileReader();
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
        <script>noti(@json(Session::get('messages')));</script>
    @endif
@endpush
