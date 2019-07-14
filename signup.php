<?php
    require 'Classes' . DIRECTORY_SEPARATOR . 'Users.php';
    $sess = new Session();
    $sess->start();
    require 'Layout/templates/header.php';
if(isset($_SESSION['username'])){
    header("Location: index.php");
} else {
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user     = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
    $email    = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    $imgName  = $_FILES['img']['name'];
    $imgSize  = $_FILES['img']['size'];
    $imgTmp   = $_FILES['img']['tmp_name'];

    $imgExt   = strtolower(pathinfo($imgName,PATHINFO_EXTENSION));
    $allowExt = array('jpg','png','gif','jpeg');
    $imgNewN  = uniqid() . '.' .$imgExt;

    $formerr = array();
    if(strlen($user) < 5 ){
        $formerr[] = "<div class=' alert alert-danger'>Sorry Username can`t be less than <strong>5</strong> characters</div>";
    }

    if(strlen($_POST['password']) < 5 ){
        $formerr[] = '<div class="alert alert-danger">Sorry Password can`t be less than <strong>5</strong> characters</div>';
    }

    if($_POST['password'] !==  $_POST['password-c']){
        $formerr[] = '<div class=" alert alert-danger">Sorry both Passwords are not <strong>identical</strong></div>';
    }
    if(empty($imgName)){
        $formerr[] = '<div class=" alert alert-danger">Sorry you need to add <strong>Profile Picture</strong></div>';
    }
    if($imgSize > 4000000){
        $formerr[] = '<div class=" alert alert-danger">Sorry Image size is <strong>huge</strong></div>';
    }
    if(!empty($imgName) && !in_array($imgExt,$allowExt)){
        $formerr[] = '<div class=" alert alert-danger">Sorry this image extension is not allowed </div>';
    }



    if (empty($formerr)){
            move_uploaded_file($imgTmp,'Layout\uploads\\' . $imgNewN);
            $signUser = new Users();
            $signUser->signUp($user, $email, $imgNewN, $password);
            if($signUser == true){
                $SuccessMsg = '<div class=" alert alert-success">You have Signed up <strong>Successfully</strong></div>';
            }else {
                $rejectionMsg =  '<div class="alert alert-danger"> Sorry this Account is already <strong>exists</strong></div>';
            }
    }
}
?>
<div class="sign p-5 col-xl-7 col-lg-9 col-12 mx-auto my-md-5">
    <div class="row">
        <div class="col-xl-6 col-12">
            <h1 class="font_weight-bold mb-5 text-xl-left text-center">Sign up</h1>
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3 input-holder">
                    <i class="fas fa-user"></i>
                    <input type="text" class=" pl-4 pb-3"  value="<?php if(isset($_POST['username'])&& !isset($msg)){echo $_POST['username'];} ?>" placeholder="User Name" name="username" autocomplete="off">
                </div>
                <div class="mb-3 input-holder">
                    <i class="fas fa-key"></i>
                    <input type="password" class="pl-4 pb-3" placeholder="Password" name="password">
                </div>
                <div class="mb-2 input-holder">
                    <i class="fas fa-lock"></i>
                    <input type="password" class=" pl-4 pb-3" placeholder="Repeat your password" name="password-c">
                </div>
                <div class="mb-2 input-holder">
                    <i class="fas fa-envelope"></i>
                    <input type="email" class=" pl-4 pb-3" value="<?php if(isset($_POST['email']) && !isset($msg)){echo $_POST['email'];} ?>" placeholder="Email Address" name="email">
                </div>
                <div class="my-4 input-holder">
                    <i class="fas fa-folder-plus"></i>
                    <div class="upload pl-4 pb-4 ">Upload your Picture</div>
                    <input type="file" name="img">
                </div>
                <div class="my-4">
                    <input name="submit" type="submit" value="Sign up" class="btn btn-success px-5 py-2 text-center d-inline-block" >
                </div>
                <?php
                    if(isset($formerr)){
                        foreach($formerr as $err){
                            echo $err ;
                        }
                    }
                    if(isset( $SuccessMsg)){
                        echo  $SuccessMsg;
                    }
                    if(isset( $rejectionMsg)){
                        echo  $rejectionMsg;
                    }
                ?>
            </form>
        </div>
        <div class="col-xl-6 col-12 text-center">
            <img src="Layout/images/signup-image.jpg" class="img-fluid d-block mx-auto">
            <a href="login.php" >I am already member</a>
        </div>

    </div>
</div>

<?php } require 'Layout/templates/footer.php'; ?>