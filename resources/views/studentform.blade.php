<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">

    <title>AJAX CRUD</title>
</head>


<body>
    <!-- ADD Student Data Modal -->
    <div class="modal fade" id="studentaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Student Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addform">
                    <div class="modal-body">
                        {{-- Security token --}}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" name="fname" placeholder="Enter First Name">
                        </div>

                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" name="lname" placeholder="Enter Last Name">
                        </div>

                        <div class="form-group">
                            <label for="course">Course</label>
                            <input type="text" class="form-control" name="course" placeholder="Enter Course">
                        </div>

                        <div class="form-group">
                            <label for="section">Section</label>
                            <input type="text" class="form-control" name="section" placeholder="Enter Section">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Student Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End of ADD Student Data Modal --}}

    <!-- EDIT Student Data Modal -->
    <div class="modal fade" id="studenteditmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Student Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editform">
                    <div class="modal-body">
                        {{-- Security token --}}
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" name="fname" id="fname" placeholder="Enter First Name">
                        </div>

                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" name="lname" id="lname" placeholder="Enter Last Name">
                        </div>

                        <div class="form-group">
                            <label for="course">Course</label>
                            <input type="text" class="form-control" name="course" id="course" placeholder="Enter Course">
                        </div>

                        <div class="form-group">
                            <label for="section">Section</label>
                            <input type="text" class="form-control" name="section" id="section" placeholder="Enter Section">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Student Data Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End of EDIT Student Data Modal --}}

    {{-- DELETE Student Data Modal --}}
    <div class="modal fade" id="studentdeletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Student Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteform">
                    <div class="modal-body">
                        {{-- Security token --}}
                        {{ csrf_field() }}
                        {{ method_field('delete') }}

                        <input type="hidden" name="id" id="delete_id">
                        <p>Are you sure, you want to delete this data?</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete Student Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End of DELETE Student Data Modal --}}

    <div class="container">
        <div class="jumbotron">
            <div class="row">
                <h1>Laravel CRUD - AJAX jQuery using BootStrap MODAL</h1>
                <!-- Button trigger modal -->
                <a href="/" class="btn btn-primary">Back to Main</a>
                <br><br>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#studentaddmodal">
                    Student Add Data
                </button>
            </div>

            <br>

            <table id="student_table" class="table table-bordered table-striped table-dark">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Course</th>
                        <th scope="col">Section</th>
                        <th scope="col">ACTION</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Course</th>
                        <th scope="col">Section</th>
                        <th scope="col">ACTION</th>
                    </tr>
                </tfoot>
                <tbody id="student_data">
                    @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->fname }}</td>
                        <td>{{ $student->lname }}</td>
                        <td>{{ $student->course }}</td>
                        <td>{{ $student->section }}</td>
                        <td>
                            <a href="#" class="btn btn-success editbtn">Edit</a>
                            <a href="#" class="btn btn-danger deletebtn">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> --}}

    {{-- Latest jQuery --}}
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

    {{-- Moment.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/ja.js"></script>

    {{-- Default BootStrap --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    {{-- Node_modules dependencies --}}
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="sweetalert2/dist/sweetalert2.all.min.js"></script> --}}

    {{-- DataTables JS --}}
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

    {{-- CRUD Data Script --}}
    <script type="text/javascript">
        $(document).ready(function() {


        // Declare DataTables
        let table = $('#student_table').DataTable()

        // Create Data Script
            $('#addform').on('submit', function(e){
                e.preventDefault()

                $.ajax({
                    type: 'post',
                    url: '/studentadd',
                    data: $('#addform').serialize(),
                    success: function(response){
                        // console.log(response)
                        $('#studentaddmodal').modal('hide')

                        swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Data saved!',
                        })

                        // Force reload page
                        // location.reload()

                        // Data reload
                        refresh_data()
                    },
                    error: function(error){
                        console.log(error)
                        alert("Data Not Saved")
                    }
                })
            })
        })
        // End of Create Data Script

        // Edit Data Script
        $('.editbtn').click(function(){
            $('#studenteditmodal').modal('show')

            let tr = $(this).closest('tr')

            let data = tr.children('td').map(function(){
                return $(this).text()
            }).get()

            // console.log(data)

            $('#id').val(data[0])
            $('#fname').val(data[1])
            $('#lname').val(data[2])
            $('#course').val(data[3])
            $('#section').val(data[4])

            $('#editform').on('submit', function(e){
                e.preventDefault()

                let id = $('#id').val()
                $.ajax({
                    type: "PUT",
                    url: `/studentupdate/${id}`,
                    data: $('#editform').serialize(),
                    success: function(response){
                        // console.log(response)
                        $('#studenteditmodal').modal('hide')

                        swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Data updated!',
                        })

                        // Force reload page
                        // location.reload()

                        // Data reload
                        refresh_data()
                    },
                    error: function(error){
                        console.log(error)
                    }
                })
            })
        })
        // End of Edit Data Script

        // Delete Data Script
        $('.deletebtn').click(function(){

            $('#studentdeletemodal').modal('show')

            let tr = $(this).closest('tr')
            let data = tr.children('td').map(function(){
                return $(this).text()
            }).get()

            // console.log(data)

            $('#delete_id').val(data[0])
        })

        $('#deleteform').on('submit', function(e){
            e.preventDefault()

            let id = $('#delete_id').val()

            $.ajax({
                type: 'delete',
                url: '/studentdelete/' + id,
                data: $('#deleteform').serialize(),
                success: function(response){
                    // console.log(response)
                    $('#studentdeletemodal').modal('hide')

                    swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Data deleted!',
                    })

                    // Force reload page
                    // location.reload()

                    // Data reload
                    refresh_data()
                },
                error: function(error){
                    console.log(error)
                }
            })
        })
        // End of Delete Data Script

        // Refresh Data
        function refresh_data(){
            table.ajax.reload()
        }

        // End of Refresh Data
    </script>


</body>
</html>
