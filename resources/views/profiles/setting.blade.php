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
                <form id="settingForm" class="ajax-form" data-table="settingTable"
                    action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf


                    <div class="form-group">
                        <label>Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="comp_name" class="form-control" placeholder="Company Name">
                        <div id="comp_nameError" class="text-danger mt-1"></div>
                    </div>

                    <div class="form-group">
                        <label>Company Address <span class="text-danger">*</span></label>
                        <textarea name="comp_address" class="form-control" id="comp_address" cols="30"
                            rows="5"></textarea>
                        <div id="comp_addressError" class="text-danger mt-1"></div>
                    </div>


                    <div class="form-group">
                        <label> Company Phone <span class="text-danger">*</span></label>
                        <input type="phone" name="comp_phone" class="form-control" placeholder="Company Phone">
                        <div id="comp_phoneError" class="text-danger mt-1"></div>
                    </div>

                    <div class="form-group">
                        <label> Company Mobile <span class="text-danger">*</span></label>
                        <input type="phone" name="comp_mobile" class="form-control" placeholder="Company Mobile">
                        <div id="comp_mobileError" class="text-danger mt-1"></div>
                    </div>

                    <div class="form-group">
                        <label>Company Email <span class="text-danger">*</span></label>
                        <input type="email" name="comp_email" class="form-control" placeholder="Company Email">
                        <div id="comp_emailError" class="text-danger mt-1"></div>
                    </div>

                    <div class="form-group">
                        <label> Company Logo</label>
                        <input type="file" name="comp_logo" class="form-control">
                        <div id="comp_logoError" class="text-danger mt-1"></div>
                        <img src="" id="uploadedImage" class="d-none" width="50" height="50" alt="Image">
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
                    <table class="table table-bordered" id="settingTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Company Name</th>
                                <th>Company Address</th>
                                <th>Company Phone</th>
                                <th>Company Mobile</th>
                                <th>Company Email</th>
                                <th>Company Logo</th>
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
        const table = $('#settingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('settings.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'comp_name',
                    name: 'comp_name'
                }, {
                    data: 'comp_address',
                    name: 'comp_address'
                },
                {
                    data: 'comp_phone',
                    name: 'comp_phone'
                },

                {
                    data: 'comp_mobile',
                    name: 'comp_mobile'
                },
                {
                    data: 'comp_email',
                    name: 'comp_email'
                },
                {
                    data: 'comp_logo',
                    name: 'comp_logo'
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
            let companyName = $(this).data('comp_name');
            let compAddress = $(this).data('comp_address');
            let compPhone = $(this).data('comp_phone');
            let compMobile = $(this).data('comp_mobile');
            let compEmail = $(this).data('comp_email');
            let compLogo = $(this).data('comp_logo');
            let formAction = $(this).data('url');



            // Set the form action and method
            $('form').attr('action', formAction);
            $('form').append('@method("PUT")');




            // Populate input fields
            $('input[name="id"]').val(id);
            $('input[name="comp_name"]').val(companyName);
            $('input[name="comp_address"]').val(compAddress);
            $('input[name="comp_phone"]').val(compPhone);
            $('input[name="comp_mobile"]').val(compMobile);
            $('input[name="comp_email"]').val(compEmail);
            $('#uploadedImage').attr('src', compLogo).removeClass('d-none');

            // Update button and show modal
            $('#submitBtn').text('Update');
            $('#cancelBtn').removeClass('d-none');
        });


        // Reset form on new category add
        $(document).on('click', '#cancelBtn', function() {
            $('form').attr('action', "{{ route('settings.store') }}"); // Reset to store action
            $('form').find('input[name="_method"]').remove(); // Remove the PUT method
            $('input[name="comp_name"]').val('');
            $('input[name="comp_address"]').val('');
            $('input[name="comp_phone"]').val('');
            $('input[name="comp_mobile"]').val('');
            $('input[name="comp_email"]').val('');
            $('#submitBtn').text('Save'); // Reset button text
            $(this).addClass('d-none');
            $('#uploadedImage').attr('src', '').addClass('d-none');
        });



    });
    </script>

    @endpush