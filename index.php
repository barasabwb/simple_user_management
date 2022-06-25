

<?php
session_start();
include_once 'Classes/database.php';
$user = new Database();
$email= $_SESSION['email'];
if (!$user->session_login()){
    header("location:login.php");
}
if (isset($_REQUEST['q'])){
    $user->logout();
    header("location:login.php");
}
?>
<?php include_once('Resources/layout/header.php'); ?>
<?php include_once('Resources/layout/navbar.php'); ?>
<?php
echo "Welcome".' '.$email;
?>
<div class="card text-center" style="padding:15px;">
    <h3>User Management</h3>
</div><br><br>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <h4>All Users</h4>
        </div>
        <div class="col-lg-6">
            <button type="button" class="btn btn-primary m-1 float-right" data-toggle="modal" data-target="#addModal">
                <i class="fa fa-plus"></i> Add New Record</button>

        </div>
    </div><br>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="table-responsive" id="tableData">
                <h3 class="text-center text-success" style="margin-top: 150px;">Loading...</h3>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Add New User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="formData">
                    <div class="form-group">
                        <label for="name">First Name:</label>
                        <input type="text" class="form-control" name="f_name" id="f_name" placeholder="Enter First Name" required="">
                    </div>
                    <div class="form-group">
                        <label for="name">Last Name:</label>
                        <input type="text" class="form-control" name="l_name" id="l_name" placeholder="Enter Last Name" required="">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required="">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Pasword" required="">
                    </div>
                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-success" id="submit">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Edit User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="EditformData">
                    <input type="hidden" name="id" id="edit-form-id">
                    <div class="form-group">
                        <label for="name">First Name:</label>
                        <input type="text" class="form-control" name="f_name" id="f_name" placeholder="Enter First Name" required="">
                    </div>
                    <div class="form-group">
                        <label for="name">Last Name:</label>
                        <input type="text" class="form-control" name="l_name" id="l_name" placeholder="Enter Last Name" required="">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required="">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Pasword" required="">
                    </div>

                    <hr>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-primary" id="update">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
    $(document).ready(function(){

        showAllUsers();

        function showAllUsers(){
            $.ajax({
                url : "action.php",
                type: "POST",
                data : {action:"view"},
                success:function(response){
                    $("#tableData").html(response);
                    $("table").DataTable({
                        order:[0, 'DESC']
                    });
                }
            });
        }

        $("#submit").click(function(e){
            if ($("#formData")[0].checkValidity()) {
                e.preventDefault();
                $.ajax({
                    url : "action.php",
                    type : "POST",
                    data : $("#formData").serialize()+"&action=insert",
                    success:function(response){
                        Swal.fire({
                            icon: 'success',
                            title: 'User added successfully',
                        });
                        $("#addModal").modal('hide');
                        $("#formData")[0].reset();
                        showAllUsers();
                    }
                });
            }
        });

        $("body").on("click", ".editBtn", function(e){
            e.preventDefault();
            var editId = $(this).attr('id');
            $.ajax({
                url : "action.php",
                type : "POST",
                data : {editId:editId},
                success:function(response){
                    var data = JSON.parse(response);
                    $("#edit-form-id").val(editId);
                    $("#f_name").val(data.f_name);
                    $("#l_name").val(data.l_name);
                    $("#email").val(data.email);
                    $("#password").val(data.password);
                }
            });
        });

        $("#update").click(function(e){
            if ($("#EditformData")[0].checkValidity()) {
                e.preventDefault();
                $.ajax({
                    url : "action.php",
                    type : "POST",
                    data : $("#EditformData").serialize()+"&action=update",
                    success:function(response){
                        Swal.fire({
                            icon: 'success',
                            title: 'User updated successfully',
                        });
                        $("#editModal").modal('hide');
                        $("#EditformData")[0].reset();
                        showAllUsers();
                    }
                });
            }
        });

        $("body").on("click", ".deleteBtn", function(e){
            e.preventDefault();
            var tr = $(this).closest('tr');
            var deleteBtn = $(this).attr('id');
            if (confirm('Are you sure want to delete this Record')) {
                $.ajax({
                    url : "action.php",
                    type : "POST",
                    data : {deleteBtn:deleteBtn},
                    success:function(response){
                        tr.css('background-color','#ff6565');
                        Swal.fire({
                            icon: 'success',
                            title: 'User deleted successfully',
                        });
                        showAllUsers();
                    }
                });
            }
        });
    });
</script>

<?php include_once('Resources/layout/footer.php'); ?>