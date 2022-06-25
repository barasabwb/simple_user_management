<nav class="navbar navbar-expand-lg navbar-light bg-light">
<!--    <a class="navbar-brand" href="#">Navbar</a>-->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php

            $user = new Database();

            if ($user->session_login()){
                echo   '<li class="nav-item">
                <a class="nav-link" href="?q=logout">Logout</a>
                </li>';
            }else{
                echo '      <li class="nav-item">
                <a class="nav-link" href="/Simple User Management/login.php">Login</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="/Simple User Management/register.php">Register</a>
            </li>';

            }
            if (isset($_REQUEST['q'])){
                $user->logout();
                header("location:login.php");
            }
            ?>


        </ul>
    </div>
</nav>