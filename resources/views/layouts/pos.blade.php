<!DOCTYPE html>
<html lang="en">

<head>

    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ================== BEGIN core-css ================== -->
    <link href="{{ asset('pos/assets/css/vendor.min.css')}}" rel="stylesheet">
    <link href="{{ asset('pos/assets/css/app.min.css')}}" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
          integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer"/>

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


<!-- ================== END page-js ================== -->

</body>


</html>
