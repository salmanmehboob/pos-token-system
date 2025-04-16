$(document).ready(function () {
    // Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        console.error('jQuery is not loaded.');
        return;
    }

    // Check if Toastr is loaded
    if (typeof toastr === 'undefined') {
        console.error('Toastr is not loaded.');
        return;
    }

// Access session messages from the global `window.sessionMessages` object
    const messages = window.sessionMessages || {};

    if (messages.success) {
        toastr.success(messages.success, "Success", {
            timeOut: 5000,
            closeButton: true,
            debug: false,
            newestOnTop: true,
            progressBar: true,
            positionClass: "toast-top-right",
            preventDuplicates: true,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: false
        });
    }

    if (messages.error) {
        toastr.error(messages.error, "Error", {
            timeOut: 5000,
            closeButton: true,
            debug: false,
            newestOnTop: true,
            progressBar: true,
            positionClass: "toast-top-right",
            preventDuplicates: true,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: false
        });
    }

    if (messages.info) {
        toastr.info(messages.info, "Info", {
            timeOut: 5000,
            closeButton: true,
            debug: false,
            newestOnTop: true,
            progressBar: true,
            positionClass: "toast-top-right",
            preventDuplicates: true,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: false
        });
    }

    if (messages.warning) {
        toastr.warning(messages.warning, "Warning", {
            timeOut: 5000,
            closeButton: true,
            debug: false,
            newestOnTop: true,
            progressBar: true,
            positionClass: "toast-top-right",
            preventDuplicates: true,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: false
        });
    }


    // Initialize DataTables
    if ($.fn.dataTable) {

        $('.datatable').DataTable({
            createdRow: function (row, data, index) {
                $(row).addClass('selected')
            },
            language: {
                paginate: {
                    next: '>',
                    previous: '<'
                }
            }
        });
    } else {
        console.error('DataTables is not loaded.');
    }


    if ($.fn.select2) {
        $('.select2').select2({
            placeholder: "Select Option"
        });
    } else {
        console.error('Select2 is not loaded.');
    }

    // Initialize Select2

///////////////////////////////////AJAX Function Started/////////////////////////////////////
    $(document).on('click', '.delete-record', function (e) {
        e.preventDefault();

        const url = $(this).data('url'); // Get delete URL
         const dataTable = $(this).data('table');   // Get record ID


        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: {
                        "_token": CSRF_TOKEN
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.success, "Deleted!", {
                                timeOut: 2000,
                                closeButton: true,
                                progressBar: true,
                                positionClass: "toast-top-right",
                                preventDuplicates: true
                            });


                            // Reload the DataTable on success
                            setTimeout(function () {
                                $('#' + dataTable).DataTable().ajax.reload(null, false);
                            }, 1000);


                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.error,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong. Please try again later.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });

    $(document).on('submit', '.ajax-form', function (e) {
        e.preventDefault();

        let form = $(this);
        let datatable = form.data('table');
        let url = form.attr('action');
        let submitBtn = form.find('.submit-btn');
        let errorContainer = form.find('.text-danger');

        // Create a FormData object for file upload
        let formData = new FormData(this);

        // Clear any previous errors
        errorContainer.text('');
        submitBtn.prop('disabled', true);

        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            processData: false,  // Prevent jQuery from automatically transforming the data into a query string
            contentType: false,  // Let the browser set the content type (multipart/form-data)
            success: function (response) {
                toastr.success(response.success, "Success!", {
                    timeOut: 2000,
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    preventDuplicates: true
                });

                // Reload the DataTable after 1 second
                setTimeout(function () {
                    $('#' + datatable).DataTable().ajax.reload(null, false);
                }, 1000);

                // Reset the form
                form[0].reset();
                submitBtn.prop('disabled', false);
            },
            error: function (xhr) {
                submitBtn.prop('disabled', false);

                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, message) {
                        form.find(`#${key}Error`).text(message[0]);
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again later.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });


//==================================AJAX Ended==================================================//
});
