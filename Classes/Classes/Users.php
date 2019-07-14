<?php
require 'Db.php';
require 'session.php';
require 'PHPMailer.php';
require 'SMTP.php';



class Users extends Db {

    public function Login($username,$password) {
        $con = $this->connect();
        $stmt = $con->prepare("SELECT username,password,id FROM shop.users WHERE username = ?");
        $stmt->execute(array($username));
        $count = $stmt->rowCount();
        if($count > 0) {
             $user = $stmt->fetch();
             if(password_verify($password,$user['password']) === true){
                 $sess= new Session();
                 $sess->start();
                 $sess->id = $user['id'];
                 $sess->username = $user['username'];
                 return true;

             } else {
                 return false;
             }
        }
    }

    // signup functions

    private function checkSignup($username,$email){
        $con = $this -> connect();
        $stmt = $con -> prepare("SELECT * FROM shop.users WHERE username = ? OR email = ?");
        $stmt->execute(array($username,$email));
        $row = $stmt->rowCount();
        return $stmt->rowCount();
    }
    private function sendThanksMail($email,$name){

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'tonypola1@gmail.com';
        $mail->Password   = 'sediaitaliano10';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom('tonypola1@gmail.com');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Hello '. $name . '...Intcore';
        $mail->Body    = 'Dear '.$name.' Thank you for your for signing up for intcore';
        $mail->AltBody = 'Dear '.$name.' Thank you for your for signing up for intcore';

        $mail->send();

    }
    public function signUp($username, $email, $image, $password) {
        $exist = $this->checkSignup($username,$email);
        if ($exist == 0){
            $con = $this -> connect();
            $stmt= $con->prepare("INSERT INTO shop.users (username, password, email, image)
                                    VALUES (:username,:password,:email, :image)");
            $stmt->execute(array(
                ':username' => $username,
                ':password' => $password,
                ':email' => $email,
                ':image' => $image,
            ));
            $this->sendThanksMail($email,$username);
            return true;
        }
        else {
            return false;
        }
    }

    // update information functions

    private function checkUsername($username,$id){
        $con = $this -> connect();
        $stmt = $con -> prepare("SELECT * FROM shop.users WHERE username = ? AND id != ?");
        $stmt->execute(array($username,$id));
        $row = $stmt->rowCount();
        return $row;
    }

    private function checkEmail($email,$id){
        $con = $this -> connect();
        $stmt = $con -> prepare("SELECT * FROM shop.users WHERE email = ? AND id != ?");
        $stmt->execute(array($email,$id));
        $row = $stmt->rowCount();
        return $row;
    }

    public function update($username, $email, $password, $image,$id) {
        $existUsername = $this->checkUsername($username,$id);
        if ($existUsername == 0) {
            $existEmail = $this->checkEmail($email,$id);
            if($existEmail == 0){
                $con = $this->connect();
                $stmt =$con -> prepare("UPDATE users SET username = ? , email = ?, password = ?, image = ? WHERE id = ?");
                $stmt ->execute(array($username, $email, $password, $image, $id));
                return true;
            } else {
                return false;
            }
        }
        header(" url=index.php");
    }
    public function getinfo($id){
        $con = $this->connect();
        $stmt =$con -> prepare("SELECT * FROM shop.users WHERE id = ?");
        $stmt ->execute(array($id));
        $row = $stmt->fetch();
        return $row;
    }
}
















