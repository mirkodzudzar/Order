<?php
session_start();
$username=$_SESSION['username'];

class Order{

    public $usernameUser;
    public $licenceCar;
    public $price;
    public $licence; 
    public $brand;
    public $model;
    public $company;

    function __construct($usernameUser, $licenceCar, $price, $licence, $brand, $model, $company){

        $this->usernameUser = $usernameUser;
        $this->licenceCar = $licenceCar;
        $this->price = $price;
        $this->licence = $licence; 
        $this->brand = $brand;
        $this->model = $model;
        $this->company = $company;
    }

}

$con = mysqli_connect("localhost", "root", "", "register");

if(! $con) die("Connection faild!");
    
if (isset($_POST['order_btn'])) {
    if (empty($_POST['car'])||empty($_POST['licence']))
    {       
        $message = "Chose your vecicle and licence!";
    }else{
        if($_POST['car']=="Mercedes Cls 250")
        {
            $licence = strtoupper($_POST['licence'][0].$_POST['licence'][1])." ".rand(100,999)."-".rand(100,999);
            $order = new Order($_SESSION['username'], $licence, 75000, $licence, "Mercedes", "Cls 250", 123);
        }

        else if($_POST['car']=="Mercedes Glc 350")
        {
            $licence = strtoupper($_POST['licence'][0].$_POST['licence'][1])." ".rand(100,999)."-".rand(100,999);
            $order = new Order($_SESSION['username'], $licence, 35000, $licence, "Mercedes", "Glc 350", 123);
        }

        else if($_POST['car']=="Mercedes Amg GT R")
        {
            $licence = strtoupper($_POST['licence'][0].$_POST['licence'][1])." ".rand(100,999)."-".rand(100,999);
            $order = new Order($_SESSION['username'], $licence, 150000, $licence, "Mercedes", "Amg GT R", 123);
        }

        else if($_POST['car']=="Ford Ranger")
        {
            $licence = strtoupper($_POST['licence'][0].$_POST['licence'][1])." ".rand(100,999)."-".rand(100,999);
            $order = new Order($_SESSION['username'], $licence, 30000, $licence, "Ford", "Ranger", 321);
        }

        else if($_POST['car']=="Ford Mustang")
        {
            $licence = strtoupper($_POST['licence'][0].$_POST['licence'][1])." ".rand(100,999)."-".rand(100,999);
            $order = new Order($_SESSION['username'], $licence, 55000, $licence, "Ford", "Mustang", 321);
        }

        else
        {
            $licence = strtoupper($_POST['licence'][0].$_POST['licence'][1])." ".rand(100,999)."-".rand(100,999);
            $order = new Order($_SESSION['username'], $licence, 28000, $licence, "Ford", "Edge", 321);
        }

        $sql = "INSERT INTO ordering(usernameUser, licenceCar, price) VALUES('$order->usernameUser','$order->licenceCar','$order->price')";
            $query = mysqli_query($con, $sql);
            if($query)
            {
                header("Refresh:0; order.php");
            }

        $company = (int)preg_replace("/[^\d]+/","",$order->company);

        $sql = "INSERT INTO car(licence, brand, model, codeCompany) VALUES('$order->licence', '$order->brand', '$order->model','$company')";
            $query = mysqli_query($con, $sql);
            if($query)
            {
                header("Refresh:0; order.php");
            }
        }
    }
?>
<html>
<head>
    <title>ORDER</title>
    <link rel="icon" href="img/car.png">
    <link rel="stylesheet" href="order5.css" type="text/css">
</head>
<body>
    <div class="content">
        <div class="logout">
            <p class="user"><?php echo $username; ?><p>
            <a href="logout.php" class="button">LOGOUT</a>
        </div>

        <h1 class="title">Your order</h1>

        <div class="error-message">
            <?php
                if(isset($message))
                {
                    print $message;
                }
            ?>
        </div>

        <form method="post" action="order.php">
            <div class="order-list" method="post">
                <div class="order-box">
                    <a href="img/mercedescls.jpg"><img src="img/mercedescls.jpg" alt="mercedes1"></a><br>
                    <input type="radio" value="Mercedes Cls 250" name="car">Mercedes Cls 250<p>75000 USD</p>
                </div>

                <div class="order-box">
                    <a href="img/mercedesglc.jpg"><img src="img/mercedesglc.jpg" alt="mercedes2"></a><br>
                    <input type="radio" value="Mercedes Glc 350" name="car">Mercedes Glc 350<p>35000 USD</p>
                </div>

                <div class="order-box">
                    <a href="img/mercedesamggt.jpg"><img src="img/mercedesamggt.jpg" alt="mercedes3"></a><br>
                    <input type="radio" value="Mercedes Amg GT R" name="car">Mercedes Amg GT R<p>150000 USD</p>
                </div>

                <div class="order-box">
                    <a href="img/fordranger.jpg"><img src="img/fordranger.jpg" alt="ford1"></a><br>
                    <input type="radio" value="Ford Ranger" name="car">Ford Ranger<p>30000 USD</p>
                </div>

                <div class="order-box">
                    <a href="img/fordmustang.jpg"><img src="img/fordmustang.jpg" alt="ford2"></a><br>
                    <input type="radio" value="Ford Mustang" name="car">Ford Mustang<p>55000 USD</p>
                </div>

                <div class="order-box">
                    <a href="img/fordedge.jpeg"><img src="img/fordedge.jpeg" alt="ford3"></a><br>
                    <input type="radio" value="Ford Edge" name="car">Ford Edge<p>28000 USD</p>            
                </div>
                
                <div class="order-box">
                <form method="post" action="order.php">
                    <input type="text" placeholder="Place of residence" name="licence" class="textField">                
                    <input type="submit" value="ORDER" name="order_btn" class="button">
                </form>
                </div>

                <!-- <script>
                    document.getElementById("submit").disabled = true;
                </script> -->
            </div>
        </form>

        <form method="post" class="order-report">
            <h2>The order report</h2>
            <?php
                $sql = "SELECT car.brand as brand, car.model as model, car.licence as licence, ordering.price as price, ordering.usernameUser as username 
                        FROM ordering
                        INNER JOIN car ON car.licence = ordering.licenceCar
                        ORDER BY ordering.usernameUser; ";
                $query = mysqli_query($con, $sql);
                if(mysqli_num_rows($query)>0)
                {
                    $i=1;
                    while($row = mysqli_fetch_object($query))
                    {
                        if($username==$row->username){
                            echo "USERNAME: <b><i>".$row->username."</i></b><br>CAR BRAND: <b><i>".$row->brand."</i></b><br>CAR MODEL: <b><i>".$row->model."</i></b><br>LICENCE: <b><i>".$row->licence."</i></b><br>PRICE: <b><i>".$row->price."</i></b> USD<hr>";
                        }
                    }
                }       
            ?>
        </form>
    </div>
</body>
</html>