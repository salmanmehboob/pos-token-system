@extends('layouts.pos')
@section('title', $title)

@section('content')

<!-- BEGIN pos-menu -->
<div class="pos-menu">
    <div class="logo">
        <a href="{{ route('home') }}">
            <div class="logo-img"><i class="fa fa-arrow-left"></i></div>
            <div class="logo-text">Dashboard</div>

        </a>
    </div>
    <div class="nav-container">
        <div class="h-100" data-scrollbar="true" data-skip-mobile="true">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-filter="all">
                        <i class="fa fa-fw fa-utensils"></i>All
                    </a>
                </li>
                @foreach ($productCategories as $category)
                <li class="nav-item">
                    <a class="nav-link p-4" href="#" data-filter="cat-{{ $category->id }}">
                        {{ $category->name }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<!-- END pos-menu -->

<!-- BEGIN pos-content -->
<div class="pos-content">
    <div class="pos-content-container h-100">
        <div class="row gx-4">
            @foreach($products as $product)
            @php $imagePath = asset($product->image); @endphp
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 pb-4 product-item"
                data-type="cat-{{ $product->product_category_id }}"
                data-category-id="{{ $product->product_category_id }}">
                <a href="javascript:;" class="pos-product" data-id="{{ $product->id }}">
                    <div class="img" style="background-image: url('{{ $imagePath }}');"></div>
                    <div class="info">
                        <div class="title">{{ $product->name }}</div>
                        <div class="retail_price">Rs {{ $product->retail_price }}</div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="pos-sidebar" id="pos-sidebar">
            <div class="h-100 d-flex flex-column p-0">
                <div class="nav-tabs">
                    <h3 style="margin-left: 7.5rem; padding-top: 1rem;">Your Cart</h3>
                </div>
                <div class="pos-sidebar-body tab-content" data-scrollbar="true" data-height="100%">
                    <div class="tab-pane fade h-100 show active" id="newOrderTab"></div>
                </div>
                <div class="pos-sidebar-footer">
                    <div class="d-flex align-items-center mb-2">
                        <div>Subtotal</div>
                        <div class="flex-1 text-end h6 mb-0 subtotal">Rs. 0</div>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div>Discount</div>
                        <div class="flex-1 text-end h6 mb-0 discount">Rs. 0</div>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div>Total</div>
                        <div class="flex-1 text-end h4 mb-0 total">Rs. 0</div>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <input type="number" id="discount-input" class="form-control" placeholder="Discount Amount">
                        <button class="btn btn-sm btn-success apply-discount ms-2">Apply</button>
                    </div>

                    <form id="orderForm" action="{{ route('order.place') }}" method="POST" class="d-flex">
                        @csrf
                        <button type="submit"
                            class="btn btn-theme flex-fill d-flex align-items-center justify-content-center">
                            <span>
                                <i class="fa fa-cash-register fa-lg my-10px d-block"></i>
                                <span class="small fw-semibold">Order Now</span>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection