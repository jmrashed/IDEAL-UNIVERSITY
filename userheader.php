<?php
//include("config.php");
session_start();
if (isset($_SESSION['LOGIN_NAME'])) {
    $LOGIN_ID = $_SESSION['LOGIN_ID'];
    $LOGIN_NAME = $_SESSION['LOGIN_NAME'];
    $LOGIN_EMAIL = $_SESSION['LOGIN_EMAIL'];
    $LOGIN_TYPE = $_SESSION['LOGIN_TYPE'];
    if ($LOGIN_TYPE == "teacher") {
        $LOGIN_SUBJECT = $_SESSION['LOGIN_SUBJECT'];
    }
}

include("connection.php");
include("function.php");

if (isset($_POST['submit'])) {


    // session_start();
    unset($_SESSION['LOGIN_ID']);
    unset($_SESSION['LOGIN_NAME']);
    unset($_SESSION['LOGIN_EMAIL']);

//Function to sanitize values received from the form. Prevents SQL injection
    function clean($str) {
        global $conn;
        $str = @trim($str);
        if (get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }

        return mysqli_real_escape_string($conn, $str);
    }

//Sanitize the POST values
    $email = clean($_POST['email']);
    $password = clean($_POST['password']);
    $table = clean($_POST['table']);

    $sql = "SELECT * FROM $table WHERE email='$email' AND password='$password'";
    // echo $sql;
    $result = $conn->query($sql);
//Check whether the query was successful or not
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            //Login Successful
            session_regenerate_id();
            $row = mysqli_fetch_assoc($result);
            $_SESSION['LOGIN_ID'] = $row['id'];
            $_SESSION['LOGIN_NAME'] = $row['name'];
            $_SESSION['LOGIN_EMAIL'] = $row['email'];
            $_SESSION['LOGIN_TYPE'] = $table;
            if ($table == "teacher") {
                $_SESSION['LOGIN_SUBJECT'] = $row['subject'];
            }
            session_write_close();
            header("location: adminhome.php");
            // exit();
            //print_r($_SESSION);
        } else {
            //Login failed
            $errmsg = 'Email or password is invalid';
            header("location: home.php?tab=home&errmsg=$errmsg");
        }
    } else {
        die("Query failed");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">        
        <link rel="stylesheet" href="bootstrap/css/mystyle.css">
        <link href="bootstrap/css/half-slider.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css"> 
        <!-- jvectormap -->
        <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> 
    </head>
    <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
    <body> 
        <header class="header">
            <nav class="nav navbar ideal-nav">
                <div class="container">
                    <div class="navbar-header">
                        <a href="home.php?tab=home" class="navbar-brand">
                            <strong>Ideal</strong> Engineering University

                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="home.php?tab=home">Home</a></li>  
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">About <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="home.php?tab=introduction">Introduction</a></li>
                                    <li><a href="home.php?tab=history">History</a></li>
                                    <li><a href="home.php?tab=achievements"> Achievements </a></li> 
                                    <li><a href="home.php?tab=introduction">Introduction</a></li>
                                    <li><a href="home.php?tab=history">History</a></li>
                                    <li><a href="home.php?tab=achievements"> Achievements </a></li> 
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Informations<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li class=""><a href="home.php?tab=services">Our Services</a></li> 
                                    <li class=""><a href="home.php?tab=adminssions">Admissions</a></li>  
                                    <li><a href="home.php?tab=facilities"> Facilities </a></li> 
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Academic<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li class=""><a href="onlineexam/index.php">Online Exam</a></li> 
                                    <li class=""><a href="getResult.php">Result</a></li> 

                                </ul>
                            </li>

                            <li class=""><a href="home.php?tab=contact">Contact Us</a></li> 

                            <li class=""><a href="home.php?tab=contact">Info</a></li> 

                        </ul>

                    </div>


                </div>

            </nav> 
        </header> 
      <div class="container">  