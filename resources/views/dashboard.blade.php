@extends('layouts.app')
@section('content')

<div class="row">


    {{--POS Section --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <a href="{{ route('sales.pos') }}" style="text-decoration: none;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="text-xl font-weight-bold text-primary text-uppercase col mr-2">POS</div>
                        <div class="col-auto">
                            <i class="fas fa-cash-register fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>





    {{--Categories Section --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <a href="{{ route('product.categories.index') }}" style="text-decoration: none;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Categories</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$categoriesCount}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-th-large fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>


    {{--Products Section --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <a href="{{ route('products.index') }}" style="text-decoration: none;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Products</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$productsCount}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>



    {{--Inventories Section --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <a href="{{ route('inventories.index') }}" style="text-decoration: none;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Inventories</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$inventoriesCount}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{--Histories Section --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <a href="{{ route('histories.index') }}" style="text-decoration: none;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Histories</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$historiesCount}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-history fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>


    {{--Orders Section --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <a href="{{ route('orders') }}" style="text-decoration: none;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$ordersCount}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>



</div>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ $title }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Today Sales ({{date('D')}})</th>
                                <th>This Month Sales ({{date('M')}})</th>
                                <th>This year Sales ({{date('Y')}})</th>
                            </tr>

                        </thead>
                        <tbody>
                            <tr>
                                <td>Rs. {{$totalSalesToday}}</td>
                                <td>Rs. {{$totalSalesThisMonth}}</td>
                                <td>Rs. {{$totalSalesThisYear}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection