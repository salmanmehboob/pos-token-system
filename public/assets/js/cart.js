$(document).ready(function () {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    toastr.options.timeOut = 1000; // 2 seconds

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': csrfToken}
    });

    function loadCart() {
        $.get(window.cartRoutes.get, function (cartItems) {
            updateCartUI(cartItems);
        });
    }

    function loadMetaCart() {
        $.get(window.cartRoutes.meta, function (meta) {

            $('.subtotal').text(`Rs. ${meta.sub_total}`);
            $('.discount').text(`Rs. ${meta.discount}`);
            $('.total').text(`Rs. ${meta.total}`);

        });
    }

    function updateCartUI(items) {
        let html = '';
        if (!items || items.length === 0) {
            loadMetaCart();
             html = `<div class="text-center py-5">
                <i class="fa fa-shopping-cart fa-3x text-muted"></i>
                <p class="mt-3">Your cart is empty</p>
            </div>`;
        } else {
            let subtotal = 0;
            items.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                html += `
                <div class="pos-order" data-item-id="${item.id}">
                    <div class="pos-order-product">
                        <div class="img" style="background-image: url('${item.product.image}')"></div>
                        <div class="flex-1">
                            <div class="h6 mb-1">${item.product_name}</div>
                            <div class="small mb-2">Rs. ${item.price}</div>
                            <div class="d-flex">
                                <a href="#" class="btn btn-secondary btn-sm cart-decrease" data-id="${item.id}"><i class="fa fa-minus"></i></a>
                                <input type="text" class="form-control w-50px mx-2 text-center cart-quantity" value="${item.quantity}" data-id="${item.id}">
                                <a href="#" class="btn btn-secondary btn-sm cart-increase" data-id="${item.id}"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="pos-order-price d-flex flex-column">
                        <div class="flex-1">Rs. ${itemTotal}</div>
                        <div class="text-end">
                            <a href="#" class="btn btn-default btn-sm cart-remove" data-id="${item.id}"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                </div>`;
            });

            loadMetaCart();
        }
        $('#newOrderTab').html(html);
    }

    $(document).on('click', '.pos-product', function (e) {
        e.preventDefault();
        $.post(window.cartRoutes.store, { product_id: $(this).data('id') }, function (res) {
            loadCart();
            if (res.success && res.message) {
                // toastr.success(res.message);
            }
        });


    });

    $(document).on('click', '.cart-increase', function (e) {
        e.preventDefault();
        const input = $(this).siblings('.cart-quantity');
        input.val(parseInt(input.val()) + 1).trigger('change');
    });

    $(document).on('click', '.cart-decrease', function (e) {
        e.preventDefault();
        const input = $(this).siblings('.cart-quantity');
        const currentQty = parseInt(input.val());

        if (currentQty > 1) {
            input.val(currentQty - 1).trigger('change');
        } else {
            // Optional: shake or notify user
            input.val(1); // enforce min 1
        }
    });


    $(document).on('change', '.cart-quantity', function () {
        const id = $(this).data('id');
        let qty = parseInt($(this).val());

        if (isNaN(qty) || qty < 1) {
            qty = 1; // enforce min 1
            $(this).val(qty); // reflect change in input
        }

        updateCartItem(id, qty);
    });


    $(document).on('click', '.cart-remove', function (e) {
        e.preventDefault();
        deleteCartItem($(this).data('id'));
    });

    function updateCartItem(id, qty) {
        $.ajax({
            url: window.cartRoutes.update.replace(':id', id),
            type: 'PUT',
            data: {quantity: qty},
            success: function (res) {
                loadCart();
                if (res.success && res.message) {
                    // toastr.success(res.message);
                }
            }
        });

    }

    function deleteCartItem(id) {
        $.ajax({
            url: window.cartRoutes.destroy.replace(':id', id),
            type: 'DELETE',
            success: function (res) {
                loadCart();
                if (res.success && res.message) {
                    toastr.success(res.message);
                }
            }
        });
    }

    function applyDiscount(discount) {
        $.post(window.cartRoutes.applyDiscount, { discount }, function (res) {
            loadCart();
            if (res.success && res.message) {
                toastr.success(res.message);
            }
        });
        $('#discount-input').val('');
    }

    $(document).on('click', '.apply-discount', function () {
        const discount = parseFloat($('#discount-input').val()) || 0;
        applyDiscount(discount);
    });

    loadCart();
});
