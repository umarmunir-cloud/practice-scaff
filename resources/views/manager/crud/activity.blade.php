@extends('manager.layouts.app')
@section('page_title')
    {{(!empty($page_title) && isset($page_title)) ? $page_title : ''}}
@endsection
@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('admin/datatable/datatables.min.css') }}" rel="stylesheet"/>
@endpush
@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">{{(!empty($p_title) && isset($p_title)) ? $p_title : ''}}</h4>
                    <div
                        class="small text-medium-emphasis">{{(!empty($p_summary) && isset($p_summary)) ? $p_summary : ''}}</div>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar">
                    <a href="{{ $url ?? '' }}" class="btn btn-sm btn-primary">{{ $url_text ?? '' }}</a>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="indextable"
                               class="table table-bordered table-striped table-hover table-responsive w-100 pt-1">
                            <thead class="table-dark">
                            <th>#</th>
                            <th>Type</th>
                            <th>Current</th>
                            <th>Old</th>
                            <th>At</th>
                            <th>User</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @if(!empty($p_description) && isset($p_description))
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 mb-sm-2 mb-0">
                            <p>{{ $p_description }}</p>
                        </div>
                    </div>
                </div>
            @endif
            {{-- Delete Confirmation Modal --}}
            <div class="del-model-wrapper">
                <div class="modal fade" id="del-model" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close shadow-none"
                                        data-coreui-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p class="font-weight-bold mb-2">Are you sure you want to delete this?</p>
                                <p class="text-muted">This item will be deleted immediately. You can't undo this
                                    action.</p>
                            </div>
                            <div class="modal-footer">
                                <form method="POST" id="del-form">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button type="button" class="btn btn-light" data-coreui-dismiss="modal">Cancel
                                    </button>
                                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('footer-scripts')
    <script type="text/javascript" src="{{ asset('admin/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            //Datatable
            let id = '{{$id}}'
            let URL = "{{ route('manager.get.crud-activity-log', ':id') }}";
            URL = URL.replace(':id', id);
            $('#indextable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                order: [[0, "desc"]],
                ajax: {
                    "type": "GET",
                    "url": URL,
                    // "data":function (d){
                    //     d.category_id = document.getElementById('category-id').value;
                    // }
                },
                columns: [
                    {data: 'id'},
                    {data: 'type'},
                    {data: 'current'},
                    {data: 'old'},
                    {data: 'updated'},
                    {data: 'causer'},
                ],
                columnDefs: [
                    {
                        targets: 0,
                        orderable: false,
                        searchable: false,
                        width: '100px',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }
                ]
            });
        });

        // Delete modal setup
        $("#del-model").on('show.coreui.modal', function (event) {
            var triggerLink = $(event.relatedTarget);
            var url = triggerLink.data("url");
            $("#del-form").attr('action', url);
        });
    </script>
    @if(Session::has('messages'))
        <script>
            noti({!! json_encode(Session::get('messages')) !!});
        </script>
    @endif
@endpush
