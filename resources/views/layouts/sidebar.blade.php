<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">AppFlex Technology </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::is('home') ? 'active' : '' }}">
        <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home')  }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!--categories -->
    <li class="nav-item {{ Route::is('sales.pos') ? 'active' : '' }}">
        <a class="nav-link collapsed {{ Route::is('sales.pos') ? 'active' : '' }}" href="{{ route('sales.pos') }}">
            <i class="fas fa-cash-register fa-2x"></i>
            <span>POS</span>
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


    <!--Orders -->
    <li class="nav-item  {{ Route::is('orders') ? 'active' : ''  }}">
        <a class="nav-link collapsed {{ Route::is('orders') ? 'active' : ''  }}" href="{{route('orders')}}">
            <i class="fas fa-box-open fa-2x"></i>
            <span>Orders</span>
        </a>

    </li>

</ul>
<!-- End of Sidebar -->