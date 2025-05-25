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
                    <form id="employeeForm" class="ajax-form" data-table="employeeTable"
                          action="{{ route('employees.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" placeholder="First Name">
                            <div id="firstNameError" class="text-danger mt-1"></div>
                        </div>

                        <div class="form-group">
                            <label>Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                            <div id="lastNameError" class="text-danger mt-1"></div>
                        </div>

                        <button type="submit" id="submitBtn" class="btn btn-primary mt-3 float-end submit-btn">Save
                        </button>
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
                    <h6>{{ $title }} List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="employeeTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        $(document).ready(function () {

            // DataTable Initialization
            const table = $('#employeeTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('employees.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'first_name', name: 'first_name'},
                    {data: 'last_name', name: 'last_name'},
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Edit Button Click
            $(document).on('click', '#editBtn', function (e) {
                 e.preventDefault();

                console.log($(this).data('first'))
                let id = $(this).data('id');
                let firstName = $(this).data('first');
                let lastName = $(this).data('last');
                let formAction = $(this).data('url');

                // Update form for editing
                let $form = $('form');
                $form.attr('action', formAction);

                if (!$form.find('input[name="_method"]').length) {
                    $form.append('<input type="hidden" name="_method" value="PUT">');
                }

                // Populate fields
                $('input[name="first_name"]').val(firstName);
                $('input[name="last_name"]').val(lastName);

                $('#submitBtn').text('Update');
                $('#cancelBtn').removeClass('d-none');
            });


            // Cancel Button Click
            $(document).on('click', '#cancelBtn', function () {
                let $form = $('form');
                $form.attr('action', "{{ route('employees.store') }}");
                $form.find('input[name="_method"]').remove();
                $('input[name="first_name"]').val('');
                $('input[name="last_name"]').val('');
                $('#submitBtn').text('Save');
                $(this).addClass('d-none');
            });

        });
    </script>


@endpush
