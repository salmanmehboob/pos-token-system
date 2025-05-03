@extends('layouts.pos')
@section('title', $title)

@section('content')

<!-- BEGIN pos-menu -->
<div class="pos-menu">
    <!-- BEGIN logo -->
    <div class="logo">
        <a href="index.html">
            <div class="logo-img"><i class="fa fa-bowl-rice"></i></div>
            <div class="logo-text">Pine & Dine</div>
        </a>
    </div>
    <!-- END logo -->
    <!-- BEGIN nav-container -->
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
                        <!-- <i class="fa fa-fw fa-drumstick-bite"></i> -->
                        {{ $category->name }}
                    </a>
                </li>
                @endforeach

            </ul>
        </div>
    </div>
    <!-- END nav-container -->
</div>
<!-- END pos-menu -->

<!-- BEGIN pos-content -->
<div class="pos-content">
    <div class="pos-content-container h-100">
        <div class="row gx-4">

            <!-- Example product item -->
            @foreach($products as $product)
            @php
            $imagePath = asset($product->image); // Ensure $product->image stores the correct relative path like
            'uploads/products/xyz.jpg'
            @endphp
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



        <!-- BEGIN pos-sidebar -->
        <div class="pos-sidebar" id="pos-sidebar">
            <div class="h-100 d-flex flex-column p-0">


                <!-- BEGIN pos-sidebar-nav -->
                <div class="nav-tabs ">

                    <h3 style="margin-left: 7.5rem; padding-top: 1rem;">Your Cart</h3>

                </div>
                <!-- END pos-sidebar-nav -->




                <!-- BEGIN pos-sidebar-body -->
                <div class="pos-sidebar-body tab-content" data-scrollbar="true" data-height="100%">
                    <!-- BEGIN #newOrderTab -->
                    <div class="tab-pane fade h-100 show active" id="newOrderTab">
                        <!-- BEGIN pos-order -->

                        <!-- END pos-order -->
                    </div>

                </div>
                <!-- END pos-sidebar-body -->





                <!-- BEGIN pos-sidebar-footer -->
                <div class="pos-sidebar-footer">
                    <div class="d-flex align-items-center mb-2">
                        <div>Subtotal</div>
                        <div class="flex-1 text-end h6 mb-0 subtotal">Rs. 0</div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div>Discounts</div>
                        <div class="flex-1 text-end h6 mb-0">Rs. 0</div>
                    </div>
                    <hr class="opacity-1 my-10px">
                    <div class="d-flex align-items-center mb-2">
                        <div>Total</div>
                        <div class="flex-1 text-end h4 mb-0 total">Rs. 0</div>
                    </div>

                    <div class="d-flex align-items-center mb-2">
                        <input type="number" id="discount-input" class="form-control" placeholder="Discount Amount">
                        <button class="btn btn-sm btn-success apply-discount ms-2">Apply</button>
                    </div>

                </div>
                <!-- END pos-sidebar-footer -->
            </div>
        </div>
        <!-- END pos-sidebar -->




    </div>
</div>


@endsection


@push('js')

