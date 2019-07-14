<?php
require 'Classes' . DIRECTORY_SEPARATOR . 'Users.php';


$se = new Session();
$se->start();
require 'Layout/templates/header.php';
require 'Layout/templates/navbar.php';
if(isset($_SESSION['username'])){

    // get user info
    $users = new Users();
    $user = $users ->getinfo($_SESSION['id']);

?>

<div class="edit-profile">
    <div class="container">
        <div class="col-xl-6 col-lg-8 col-12 form mx-auto p-2 px-4">
            <div class="mb-3 m-auto control-img text-center">
                <img src="Layout/uploads/<?php echo $user['image']; ?>" class="">
            </div>
            <h1 class="font_weight-bold mb-5  text-center">Edit My Information</h1>
            <form action="update.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3 input-holder control">
                    <i class="fas fa-user"></i>
                    <input type="text" class=" pl-5 pb-3 " value="<?php echo $user['username'] ?>" placeholder="User Name" name="username" autocomplete="off">
                </div>
                <div class="mb-3 input-holder control">
                    <i class="fas fa-key"></i>
                    <input type="password" class="pl-5 pb-3 " placeholder="Password" name="password">
                    <input type="hidden" class="pl-5 pb-3 " value="<?php echo $user['password'] ?>" name="oldpasswd">
                </div>
                <div class="mb-2 input-holder control">
                    <i class="fas fa-lock"></i>
                    <input type="password" class=" pl-5 pb-3" placeholder="Repeat your password" name="password-c" autocomplete="off">
                </div>
                <div class="mb-2 input-holder control">
                    <i class="fas fa-envelope"></i>
                    <input type="email" class=" pl-5 pb-3 " value="<?php echo $user['email'] ?>" placeholder="Email Address" name="email" autocomplete="off">
                </div>
                <div class="my-4 input-holder control-img">
                    <i class="fas fa-folder-plus"></i>
                    <div class="upload pl-5 pb-4 ">Change your picture</div>
                    <input type="file" name="img" value="<?php echo $user['image']; ?>">
                    <input type="hidden" name="img-old" value="<?php echo $user['image']; ?>">
                </div>
                <div class="my-4">
                    <input name="submit" type="submit" value="Save Changes" class="btn btn-warning px-5 py-2 text-center d-inline-block" >
                </div>
            </form>
        </div>
    </div>
</div>



<?php require 'Layout/templates/footer.php';}

else {
    header("Location: login.php");

} ?>

















