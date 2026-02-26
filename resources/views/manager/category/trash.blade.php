@extends('manager.layouts.app')
@section('page_title')
    {{ $page_title ?? '' }}
@endsection
@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('admin/datatable/datatables.min.css') }}" rel="stylesheet"/>
@endpush
@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">{{ $p_title ?? '' }}</h4>
                    <div class="small text-medium-emphasis">{{ $p_summary ?? '' }}</div>
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
                            <th>Current (Relations)</th>
                            <th>Old</th>
                            <th>At</th>
                            <th>User</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @if(!empty($p_description))
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 mb-sm-2 mb-0">
                            <p>{{ $p_description }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('footer-scripts')
    <script type="text/javascript" src="{{ asset('admin/datatable/datatables.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            let URL = "{{ route('manager.get.category-activity-trash-log') }}";

            $('#indextable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                order: [[0, "desc"]],
                ajax: {
                    type: "GET",
                    url: URL,
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
                        width: '80px',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }
                ]
            });
        });

        function selectRange() {
            $('.dataTable').DataTable().ajax.reload()
        }
    </script>

    <script>
        $("#del-model").on('show.coreui.modal', function (event) {
            var triggerLink = $(event.relatedTarget);
            var url = triggerLink.data("url");
            $("#del-form").attr('action', url);
        })
    </script>

    @if(Session::has('messages'))
        <script>
            noti(@json(Session::get('messages')));
        </script>
    @endif
@endpush
