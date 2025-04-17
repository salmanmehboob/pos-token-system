<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home')  }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">



    <!--products-->
    <li class="nav-item  {{ Route::is('products.index') ? 'active' : ''  }}">
        <a class="nav-link collapsed  {{ Route::is('products.index') ? 'active' : ''  }}"
            href="{{route('products.index')}}">
            <i class="fas fa-box fa-2x"></i>
            <span>Products</span>
        </a>

    </li>

    <!--categories -->
    <li class="nav-item  {{ Route::is('product.categories.index') ? 'active' : ''  }}">
        <a class="nav-link collapsed {{ Route::is('product.categories.index') ? 'active' : ''  }}"
            href="{{route('product.categories.index')}}">
            <i class="fas fa-th-large fa-2x"></i>
            <span>Categories</span>
        </a>

    </li>





    <!--Inventory -->
    <li class="nav-item  {{ Route::is('inventories.index') ? 'active' : ''  }}">
        <a class="nav-link collapsed {{ Route::is('inventories.index') ? 'active' : ''  }}"
           href="{{route('inventories.index')}}">
            <i class="fas fa-clipboard-list fa-2x"></i>
            <span>Inventory</span>
        </a>

    </li>








        <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="assets/images/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!
        </p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div>

</ul>
<!-- End of Sidebar -->
