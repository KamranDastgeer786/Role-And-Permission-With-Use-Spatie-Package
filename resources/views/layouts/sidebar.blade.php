<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a  href="{{ route('home') }}" class="navbar-brand mx-4 mb-3  {{ request()->is('*/dashboard') ? 'active' : '' }}">
            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>DarkPan</h3>
        </a>
        {{-- <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">Jhon Doe</h6>
                <span>Admin</span>
            </div>
        </div> --}}
        <div class="navbar-nav w-100">
            <a href="{{ route('home')  }}" class="nav-item nav-link active  {{ request()->is('*/dashboard') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>


            {{-- users --}}
            @canany(['show_users', 'create_users', 'edit_users', 'delete_users', 'create_roles', 'show_roles',
             'edit_roles', 'delete_roles', 'create_permissions', 'show_permissions', 'edit_permissions','delete_permissions'
            ])
                <div class="nav-item dropdown">
                    <a href="#users" class="nav-link dropdown-toggle  {{ request()->is('*/users/*') ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>User</a>

                    <div class="dropdown-menu bg-transparent border-0  {{ request()->is('*/users/*') || request()->is('*/users') || request()->is('*/roles/*') || request()->is('*/roles') || request()->is('*/permissions/*') ? 'show' : '' }}" id="users">
                        
                        @canany(['show_users', 'create_users', 'edit_users', 'delete_users'])
                            <a href="{{ route('users.index') }}" class="dropdown-item {{ request()->is('*/users') || request()->is('*/users/*') ? 'active' : '' }}"> User </a>
                            {{-- <a href="{{ route('user.create') }}" class="dropdown-item">Create New User</a> --}}
                        @endcanany


                        @canany(['create_roles', 'show_roles', 'edit_roles', 'delete_roles'])

                           <a href="{{ route('roles.index') }}" class="dropdown-item {{ Request::is('*/roles') || request()->is('*/roles/*') ? 'active' : '' }}"> Role </a>
                            
                        @endcanany


                        @canany(['create_permissions', 'show_permissions', 'edit_permissions','delete_permissions'])

                            <a class="nav-link {{ Request::is('*/Permissions') || request()->is('*/Permissions/*') ? 'active' : '' }}" href="{{ route('permissions.index') }}" class="dropdown-item"> Permission </a>

                        @endcanany
                        
                    </div>
                </div>

            @endcanany

            {{-- End users --}}


            @canany(['create_products', 'edit_products', 'delete_products', 'show_products'])
                <div class="nav-item dropdown">
                    <a href="#productsSidebar" class="nav-link dropdown-toggle {{ request()->is('*/products/*') ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-th me-2"></i>Products</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="{{ route('products.index') }}" class="dropdown-item {{ request()->is('*/products/*') ? 'active' : '' }}"> Product </a>
                        {{-- <a href="{{ route('products.create') }}" class="dropdown-item {{ request()->is('*/products/*') ? 'active' : '' }}"  href="{{ route('products.create') }}">Create New Product</a> --}}
                    </div>
                </div>
            @endcanany



            @canany(['create_categories', 'edit_categories', 'delete_categories', 'show_categories'])
                <div class="nav-item dropdown">
                    <a href="#categorySidebar" class="nav-link dropdown-toggle  {{ request()->is('*/Category/*') ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="bi bi-view-list me-2"></i>Category</a>
                    <div class="dropdown-menu bg-transparent border-0">
                       <a href="{{ route('category.index') }}" class="dropdown-item  {{ request()->is('*/Category/*') ? 'active' : '' }}"> Category </a>
                       {{-- <a href="{{ route('category.create') }}" class="dropdown-item  {{ request()->is('*/Category/*') ? 'active' : '' }}">Create New Category</a> --}}
                    </div>
                </div>
            @endcanany
            

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Pages</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('login') }}" class="dropdown-item">Sign In</a>
                    <a href="{{ route('register') }}" class="dropdown-item">Sign Up</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">Log Out</a>
                </div>
            </div>
        </div>
    </nav>
</div>