<!DOCTYPE html>

<html lang="en">
<head>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Laravel DataTable Ajax Crud Tutorial - Tuts Make</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="container">
    <h2>Laravel DataTable Ajax Crud Tutorial - <a href="https://www.tutsmake.com" target="_blank">TutsMake</a></h2>
    <br>
    <a href="/" class="btn btn-primary">Back to Main</a>
    <br><br>
    <a href="https://www.tutsmake.com/how-to-install-yajra-datatables-in-laravel/" class="btn btn-secondary">Back to Post</a>
    <a href="javascript:void(0)" class="btn btn-info ml-3" id="create-new-product">Add New</a>
    <br><br>

    <table class="table table-bordered table-striped" id="laravel_datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>S. No</th>
                <th>Title</th>
                <th>Product Code</th>
                <th>Description</th>
                <th>Created at</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
    </div>

    <div class="modal fade" id="ajax-product-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="productCrudModal"></h4>
                </div>
                <form id="productForm" name="productForm" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" name="product_id" id="product_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Title</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label">Product Code</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="product_code" name="product_code" placeholder="Enter Product Code" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="" required="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-offset-8 col-sm-4">
                            <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Dependencies --}}
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

    <script>
        $(document).ready( function () {


            // Set up Header before ajaxRequestCall
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // List all data when page loaded
            $('#laravel_datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "/product-list",
                        type: 'GET',
                    },
                    columns: [
                            {data: 'id', name: 'id', 'visible': false},
                            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
                            {data: 'title', name: 'title' },
                            {data: 'product_code', name: 'product_code' },
                            {data: 'description', name: 'description' },
                            {data: 'created_at', name: 'created_at' },
                            {data: 'action', name: 'action', orderable: false},
                        ],
                    order: [[0, 'desc']]
                });

            /*  When user click add user button */
            $('#create-new-product').click(function () {
                $('#btn-save').val("create-product");

                // Reset all form data
                $('#product_id').val('');
                    // Reset all input data to ''
                $('#productForm').trigger("reset");
                $('#productCrudModal').html("Add New Product");

                $('#ajax-product-modal').modal('show');
            });

            /* When click edit user */
            $('body').on('click', '.edit-product', function () {
                var product_id = $(this).data('id');
                $.get('product-list/' + product_id +'/edit', function (data) {

                    $('#title-error').hide();
                    $('#product_code-error').hide();
                    $('#description-error').hide();

                    // Modal header
                    $('#productCrudModal').html("Edit Product");
                    $('#btn-save').val("edit-product");
                    $('#ajax-product-modal').modal('show');

                    // Input data form
                    $('#product_id').val(data.id);
                    $('#title').val(data.title);
                    $('#product_code').val(data.product_code);
                    $('#description').val(data.description);

                })
            });

            $('body').on('click', '.delete-product', function () {

                var product_id = $(this).data("id");

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: 'Data yang akan dihapus tidak akan dapat dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if(result.value) {
                        Swal.fire({
                            title: 'Menunggu respon dari server',
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                            onOpen: () => {
                                $.ajax({
                                    type: "get",
                                    url: "/product-list/delete/"+product_id,
                                    success: function (data) {
                                        // Old API redraw Table
                                        var oTable = $('#laravel_datatable').dataTable();
                                        oTable.fnDraw(false);

                                        Swal.fire(
                                            'Terhapus!',
                                            'Data anda berhasil dihapus.',
                                            'success'
                                        )

                                    },
                                    error: function (data) {
                                        console.log('Error:', data);

                                        Swal.fire(
                                            'Error!',
                                            `Error: ${data.statusText}`,
                                            'error'
                                        )
                                    }
                                });
                            }
                        })
                    } else if(result.dismiss === Swal.DismissReason.cancel){
                        Swal.fire(
                            'Dibatalkan!',
                            'Penghapusan data telah dibatalkan.',
                            'error'
                        )
                    }
                })

            });
        });

        // Handle Create and Edit
        if ($("#productForm").length > 0) {
            $("#productForm").validate({
                submitHandler: function(form) {
                    var actionType = $('#btn-save').val();
                    // $('#btn-save').html('Sending..');
                    Swal.fire({
                        title: 'Menunggu respon dari server',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                        onOpen: () => {
                            $.ajax({
                                data: $('#productForm').serialize(),
                                url: "/product-list/store",
                                type: "POST",
                                dataType: 'json',
                                success: function (data) {

                                    $('#productForm').trigger("reset");
                                    $('#ajax-product-modal').modal('hide');
                                    $('#btn-save').html('Save Changes');
                                    var oTable = $('#laravel_datatable').dataTable();
                                    oTable.fnDraw(false);

                                    Swal.fire(
                                        'Tersimpan!',
                                        'Data anda berhasil disimpan.',
                                        'success'
                                    )

                                },
                                error: function (data) {
                                    console.log('Error:', data);

                                    Swal.fire(
                                        'Error!',
                                        `Error: ${data.statusText}`,
                                        'error'
                                    )
                                }
                            });
                        }
                    })
                }
            })
        }
    </script>
</body>

</html>
