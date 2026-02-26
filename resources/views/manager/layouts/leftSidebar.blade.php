<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <h5 class="mb-0">{{!empty(session('currentModule.0')) ? ucwords(session('currentModule.0')) : ''}}</h5>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('manager/dashboard') ? 'active' : '' }}"
               href="{{route('manager.dashboard')}}">
                <i class="nav-icon cil-speedometer"></i> Dashboard
            </a>
        </li>
        @canany(['admin_user-management_permission-group-list','admin_user-management_permission-create','admin_user-management_role-list','admin_user-management_user-list'])
            <li class="nav-title">User Management</li>
            @can('admin_user-management_module-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manager/category*') ? 'active' : '' }}"
                       href="{{route('manager.category.index')}}">
                        <i class="nav-icon cil-cursor"></i> Categories
                    </a>
                </li>
            @endcan
            @can('admin_user-management_module-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manager/post*') ? 'active' : '' }}"
                       href="{{route('manager.post.index')}}">
                        <i class="nav-icon cil-cursor"></i> Posts
                    </a>
                </li>
            @endcan
        @endcanany
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
