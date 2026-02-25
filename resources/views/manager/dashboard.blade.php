@extends('manager.layouts.app')
@section('page_title')
    {{(!empty($page_title) && isset($page_title)) ? $page_title : ''}}
@endsection

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            {{-- Start: Page Content --}}
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">{{(!empty($p_title) && isset($p_title)) ? $p_title : ''}}</h4>
                    <div
                        class="small text-medium-emphasis">{{(!empty($p_summary) && isset($p_summary)) ? $p_summary : ''}}</div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">Traffic &amp; Sales</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="border-start border-start-4 border-start-info px-3 mb-3"><small
                                                    class="text-medium-emphasis">New Clients</small>
                                                <div class="fs-5 fw-semibold">9.123</div>
                                            </div>
                                        </div>
                                        <!-- /.col-->
                                        <div class="col-6">
                                            <div class="border-start border-start-4 border-start-danger px-3 mb-3">
                                                <small class="text-medium-emphasis">Recuring Clients</small>
                                                <div class="fs-5 fw-semibold">22.643</div>
                                            </div>
                                        </div>
                                        <!-- /.col-->
                                    </div>
                                    <!-- /.row-->
                                    <hr class="mt-0">
                                    <div class="progress-group mb-4">
                                        <div class="progress-group-prepend"><span class="text-medium-emphasis small">Monday</span>
                                        </div>
                                        <div class="progress-group-bars">
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 34%"
                                                     aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                     style="width: 78%" aria-valuenow="78" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-group mb-4">
                                        <div class="progress-group-prepend"><span class="text-medium-emphasis small">Tuesday</span>
                                        </div>
                                        <div class="progress-group-bars">
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 56%"
                                                     aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                     style="width: 94%" aria-valuenow="94" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-group mb-4">
                                        <div class="progress-group-prepend"><span class="text-medium-emphasis small">Wednesday</span>
                                        </div>
                                        <div class="progress-group-bars">
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 12%"
                                                     aria-valuenow="12" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                     style="width: 67%" aria-valuenow="67" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-group mb-4">
                                        <div class="progress-group-prepend"><span class="text-medium-emphasis small">Thursday</span>
                                        </div>
                                        <div class="progress-group-bars">
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 43%"
                                                     aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                     style="width: 91%" aria-valuenow="91" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-group mb-4">
                                        <div class="progress-group-prepend"><span class="text-medium-emphasis small">Friday</span>
                                        </div>
                                        <div class="progress-group-bars">
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 22%"
                                                     aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                     style="width: 73%" aria-valuenow="73" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-group mb-4">
                                        <div class="progress-group-prepend"><span class="text-medium-emphasis small">Saturday</span>
                                        </div>
                                        <div class="progress-group-bars">
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 53%"
                                                     aria-valuenow="53" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                     style="width: 82%" aria-valuenow="82" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-group mb-4">
                                        <div class="progress-group-prepend"><span class="text-medium-emphasis small">Sunday</span>
                                        </div>
                                        <div class="progress-group-bars">
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 9%"
                                                     aria-valuenow="9" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                     style="width: 69%" aria-valuenow="69" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-->
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="border-start border-start-4 border-start-warning px-3 mb-3">
                                                <small class="text-medium-emphasis">Pageviews</small>
                                                <div class="fs-5 fw-semibold">78.623</div>
                                            </div>
                                        </div>
                                        <!-- /.col-->
                                        <div class="col-6">
                                            <div class="border-start border-start-4 border-start-success px-3 mb-3">
                                                <small class="text-medium-emphasis">Organic</small>
                                                <div class="fs-5 fw-semibold">49.123</div>
                                            </div>
                                        </div>
                                        <!-- /.col-->
                                    </div>
                                    <!-- /.row-->
                                    <hr class="mt-0">
                                    <div class="progress-group">
                                        <div class="progress-group-header">
                                            <svg class="icon icon-lg me-2">
                                                <use
                                                    xlink:href="{{asset('manager/coreui')}}/vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                                            </svg>
                                            <div>Male</div>
                                            <div class="ms-auto fw-semibold">43%</div>
                                        </div>
                                        <div class="progress-group-bars">
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                     style="width: 43%" aria-valuenow="43" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-group mb-5">
                                        <div class="progress-group-header">
                                            <svg class="icon icon-lg me-2">
                                                <use
                                                    xlink:href="{{asset('manager/coreui')}}/vendors/@coreui/icons/svg/free.svg#cil-user-female"></use>
                                            </svg>
                                            <div>Female</div>
                                            <div class="ms-auto fw-semibold">37%</div>
                                        </div>
                                        <div class="progress-group-bars">
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                     style="width: 43%" aria-valuenow="43" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-group">
                                        <div class="progress-group-header">
                                            <svg class="icon icon-lg me-2">
                                                <use
                                                    xlink:href="{{asset('manager/coreui')}}/vendors/@coreui/icons/svg/brand.svg#cib-google"></use>
                                            </svg>
                                            <div>Organic Search</div>
                                            <div class="ms-auto fw-semibold me-2">191.235</div>
                                            <div class="text-medium-emphasis small">(56%)</div>
                                        </div>
                                        <div class="progress-group-bars">
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                     style="width: 56%" aria-valuenow="56" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-group">
                                        <div class="progress-group-header">
                                            <svg class="icon icon-lg me-2">
                                                <use
                                                    xlink:href="{{asset('manager/coreui')}}/vendors/@coreui/icons/svg/brand.svg#cib-facebook-f"></use>
                                            </svg>
                                            <div>Facebook</div>
                                            <div class="ms-auto fw-semibold me-2">51.223</div>
                                            <div class="text-medium-emphasis small">(15%)</div>
                                        </div>
                                        <div class="progress-group-bars">
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                     style="width: 15%" aria-valuenow="15" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-group">
                                        <div class="progress-group-header">
                                            <svg class="icon icon-lg me-2">
                                                <use
                                                    xlink:href="{{asset('manager/coreui')}}/vendors/@coreui/icons/svg/brand.svg#cib-twitter"></use>
                                            </svg>
                                            <div>Twitter</div>
                                            <div class="ms-auto fw-semibold me-2">37.564</div>
                                            <div class="text-medium-emphasis small">(11%)</div>
                                        </div>
                                        <div class="progress-group-bars">
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                     style="width: 11%" aria-valuenow="11" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-group">
                                        <div class="progress-group-header">
                                            <svg class="icon icon-lg me-2">
                                                <use
                                                    xlink:href="{{asset('manager/coreui')}}/vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                                            </svg>
                                            <div>LinkedIn</div>
                                            <div class="ms-auto fw-semibold me-2">27.319</div>
                                            <div class="text-medium-emphasis small">(8%)</div>
                                        </div>
                                        <div class="progress-group-bars">
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                     style="width: 8%" aria-valuenow="8" aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-->
                            </div>
                            <!-- /.row--><br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mb-0 align-middle">
                                    <thead class="table-light fw-semibold">
                                    <tr class="align-middle text-center">
                                        <th>User</th>
                                        <th>Details</th>
                                        <th>Usage</th>
                                        <th>Payment Method</th>
                                        <th>Activity</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="align-middle text-center">
                                        <td>
                                            <p>Yiorgos@gmail.com</p>
                                        </td>
                                        <td class="text-start">
                                            <div>Yiorgos Avraamu</div>
                                            <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2020
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <div class="fw-semibold">50%</div>
                                                <small class="text-muted">Jun 11 - Jul 10</small>
                                            </div>
                                            <div class="progress progress-sm mt-1">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                     style="width:50%"></div>
                                            </div>
                                        </td>
                                        <td>Credit Card</td>
                                        <td>
                                            <div class="small text-muted">Last login</div>
                                            <div class="fw-semibold">10 sec ago</div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button"
                                                        data-coreui-toggle="dropdown" aria-expanded="false">
                                                    ⋮
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#">Info</a></li>
                                                    <li><a class="dropdown-item" href="#">Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="align-middle text-center">
                                        <td>
                                            <p>Yiorgos@gmail.com</p>
                                        </td>
                                        <td class="text-start">
                                            <div>Yiorgos Avraamu</div>
                                            <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2020
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <div class="fw-semibold">50%</div>
                                                <small class="text-muted">Jun 11 - Jul 10</small>
                                            </div>
                                            <div class="progress progress-sm mt-1">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                     style="width:50%"></div>
                                            </div>
                                        </td>
                                        <td>Credit Card</td>
                                        <td>
                                            <div class="small text-muted">Last login</div>
                                            <div class="fw-semibold">10 sec ago</div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button"
                                                        data-coreui-toggle="dropdown" aria-expanded="false">
                                                    ⋮
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#">Info</a></li>
                                                    <li><a class="dropdown-item" href="#">Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="align-middle text-center">
                                        <td>
                                            <p>Yiorgos@gmail.com</p>
                                        </td>
                                        <td class="text-start">
                                            <div>Yiorgos Avraamu</div>
                                            <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2020
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <div class="fw-semibold">50%</div>
                                                <small class="text-muted">Jun 11 - Jul 10</small>
                                            </div>
                                            <div class="progress progress-sm mt-1">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                     style="width:50%"></div>
                                            </div>
                                        </td>
                                        <td>Credit Card</td>
                                        <td>
                                            <div class="small text-muted">Last login</div>
                                            <div class="fw-semibold">10 sec ago</div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button"
                                                        data-coreui-toggle="dropdown" aria-expanded="false">
                                                    ⋮
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#">Info</a></li>
                                                    <li><a class="dropdown-item" href="#">Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="align-middle text-center">
                                        <td>
                                            <p>Yiorgos@gmail.com</p>
                                        </td>
                                        <td class="text-start">
                                            <div>Yiorgos Avraamu</div>
                                            <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2020
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <div class="fw-semibold">50%</div>
                                                <small class="text-muted">Jun 11 - Jul 10</small>
                                            </div>
                                            <div class="progress progress-sm mt-1">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                     style="width:50%"></div>
                                            </div>
                                        </td>
                                        <td>Credit Card</td>
                                        <td>
                                            <div class="small text-muted">Last login</div>
                                            <div class="fw-semibold">10 sec ago</div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button"
                                                        data-coreui-toggle="dropdown" aria-expanded="false">
                                                    ⋮
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#">Info</a></li>
                                                    <li><a class="dropdown-item" href="#">Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Repeat similar rows for other users -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
            <!-- /.row-->
        </div>
    </div>
@endsection
@push('footer-scripts')

@endpush
