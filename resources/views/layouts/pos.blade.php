<!DOCTYPE html>
<html lang="en">

<head>

    <title>@yield('title')</title>

    <!-- ================== BEGIN core-css ================== -->
    <link href="{{ asset('pos/assets/css/vendor.min.css')}}" rel="stylesheet">
    <link href="{{ asset('pos/assets/css/app.min.css')}}" rel="stylesheet">
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
    <script src="{{ asset('pos/assets/js/vendor.min.js')  }}" type="text/javascript"></script>
    <script src="{{ asset('pos/assets/js/app.min.js')  }}" type="text/javascript"></script>
    <!-- ================== END core-js ================== -->
    <!-- ================== BEGIN page-js ================== -->


    <script src="{{ asset('pos/assets/js/demo/pos-customer-order.demo.js')  }}" type="text/javascript"></script>

    <!-- ================== END page-js ================== -->

</body>






</html>