<?php 

class Db {

    private $dns      = "mysql:host=localhost;dbname=shop";
    private $username = "root";
    private $password = "";
    private $options  =array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE            =>  PDO::ERRMODE_EXCEPTION
    );

    public function connect() {
        try{
            $con = new PDO($this->dns,$this->username,$this->password,$this->options);
            return $con;

        } catch (PDOException $e) {
            echo 'Failed: ' . $e -> getMessage();
        }
    }
}
