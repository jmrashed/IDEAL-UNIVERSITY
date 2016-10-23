<?php
include('connection.php');
include('function.php');

if (isset($_POST['submit'])) {


    session_start();
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
            $row=mysqli_fetch_assoc($result);
            $_SESSION['LOGIN_ID'] = $row['id'];
            $_SESSION['LOGIN_NAME'] = $row['name'];
            $_SESSION['LOGIN_EMAIL'] = $row['email'];
            $_SESSION['LOGIN_TYPE'] = $table;
            if($table=="teacher"){
                  $_SESSION['LOGIN_SUBJECT'] = $row['subject'];
                
            }
            session_write_close();
           header("location: adminhome.php");
            // exit();
            //print_r($_SESSION);
        } else {
            //Login failed
            $errmsg = 'Email or password is invalid'; 
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
        <title>Famous Academic Coaching, Jhenaidah | Dashboard</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css"> 
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                 <a href="#"><?php echo get_SystemName(); ?> </a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <?php
                if (isset($errmsg)) {
                  
                        echo '<div class="row text-center"><span style="color:red"><b> Oh Sorry!! ', $errmsg, ' ! </b></span></div>';
             
                }
                ?>
                <form action="login.php" method="post" >
                    <div class="form-group">
                        <select name="table" class="form-control">
                            <option value="admin"> Admin</option>
                            <option value="teacher"> Teacher</option>
                            <option value="student"> Student</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email" required="required"> 
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" required="required"> 
                    </div>
                    <div class="row">

                        <div class=" col-md-offset-8 col-xs-4"> 
                            <input type="submit" class="btn btn-primary ng-binding" value="Sign In" name="submit" >
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                        Facebook</a>
                    <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                        Google+</a>
                </div>
                <!-- /.social-auth-links -->

                <a href="passwordReset.php">I forgot my password</a><br>
                <a href="register.html" class="text-center">Register a new rowship</a>

            </div>
            <!-- /.login-box-body -->
        </div> 
    </body>
</html>
