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
                <form id="productForm" class="ajax-form" data-table="productTable"
                    action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf


                    <div class="form-group">
                        <label> Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Name">
                        <div id="nameError" class="text-danger mt-1"></div>
                    </div>


                    <div class="form-group">
                        <label>Category <span class="text-danger">*</span></label>
                        <select name="product_category_id" class="single-select-placeholder select2"
                            style="width: 100%;">
                            <option value="" disabled selected>Select a category</option>
                            @foreach($productCategories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>

                        <div id="category_idError" class="text-danger mt-1"></div>
                    </div>

                    <div class="form-group">
                        <label> Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" class="form-control" placeholder="Quantity">
                        <div id="quantityError" class="text-danger mt-1"></div>
                    </div>

                    <div class="form-group">
                        <label> Cost Price <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="cost_price" class="form-control"
                            placeholder="Cost Price">
                        <div id="costPriceError" class="text-danger mt-1"></div>
                    </div>

                    <div class="form-group">
                        <label> Retail Price <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="retail_price" class="form-control"
                            placeholder="Retail Price">
                        <div id="retailPriceError" class="text-danger mt-1"></div>
                    </div>

                    <div class="form-group">
                        <label> Image</label>
                        <input type="file" name="image" class="form-control">
                        <div id="imageError" class="text-danger mt-1"></div>
                    </div>

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
                    <table class="table table-bordered" id="productTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Cost Price</th>
                                <th>Retail Price</th>
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
    $(document).ready(function() {
        // DataTable Initialization
        const table = $('#productTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('products.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    data: 'image',
                    name: 'image'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'cost_price',
                    name: 'cost_price'
                },
                {
                    data: 'retail_price',
                    name: 'retail_price'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        // Edit Button Click
        $(document).on('click', '#editBtn', function(e) {
            e.preventDefault();

            // Get data attributes from the button
            let id = $(this).data('id');
            let name = $(this).data('name');
            let image = $(this).data('image');
            let quantity = $(this).data('quantity');
            let costPrice = $(this).data('cost_price');
            let retailPrice = $(this).data('retail_price');
            let categoryId = $(this).data('category'); // Fixed here
            let formAction = $(this).data('url');

            // Set the form action and method
            $('form').attr('action', formAction);
            $('form').append('@method("PUT")');

            // Populate input fields
            $('input[name="id"]').val(id);
            $('input[name="name"]').val(name);
            $('input[name="image"]').val(image);
            $('input[name="quantity"]').val(quantity);
            $('input[name="cost_price"]').val(costPrice);
            $('input[name="retail_price"]').val(retailPrice);
            $('select[name="product_category_id"]').val(categoryId).trigger('change'); // Fixed here

            // Update button and show modal
            $('#submitBtn').text('Update');
            $('#cancelBtn').removeClass('d-none');
        });


        // Reset form on new category add
        $(document).on('click', '#cancelBtn', function() {
            $('form').attr('action', "{{ route('products.store') }}"); // Reset to store action
            $('form').find('input[name="_method"]').remove(); // Remove the PUT method
            $('input[name="name"]').val('');
            $('input[name="quantity"]').val('');
            $('input[name="cost_price"]').val('');
            $('input[name="retail_price"]').val('');
            $('select[name="product_category_id"]').val('').trigger('change');
            $('#submitBtn').text('Save'); // Reset button text
            $(this).addClass('d-none');
        });

    });
    </script>

    @endpush