<?php
    session_start();

    $con = mysqli_connect("localhost", "root", "", "register");
    if(! $con) die("Connection faild!");

    if(isset($_POST['login_btn']))
    {
    
        if($_POST['username']&&$_POST['password'])
        {
            $username = mysqli_real_escape_string($con, $_POST['username']);
            $password = mysqli_real_escape_string($con, $_POST['password']);
    
            $password = md5($password);
            $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $result = mysqli_query($con,$sql);
    
            if(mysqli_num_rows($result) == 1)
            {
                $_SESSION['username']=$username;
                $message = $_SESSION['message'] = "You are now logged in!";
                header("location: order.php");
            }
            else
            {
                $message = $_SESSION['message'] = "Username/password combination is incorrect!";
            }
        } 
    
        else
        {
            $message = $_SESSION['message'] = "Username/password combination is incorrect!";
        }
    }

?>
<html>
    <head>
        <link rel="icon" href="img/login.png">
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <title>LOGIN</title>
        <link rel="stylesheet" href="login1.css" type="text/css">
    </head>
    <body>
        <div class="content">
            <h1 class="title">LOGIN</h1>
            <img src="img/loginicon.png" class="login-img">
                       
            <form method="post" action="login.php">
                <input type="username" name="username" placeholder="Username" class="text-field">

                <input type="password" name="password" placeholder="Password" class="text-field">

                <input type="submit" value="LOGIN" name="login_btn" class="button">
                
                <input type="button" value="REGISTER" onclick="window.location.href='register.php'" class="button">
            </form>

            <p class="error-message">
                <?php
                    if(isset($message))
                    {
                        echo $message;
                    }
                ?>
            </p>  
        </div>
    </body>
</html>