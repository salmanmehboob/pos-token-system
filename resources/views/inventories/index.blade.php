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
                    <form id="productForm" class="ajax-form" data-table="inventoryTable"
                          action="{{ route('inventories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf




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
                            <label>Product <span class="text-danger">*</span></label>
                            <select name="product_id" class="single-select-placeholder select2"
                                    style="width: 100%;">
                                <option value="" disabled selected>Select a product</option>
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>

                            <div id="product_idError" class="text-danger mt-1"></div>
                        </div>

                        <div class="form-group">
                            <label> Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" class="form-control" placeholder="Quantity">
                            <div id="quantityError" class="text-danger mt-1"></div>
                        </div>


{{--                        <div class="form-group">--}}
{{--                            <label> Image</label>--}}
{{--                            <input type="file" name="image" class="form-control">--}}
{{--                            <div id="imageError" class="text-danger mt-1"></div>--}}
{{--                            <img src="" id="uploadedImage" class="d-none" width="50" height="50" alt="Image">--}}
{{--                        </div>--}}

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



                    // Edit Button Click
                    $(document).on('click', '#editBtn', function(e) {
                        e.preventDefault();

                        // Get data attributes from the button
                        let id = $(this).data('id');
                        // let image = $(this).data('image');
                        let quantity = $(this).data('quantity');
                        let categoryId = $(this).data('category'); // Fixed here
                        let productId = $(this).data('product');
                        let formAction = $(this).data('url');

                        console.log(id,name,image,quantity,costPrice,retailPrice,categoryId,formAction);
                        // return false;
                        // Set the form action and method
                        $('form').attr('action', formAction);
                        $('form').append('@method("PUT")');




                        // Populate input fields
                        $('input[name="id"]').val(id);
                        // $('input[name="image"]').val(image);
                        $('input[name="quantity"]').val(quantity);
                        $('select[name="product_category_id"]').val(categoryId).trigger('change'); // Fixed here
                        $('select[name="product_id"]').val(productId).trigger('change');

                        console.log($('input[name="quantity"]').val())

                        // $('#uploadedImage').attr('src',image).removeClass('d-none');

                        // Update button and show modal
                        $('#submitBtn').text('Update');
                        $('#cancelBtn').removeClass('d-none');
                    });


                    // Reset form on new category add
                    $(document).on('click', '#cancelBtn', function() {
                        $('form').attr('action', "{{ route('inventories.store') }}"); // Reset to store action
                        $('form').find('input[name="_method"]').remove(); // Remove the PUT method
                        $('input[name="quantity"]').val('');
                        $('select[name="product_category_id"]').val('').trigger('change');
                        $('select[name="product_id"]').val('').trigger('change');
                        $('#submitBtn').text('Save'); // Reset button text
                        $(this).addClass('d-none');
                        // $('#uploadedImage').attr('src','').addClass('d-none');
                    });



                });
            </script>

    @endpush
