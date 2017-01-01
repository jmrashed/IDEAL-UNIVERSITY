<?php
session_start();
if (isset($_SESSION['LOGIN_NAME'])) {
    $LOGIN_ID = $_SESSION['LOGIN_ID'];
    $login = $LOGIN_ID;
    $LOGIN_NAME = $_SESSION['LOGIN_NAME'];
    $LOGIN_EMAIL = $_SESSION['LOGIN_EMAIL'];
    $LOGIN_TYPE = $_SESSION['LOGIN_TYPE'];
    if ($LOGIN_TYPE == "teacher") {
        $LOGIN_SUBJECT = $_SESSION['LOGIN_SUBJECT'];
    }
} else {

    header("Location:../login.php");
}
include '../connection.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Wel come to Online Exam</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="quiz.css" rel="stylesheet" type="text/css">
        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    </head>

    <body> 
        <div class="container"> 
            <div class="row">
                <img src="images/onlineexam.jpg" class="img img-responsive" width="100%">
            </div>
            <ul class="nav nav-pills nav-tabs">
                <li> <a href="index.php">Home</a> </li>
                <li> <a href="sublist.php"> Subject List</a> </li>
                <li> <a href="result.php">Result</a> </li>
                <li> <a href="../adminhome.php" class="text-uppercase"><?= $LOGIN_TYPE; ?> Panel : Welcome to <?= $LOGIN_NAME; ?></a> </li>
                <li> <a href="../logOut.php">Log Out</a> </li>
            </ul>


 