<script>
if (typeof jQuery == 'undefined') {
    console.error('jQuery is not loaded!');
}
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    console.log('Document ready');
    console.log('CSRF Token:', csrfToken);
    console.log('Cart route:', "{{ route('carts.store') }}");
    // Load initial cart
    loadCart();

    // Click product to add/increment in cart
    $(document).on('click', '.pos-product', function(e) {
        e.preventDefault();
        e.stopPropagation(); // Add this line

        const productId = $(this).data('id');
        console.log('Adding product:', productId); // Debug log

        $.ajax({
            url: "{{ route('carts.store') }}",
            type: 'POST',
            data: {
                product_id: productId,
                _token: csrfToken
            },
            success: function(response) {
                console.log('Add to cart response:', response); // Debug log
                if (response.success) {
                    loadCart();
                }
            },
            error: function(err) {
                console.error('Failed to add product to cart', err);
            }
        });
    });

    // Load cart in sidebar
    function loadCart() {
        $.get("{{ route('carts.index') }}", function(response) {
            updateCartUI(response);
        }).fail(function(err) {
            console.error('Failed to load cart', err);
        });
    }

    // Update cart UI
    function updateCartUI(cartItems) {
        let html = '';
        let subtotal = 0;

        if (cartItems.length === 0) {
            html = `<div class="text-center py-5">
              <i class="fa fa-shopping-cart fa-3x text-muted"></i>
              <p class="mt-3">Your cart is empty</p>
           </div>`;
        } else {
            cartItems.forEach(item => {
                const price = item.price;
                const total = price * item.quantity;
                subtotal += total;

                html += `
        <div class="pos-order" data-item-id="${item.id}">
            <div class="pos-order-product">
                <div class="img" style="background-image: url('${item.product.image}')"></div>
                <div class="flex-1">
                    <div class="h6 mb-1">${item.product_name}</div>
                    <div class="small mb-2">Rs. ${price.toFixed(2)}</div>
                    <div class="d-flex">
                        <a href="#" class="btn btn-secondary btn-sm cart-decrease" data-id="${item.id}">
                            <i class="fa fa-minus"></i>
                        </a>
                        <input type="text" 
                               class="form-control w-50px mx-2 text-center cart-quantity" 
                               value="${item.quantity}" 
                               data-id="${item.id}">
                        <a href="#" class="btn btn-secondary btn-sm cart-increase" data-id="${item.id}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="pos-order-price d-flex flex-column">
                <div class="flex-1">Rs. ${total.toFixed(2)}</div>
                <div class="text-end">
                    <a href="#" class="btn btn-default btn-sm cart-remove" data-id="${item.id}">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </div>
        </div>`;
            });
        }


        // Update cart items
        $('.pos-sidebar-body .tab-pane').html(html);

        // Update totals
        $('.pos-sidebar-footer').find('div:contains("Subtotal")').next().text(`Rs. ${subtotal.toFixed(2)}`);
        $('.pos-sidebar-footer').find('div:contains("Total")').next().text(`Rs. ${subtotal.toFixed(2)}`);

    }

    // Quantity increase
    $(document).on('click', '.cart-increase', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const input = $(this).siblings('.cart-quantity');
        const newQty = parseInt(input.val()) + 1;
        input.val(newQty).trigger('change');
    });

    // Quantity decrease
    $(document).on('click', '.cart-decrease', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const input = $(this).siblings('.cart-quantity');
        const newQty = parseInt(input.val()) - 1;

        if (newQty > 0) {
            input.val(newQty).trigger('change');
        } else {
            deleteCartItem(id);
        }
    });

    // Manual quantity change
    $(document).on('change', '.cart-quantity', function() {
        const id = $(this).data('id');
        const quantity = $(this).val();

        if (quantity > 0) {
            updateCartItem(id, quantity);
        } else {
            deleteCartItem(id);
        }
    });

    // Remove item
    $(document).on('click', '.cart-remove', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        deleteCartItem(id);
    });

    // Update cart item quantity
    function updateCartItem(id, quantity) {
        $.ajax({
            url: `{{ route("carts.update", ":id") }}`.replace(':id', id),
            type: 'PUT',
            data: {
                quantity: quantity,
                _token: csrfToken
            },
            success: function(response) {
                if (response.success) {
                    loadCart();
                }
            },
            error: function(err) {
                console.error('Failed to update cart item', err);
            }
        });
    }

    // Delete cart item
    function deleteCartItem(id) {
        $.ajax({
            url: `{{ route("carts.destroy", ":id") }}`.replace(':id', id),
            type: 'DELETE',
            data: {
                _token: csrfToken
            },
            success: function(response) {
                if (response.success) {
                    loadCart();
                }
            },
            error: function(err) {
                console.error('Failed to remove cart item', err);
            }
        });
    }

    // Discount application (you'll need to add this to your HTML)
    $(document).on('click', '.apply-discount', function() {
        const discount = parseFloat($('#discount-input').val()) || 0;

        $.ajax({
            url: "{{ route('carts.apply-discount') }}", // You'll need to add this route
            type: 'POST',
            data: {
                discount: discount,
                _token: csrfToken
            },
            success: function(response) {
                if (response.success) {
                    loadCart();
                }
            }
        });
    });
});
</script>



@endpush