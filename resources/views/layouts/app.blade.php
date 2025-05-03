<!DOCTYPE html>
<html lang="en">

<head>

    <title>@yield('title')</title>

    @include('layouts.header_files')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('layouts.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- main-content -->
            <div id="content">

                @include('layouts.header')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')

                    <!-- /.container-fluid -->

                </div>

            </div>

            <!-- End of Main Content -->

            @include('layouts.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    @include('layouts.footer_files')

</body>

</html>