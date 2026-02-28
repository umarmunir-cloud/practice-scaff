@extends('manager.layouts.app')

@section('page_title')
    {{ (!empty($page_title) && isset($page_title)) ? $page_title : '' }}
@endsection

@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('admin/select2/dist/css/select2.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('admin/select2/dist/css/select2-bootstrap5.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('admin/datatable/datatables.min.css') }}"/>
@endpush


@section('content')
    <div class="card mt-3">
        <div class="card-body">

            {{-- Header --}}
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

            {{-- Filters (Permission Style) --}}
            <div class="row">
                <div class="col-12 mb-4 text-dark">
                    <fieldset class="reset-this redo-fieldset">
                        <legend class="reset-this redo-legend">Filters</legend>

                        <div class="row gy-2 gx-3 align-items-center">

                            <div class="col-3">
                                <select class="select2-options-category-id form-control form-control-sm"
                                        name="category_id"
                                        id="category-id">
                                </select>
                            </div>

                            <div class="col-auto">
                                <button type="button"
                                        class="btn btn-sm btn-primary"
                                        onClick="selectRange()">
                                    Submit
                                </button>
                            </div>

                        </div>
                    </fieldset>
                </div>

                {{-- Table --}}
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="indextable"
                               class="table table-bordered table-striped table-hover w-100">
                            <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

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


            {{-- Delete Modal --}}
            <div class="modal fade" id="del-model" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button"
                                    class="btn-close shadow-none"
                                    data-coreui-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p class="fw-bold mb-2">
                                Are you sure you wanna delete this?
                            </p>
                            <p class="text-muted">
                                This item will be deleted immediately. You can't undo this action.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <form method="POST" id="del-form">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        class="btn btn-light"
                                        data-coreui-dismiss="modal">
                                    Cancel
                                </button>

                                <button type="submit"
                                        class="btn btn-danger">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('footer-scripts')

    <script src="{{ asset('admin/select2/dist/js/select2.js') }}"></script>
    <script src="{{ asset('admin/datatable/datatables.min.js') }}"></script>

    <script>
        $(document).ready(function () {

            // Category Select2
            $('.select2-options-category-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Category',
                allowClear: true,
                ajax: {
                    url: '{{ route("manager.get.category-select") }}',
                    dataType: 'json',
                    delay: 250,
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
            });

            // Datatable
            $('#indextable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                order: [[0, "desc"]],
                ajax: {
                    type: "GET",
                    url: "{{ route('manager.get.post') }}",
                    data: function (d) {
                        d.category_id = document.getElementById('category-id').value;
                    }
                },
                columns: [
                    {data: 'id'},
                    {data: 'image'},
                    {data: 'name'},
                    {data: 'slug'},
                    {data: 'category'},
                    {data: null}
                ],
                columnDefs: [
                    {
                        targets: 0,
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        targets: 1, // Image column
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            if (row.image) {
                                return `<img src="${row.image}" class="img-fluid rounded-circle" style="width:40px; height:40px; object-fit:cover;">`;
                            } else {
                                return `<span class="text-muted">No Image</span>`;
                            }
                        }
                    },
                    {
                        targets: -1,
                        searchable: false,
                        orderable: false,
                        render: function (data, type, row) {
                            let URL = "{{ route('manager.post.show', ':id') }}".replace(':id', row.id);

                            return `
                            <div class="d-flex">
                                <a class="me-1" href="${URL}">
                                    <span class="badge bg-success text-dark">Show</span>
                                </a>

                                <a class="me-1" href="${URL}/edit">
                                    <span class="badge bg-info text-dark">Edit</span>
                                </a>

                                <a href="javascript:void(0)">
                                    <span class="badge bg-danger"
                                          data-url="${URL}"
                                          data-coreui-toggle="modal"
                                          data-coreui-target="#del-model">
                                          Delete
                                    </span>
                                </a>
                            </div>`;
                        }
                    }
                ]
            })
            ;

        });

        // Filter reload
        function selectRange() {
            $('.dataTable').DataTable().ajax.reload();
        }

        // Delete modal
        $("#del-model").on('show.coreui.modal', function (event) {
            var triggerLink = $(event.relatedTarget);
            var url = triggerLink.data("url");
            $("#del-form").attr('action', url);
        });
    </script>

    {{-- Toastr --}}
    @if(Session::has('messages'))
        <script>
            noti(@json(Session::get('messages')));
        </script>
    @endif

@endpush
