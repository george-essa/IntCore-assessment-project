<?php
require 'Classes' . DIRECTORY_SEPARATOR . 'Users.php';
$sess = new Session();
$sess->start();
require 'Layout/templates/header.php';
require 'Layout/templates/navbar.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $user = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    if(strlen($_POST['password']) > 5 ){
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    }  else{
        $password = $_POST['oldpasswd'];
    }
    $imgName  = $_FILES['img']['name'];
    $imgSize  = $_FILES['img']['size'];
    $imgTmp   = $_FILES['img']['tmp_name'];
    $imgExt   = strtolower(pathinfo($imgName,PATHINFO_EXTENSION));
    $allowExt = array('jpg','png','gif','jpeg');

    if(empty($imgNewN)){
        $imgNewN = $_POST['img-old'];
    } else {
        $imgNewN  = uniqid() . '.' .$imgExt;
    }



    $formerr = array();
    if(strlen($user) < 5 ){
        $formerr[] = "<div class=' alert alert-danger'>Sorry Username can`t be less than <strong>5</strong> characters</div>";
    }

    if($_POST['password'] !==  $_POST['password-c']){
        $formerr[] = '<div class=" alert alert-danger">Sorry both Passwords are not <strong>identical</strong></div>';
    }

    if(empty($imgNewN)){
        $formerr[] = '<div class=" alert alert-danger">Sorry you need to add <strong>Profile Picture</strong></div>';
    }
    if($imgSize > 4000000){
        $formerr[] = '<div class=" alert alert-danger">Sorry Image size is <strong>huge</strong></div>';
    }
    if(!empty($imgName) && !in_array($imgExt,$allowExt)){
        $formerr[] = '<div class=" alert alert-danger">Sorry this image extension is not allowed </div>';
    }
    if (!empty($formerr)){
        echo '<div class="container">';
        foreach($formerr as $err){
            echo $err ;
        }
        header("Refresh:3; url=index.php");
        echo '</div>';
    }else {

        $users = new Users();
        $updateCmd   = $users->update($user, $email, $password, $imgNewN,$_SESSION ['id']);
        move_uploaded_file($imgTmp,'Layout/uploads/' . $imgNewN);
        if($updateCmd === true){
            echo '<div class=" alert alert-success container">You have Updated your information <strong>Successfully</strong></div>';
            header("Refresh:3; url=index.php");
        } else {
            echo '<div class="alert alert-danger container"> Sorry Some of your information is already <strong>exists</strong></div>';
            header("Refresh:3; url=index.php");
        }
    }
}else {
    header('Location:login.php');
}
require 'Layout/templates/footer.php';
?>





















