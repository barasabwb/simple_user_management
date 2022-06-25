<?php
session_start();
include_once 'Classes/database.php';
$user = new Database();
if ($user->session_login())
{
    header("location:index.php");
}

$user = new Database();
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $login = $user->login($_REQUEST['email'],$_REQUEST['password']);
    if($login){
        header("location:index.php");
    }
    else
    {
        echo "Login Failed!";
    }
}
?>
<?php include_once('Resources/layout/header.php'); ?>

<?php include_once('Resources/layout/navbar.php'); ?>


<div class="container">
    <form class="form-control form"  method="post" style="margin: 40px" >

        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">

        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" style="margin-right: 200px">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <br>
        <p style="text-align: center">Not Registered?<a href="register.php"> Register Here</a></p>
    </form>
</div>

<?php
if ($user->session_register())
{
    echo $_SESSION['success_message'];
    $_SESSION['register'] = false;
    $_SESSION['success_message'] = false;
    session_destroy();
}
?>

<?php include_once('Resources/layout/footer.php'); ?>