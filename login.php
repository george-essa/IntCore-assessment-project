<?php
require 'Classes' . DIRECTORY_SEPARATOR . 'Users.php';
require 'Layout/templates/header.php';
$ses = new Session();
$ses->start();

if(isset($_SESSION['username'])){
    header("Location: index.php");
    exit();

} else{
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $user = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
        $password = $_POST['password'];
        $login = new Users();
        $verify = $login->Login($user,$password);
        if($verify === true){
            if(!empty($_POST['remember'])){
                setcookie('username',$_POST['username'],time()+ (3600 * 24 * 30) ,'/',localhost,false,false ); // a month
                setcookie('password',$_POST['password'],time()+ 3600 ,'/',localhost,false,false ); // a month
            }
            header("Location: index.php");
            die();
        } else{
            $WrongUOP = '<div class="alert alert-danger">Sorry <strong>Username </strong>or <strong>Password</strong> is wrong</div>';
        }
    }
}

?>
    <div class="sign p-5 col-xl-7 col-lg-9 col-12 mx-auto my-md-5">
        <div class="row">
            <div class="col-xl-6 col-12 order-xl-2">
                <h1 class="font_weight-bold mb-5 text-xl-left text-center">Sign up</h1>
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="mb-3 input-holder">
                        <i class="fas fa-user"></i>
                        <input type="text" class=" pl-4 pb-3" value="<?php if(isset($_COOKIE['username'])){echo $_COOKIE['username'];} ?>" placeholder="User Name" name="username" autocomplete="off">
                    </div>
                    <div class="mb-3 input-holder">
                        <i class="fas fa-key"></i>
                        <input type="password" class="pl-4 pb-3" placeholder="Password" value="<?php if(isset($_COOKIE['password'])){echo $_COOKIE['password'];} ?>" name="password">
                    </div>
                    <div class="mb-3 input-holder">
                        <input  type="checkbox" name="remember" id="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <div class="my-4">
                        <input name="submit" type="submit" value="Log in" class="btn btn-primary px-5 py-2 text-center d-inline-block" >
                    </div>

                    <?php
                    if(isset($WrongUOP)){
                        echo $WrongUOP;
                    }
                    ?>
                </form>
            </div>
            <div class="col-xl-6 col-12 text-center">
                <img src="Layout/images/signin-image.jpg" class="img-fluid d-block mx-auto order-xl-1">
                <a href="signup.php" >Creata an account</a>
            </div>

        </div>
    </div>

<?php require 'Layout/templates/footer.php'; ?>