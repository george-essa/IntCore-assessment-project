<?php
require 'Classes' . DIRECTORY_SEPARATOR . 'session.php';

$sess = new Session();
$sess->Kill();

header('Location:login.php');
die();