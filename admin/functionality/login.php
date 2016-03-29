<?php
    session_start();

    require_once '../config.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $myusername = mysqli_real_escape_string($db,$_POST['usernameinput']);

        $mypassword = mysqli_real_escape_string($db,$_POST['passwordinput']);
        $mypassword = md5($mypassword);

        $sql = "SELECT * FROM admin WHERE admin_email = '$myusername'";
        $result = mysqli_query($db,$sql);

        $count = mysqli_num_rows($result);

        if($count == 1) {
            $sql = "SELECT * FROM admin WHERE admin_email = '$myusername' and admin_password = '$mypassword'";
            $result = mysqli_query($db,$sql);
            $count = mysqli_num_rows($result);
            if($count == 1) {
                $_SESSION['login_user'] = $myusername;
                header("location: ../index.php");
            }else {
                echo "Password error.";
            }
        }else{
            echo "Username error.";
        }
    }
?>
