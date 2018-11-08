<?php 

    session_start();

    $con = mysqli_connect("localhost", "root", "", "register");
    if(! $con) die("Connection faild!");

    if(isset($_POST['register_btn']))
    {
        if($_POST['firstName']&&$_POST['lastName']&&$_POST['username']&&$_POST['email']&&$_POST['password']&&$_POST['passwordRepeat'])
        {
            $firstName=mysqli_real_escape_string($con, $_POST['firstName']);
            $lastName=mysqli_real_escape_string($con, $_POST['lastName']);
            $username=mysqli_real_escape_string($con, $_POST['username']);
            $email=mysqli_real_escape_string($con, $_POST['email']);
            $password=mysqli_real_escape_string($con, $_POST['password']);
            $passwordRepeat=mysqli_real_escape_string($con, $_POST['passwordRepeat']);

                $password=md5($password);
                $sql="INSERT INTO `users` (`firstName`, `lastName`, `username`, `email`, `password`) VALUES ('$firstName', '$lastName', '$username', '$email', '$password');";
                mysqli_query($con,$sql);

                header("location:login.php");
        }
        else
        {
            $message="Please enter values in all fields!";
        }
    }

?>


<html>
    <head>
        <link rel="icon" href="img/register.png">
        <meta http-equiv="content-type" content="text/html">
        <title>REGISTER</title>
        <link rel="stylesheet" href="register1.css" type="text/css">
    </head>
    <body>
        <div id="background">
            <h1 class="title">REGISTER</h1>
            <div class="error-message">
                <?php
                    if(isset($message))
                    {
                        print $message;
                    }
                ?>
            </form>
            <form method="post" action="register.php">
                <input type="text" name="firstName" placeholder="First name" class="textField" value="<?php //echo($_POST['firstName']); ?>"><br><br>

                <input type="text" name="lastName" placeholder="Last name" class="textField" value="<?php //echo($_POST['lastName']); ?>"><br><br>

                <input type="text" name="username" placeholder="Username" class="textField" value="<?php //echo($_POST['username']); ?>"><br><br>

                <input type="email" name="email" placeholder="E-mail" class="textField" value="<?php //echo($_POST['email']); ?>"><br><br>
                
                <input type="password" name="password" placeholder="Password" class="textField"><br><br>

                <input type="password" name="passwordRepeat" placeholder="Repeat your password" class="textField"><br><br>

                <input type="submit" value="REGISTER" name="register_btn" class="button">
            </form>
    </body>
</html>