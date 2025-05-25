@extends('layouts.app')
@section('title', $title)

@section('content')


<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-header">
                    <h6>{{ $title}} Form</h6>
                </div>
            </div>
            <div class="card-body">
                <form id="inventoryForm" class="ajax-form" data-table="inventoryTable"
                    action="{{ route('inventories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf




                    <div class="form-group">
                        <label>Category <span class="text-danger">*</span></label>
                        <select name="product_category_id" id="product_category_id" class="form-control select2">
                            <option value="">Select Category</option>
                            @foreach($productCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <div id="category_idError" class="text-danger mt-1"></div>
                    </div>


                    <div class="form-group">
                        <label>Product <span class="text-danger">*</span></label>
                        <select name="product_id" id="product_id" class="form-control select2">
                            <option value=""></option>
                            {{-- Options will be filled via AJAX --}}
                        </select>

                        <div id="product_idError" class="text-danger mt-1"></div>
                    </div>

                    <div class="form-group">
                        <label> Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" class="form-control" placeholder="Quantity">
                        <div id="quantityError" class="text-danger mt-1"></div>
                    </div>


                    {{-- <div class="form-group">--}}
                    {{-- <label> Image</label>--}}
                    {{-- <input type="file" name="image" class="form-control">--}}
                    {{-- <div id="imageError" class="text-danger mt-1"></div>--}}
                    {{-- <img src="" id="uploadedImage" class="d-none" width="50" height="50" alt="Image">--}}
                    {{-- </div>--}}

                    <button type="submit" id="submitBtn" class="btn btn-primary mt-3 float-end submit-btn">Save</button>
                    <button type="button" id="cancelBtn" class="btn btn-secondary mt-3 float-end me-2 d-none">
                        Cancel Update
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-header">
                    <h6>{{ $title}} List</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="inventoryTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


    @endsection


    @push('js')
    <script>
        
    // Make the function global so it can be reused
    function loadProductsByCategory(categoryId, selectedProductId = null) {
        let productDropdown = $('#product_id');
        productDropdown.empty().append('<option value="">Loading...</option>');

        if (categoryId) {
            $.ajax({
                url: '/products-by-category',
                type: 'GET',
                data: {
                    category_id: categoryId
                },
                success: function(data) {
                    productDropdown.empty().append('<option value="">Select Product</option>');
                    $.each(data, function(index, product) {
                        productDropdown.append(
                            `<option value="${product.id}">${product.name}</option>`
                        );
                    });

                    if (selectedProductId) {
                        productDropdown.val(selectedProductId).trigger('change');
                    }

                    productDropdown.trigger('change'); // refresh select2
                },
                error: function() {
                    productDropdown.empty().append(
                        '<option value="">Error loading products</option>');
                }
            });
        } else {
            productDropdown.empty().append('<option value="">Select Product</option>');
        }
    }





    $(document).ready(function() {

        // DataTable Initialization
        const table = $('#inventoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('inventories.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        //

        // Category change listener (works for both create and edit)
        $(document).on('change', '#product_category_id', function() {
            const categoryId = $(this).val();

            // Remove selected product (if any)
            $('#product_id').val(null).trigger('change');

            // Reload products for the selected category
            loadProductsByCategory(categoryId);
        });


        // Edit Button Click
        $(document).on('click', '#editBtn', function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let quantity = $(this).data('quantity');
            let categoryId = $(this).data('category');
            let productId = $(this).data('product');
            let formAction = $(this).data('url');

            const form = $('form');

            // Set the action URL and spoof the PUT method
            form.attr('action', formAction);
            form.find('input[name="_method"]').remove();
            form.append('<input type="hidden" name="_method" value="PUT">');

            // Fill the form fields
            form.find('input[name="quantity"]').val(quantity);
            form.find('select[name="product_category_id"]').val(categoryId).trigger('change');

            // Load and pre-select product
            loadProductsByCategory(categoryId, productId);

            // Update button
            $('#submitBtn').text('Update');
            $('#cancelBtn').removeClass('d-none');
        });



        // Reset form on new category add
        // Reset form when Cancel button is clicked
        $(document).on('click', '#cancelBtn', function() {
            const form = $('form');

            // Reset form attributes and fields
            form.attr('action', "{{ route('inventories.store') }}");
            form.find('input[name="_method"]').remove();
            form.trigger('reset');

            // Reset Select2 dropdowns
            $('#product_category_id').val('').trigger('change');
            $('#product_id').empty().append('<option value="">Select Product</option>').trigger(
                'change');

            // Reset button states
            $('#submitBtn').text('Save');
            $(this).addClass('d-none');
        });


    });
    </script>

    @endpush