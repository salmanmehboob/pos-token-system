<!DOCTYPE html>
<html lang="en">

<head>

    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ================== BEGIN core-css ================== -->
    <link href="{{ asset('pos/assets/css/vendor.min.css')}}" rel="stylesheet">
    <link href="{{ asset('pos/assets/css/app.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/toastr/css/toastr.min.css')}}" rel="stylesheet">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .employee-nav {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        .employee-nav .nav-item {
            /* no extra style needed */
        }

        .employee-nav .nav-link {
            cursor: pointer;
            background-color: #0d6efd; /* Bootstrap primary */
            color: white;
            border-radius: 12px;
            padding: 8px 16px;
            font-weight: 600;
            font-size: 1.2rem;
            transition: background-color 0.3s, box-shadow 0.3s;
            user-select: none;
            border: 2px solid transparent;
            display: inline-block;
            white-space: nowrap;
        }

        .employee-nav .nav-link:hover {
            background-color: #084298;
            box-shadow: 0 0 10px rgba(13, 110, 253, 0.7);
            text-decoration: none;
        }

        .employee-nav .nav-link.active {
            background-color: white !important;
            color: #0d6efd !important;
            border: 2px solid #0d6efd;
            box-shadow: 0 0 10px rgba(13, 110, 253, 0.9);
        }

        .order-now-btn {
            background-color: #064408; /* Bootstrap primary */
            color: white;
            border-radius: 12px;
            padding: 12px 40px;
            font-weight: 600;
            font-size: 1.2rem;
            min-width: 180px;
            transition: background-color 0.3s, box-shadow 0.3s;
            border: 2px solid transparent;
            cursor: pointer;
            user-select: none;
        }

        .order-now-btn:hover {
            background-color: #06800a;
            box-shadow: 0 0 10px rgba(13, 110, 253, 0.7);
            color: white;
            text-decoration: none;
        }
        html, body, #app {
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }

    </style>
    <!-- ================== END core-css ================== -->
</head>

<body>

    <!-- BEGIN #app -->
    <div id="app" class="app app-content-full-height app-without-sidebar app-without-header">
        <!-- BEGIN #content -->
        <div id="content" class="app-content p-0">
            <!-- BEGIN pos -->
            <div class="pos pos-with-menu pos-with-sidebar" id="pos">
                <div class="pos-container">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>


    <!-- ================== BEGIN core-js ================== -->
    <!--  this is jquery script   -->

    <script src="{{ asset('assets/vendor/jquery-3.7.1.js')  }}" type="text/javascript"></script>

    <script src="{{ asset('pos/assets/js/vendor.min.js')  }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/js/app.min.js')  }}" type="text/javascript"></script>
    <!-- ================== END core-js ================== -->
    <!-- ================== BEGIN page-js ================== -->


    <script src="{{ asset('pos/assets/js/demo/pos-customer-order.demo.js')  }}" type="text/javascript"></script>


    <script>
    window.cartRoutes = {
        meta: "{{ route('carts.meta') }}",
        store: "{{ route('carts.store') }}",
        update: "{{ route('carts.update', ':id') }}", // placeholder
        destroy: "{{ route('carts.destroy', ':id') }}",
        get: "{{ route('carts.get') }}",
        applyDiscount: "{{ route('carts.apply-discount') }}"
    };
    </script>
    <script src="{{ asset('assets/js/cart.js')  }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/custom.js')  }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendor/toastr/js/toastr.min.js')}}"></script>

    @stack('js')
    <!-- ================== END page-js ================== -->

</body>


</html>
