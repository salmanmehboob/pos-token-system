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


    <!--categories -->
    <li class="nav-item  {{ Route::is('pos-index') ? 'active' : ''  }}">
        <a class="nav-link collapsed {{ Route::is('pos-index') ? 'active' : ''  }}" href="{{route('pos-index')}}">
            <i class="fas fa-th-large fa-2x"></i>
            <span>Pos</span>
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





    <!--products-->
    <li class="nav-item  {{ Route::is('products.index') ? 'active' : ''  }}">
        <a class="nav-link collapsed  {{ Route::is('products.index') ? 'active' : ''  }}"
            href="{{route('products.index')}}">
            <i class="fas fa-box fa-2x"></i>
            <span>Products</span>
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


    <!--History -->
    <li class="nav-item  {{ Route::is('histories.index') ? 'active' : ''  }}">
        <a class="nav-link collapsed {{ Route::is('histories.index') ? 'active' : ''  }}"
            href="{{route('histories.index')}}">
            <i class="fas fa-history fa-2x"></i>
            <span>History</span>
        </a>

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