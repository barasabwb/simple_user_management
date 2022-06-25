<?php
include_once 'Classes/database.php';
session_start();
$user = new Database();
if ($user->session_login())
{
    header("location:index.php");
}
$user = new Database();
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $register = $user->register($_REQUEST['f_name'],$_REQUEST['l_name'],$_REQUEST['email'],$_REQUEST['password']);
    if($register){

        header("location:login.php");
        exit;
    }
    else
    {
        echo "Entered email already exist!";
    }
}
?>
<?php include_once('Resources/layout/header.php'); ?>

<?php include_once('Resources/layout/navbar.php'); ?>
<div class="container">
    <form class="form-control" style="margin: 50px" method="post">
        <div class="form-group">
            <label for="f_name">First name</label>
            <input type="text" class="form-control " id="f_name" name="f_name"  placeholder="Enter your first name">

        </div>
        <div class="form-group">
            <label for="l_name">Last name</label>
            <input type="text" class="form-control " id="l_name" name="l_name"  placeholder="Enter your last name">

        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control " id="email" name="email" placeholder="Enter email">

        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <p style="text-align:center ">Already Registered?<a href="login.php"> Login Here</a></p>
    </form>


</div>



<?php include_once('Resources/layout/footer.php'); ?>