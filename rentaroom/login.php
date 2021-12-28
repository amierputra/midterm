<?php
if (isset($_POST["submit"])) {
    include 'connect.php';
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE email = '$email' AND password = '$pass'");
    $stmt->execute();
    $number_of_rows = $stmt->fetchColumn();
    if ($number_of_rows > 0){
        session_start();
        $_SESSION["sessionid"] = session_id();
        echo "<script>alert('Login Success');</script>";
        echo "<script> window.location.replace('mainpage.php')</script>";
    }else {
        echo "<script>alert('Login Failed');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800&display=swap" >
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" >
        <title>RentARoom</title>
    </head>

    <style>
        @media screen and (min-width: 601px) {
        .form-container{
            max-width: 900px;
            margin: auto;
        }
        }

        @media screen and (min-width: 601px) {
        .btn{
            max-width: 500px;
            margin: auto;
             }
        }

        .pointer{
            cursor: pointer;
        }

        h1{
            font-family: Montserrat;
            font-weight: 800;
        }
        h3{
            font-family: Poppins;
            font-weight: 700;
        }
        p{
            font-family: Poppins;
            font-weight: 500;
        }
    </style>

    <body>
    <div class="w3-header w3-center w3-padding-24" style="background-color: rgb(3, 3, 65);">
            <h1 class="w3-text-amber ">
                LOGIN
            </h1>
    </div>
    <div class="w3-padding-32 w3-container" style="background-color: darkblue;">
            <div class="w3-card form-container">
                <form class="w3-container w3-amber w3-padding-24 w3-round-large formco" name="insertForm" action="login.php" method="post" onsubmit="return confirmDialog()" enctype="multipart/form-data">
                    <div class="w3-margin-left w3-margin-right">
                        <h3 class="w3-text-sand">
                            Please fill all the field below.
                        </h3>
                        <p>
                            <label>Email</label>
                            <input class="w3-input w3-sand w3-border w3-round" name="email" id="email" type="email" required>
                        </p>
                        <p>
                            <label>Password</label>
                            <input class="w3-input w3-sand w3-border w3-round" name="password" id="password" type="password" required>
                        </p>
                        <br>
                        <div class="btn w3-center">
                            <button class="pointer w3-input w3-text-sand w3-border w3-block w3-round w3-hover-deep-orange" style="background-color: rgb(3, 3, 65);" name="submit">LOG IN</button>
                        </div>
                    </div>  
            </form>
            </div
        ></div>
        
        <footer class="w3-text-amber w3-container w3-center" style="font-size: 0.8em; background-color: rgb(3, 3, 65);">
            <p>Copyright: Amier Putra<br>All Rights Reserved.</p>
        </footer>
    </body>

    <script>
        function confirmDialog(){
            var r =confirm("Login?");
            if (r==true){
                return true;
            } else {
                return false;
            }
        }
    </script>

</html>