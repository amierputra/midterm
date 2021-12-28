    <?php
    session_start();
    if (!isset($_SESSION['sessionid'])) {
        echo "<script>alert('Session not available. Please login');</script>";
        echo "<script> window.location.replace('login.php')</script>";
    }
    if (isset($_POST["submit"])) {
        include_once("connect.php");
        
        $ctc = $_POST["contact"];
        $title = $_POST["title"];
        $desc = $_POST["description"];
        $price = $_POST["price"];
        $depo = $_POST["deposit"];
        $state = $_POST["state"];
        $area = $_POST["area"];
        $lat = $_POST["latitude"];
        $long = $_POST["longitude"];

        $sqlregister = "INSERT INTO `tbl_tenant`(`contact`, `title`, `description`, `price`, `deposit`, `state`, `area`, `latitude`, `longitude`) VALUES('$ctc', '$title', '$desc', '$price', '$depo', '$state', '$area', '$lat', '$long',)";
        try {
            $conn->exec($sqlregister);
            if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
                uploadImage($id);
            }
            echo "<script>alert('Registration successful')</script>";
            echo "<script>window.location.replace('mainpage.php')</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Registration failed')</script>";
            echo "<script>window.location.replace('newrent.php')</script>";
            
    }
    }

    function uploadImage($id)
    {
        $target_dir = "res/images/";
        $target_file = $target_dir . $id . ".png";
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800&display=swap" >
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" >
            <title>New Rent</title>
        </head>
        <style>
        .w3-grid-template {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
    }

    hr {
        margin: 0em;
        padding: 0em;
        border-width: 2px;
    }

    @media screen and (min-width: 1920px) {
        body {
            max-width: 60%;
            margin: auto;
        }
    }

    @media screen and (min-width: 601px) {
        .form-container {
            max-width: 600px;
            margin: auto;
        }
    }

    @media screen and (max-width: 600px) {
        .w3-grid-template {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
        }
        .w3-image {
            width: 100%;
            height: 100%;
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
        <div class="w3-header w3-container w3-padding-32 w3-center" style="background-color: rgb(3, 3, 65);">
            <h1 class="w3-text-amber" style="font-size:calc(8px + 4vw);">RentARoom
            </h1>
            
        </div>

        <div class="w3-bar w3-amber">
            <a href="#contact" class="w3-bar-item w3-button w3-right">Logout</a>
            <a href="mainpage.php" class="w3-bar-item w3-button w3-left">Home</a>
        </div>

        <div class="w3-container w3-padding-64 form-container">
            <div class="w3-card">
                <div class="w3-container" style="background-color: rgb(3, 3, 65);">
                    <p class="w3-text-amber">New Rent Registration
                    <p>
                </div>
                <form class="w3-container w3-padding" name="registerForm" action="newrent.php" method="post" enctype="multipart/form-data" onsubmit="return confirmDialog()" >
                    <div class="w3-container w3-border w3-center w3-padding">
                        <img class="w3-image w3-round w3-margin" src="res/images/profile.png" style="width:100%; max-width:600px"><br>
                        <input type="file" onchange="previewFile()" name="fileToUpload" id="fileToUpload"><br>
                    </div>

                    <p>
                                <label>Contact No.</label>
                                <input class="w3-input w3-sand w3-border w3-round" name="contact" id="ctc" type="text" required>
                            </p>
                            <p>
                                <label>Title</label>
                                <input class="w3-input w3-sand w3-border w3-round" name="title" id="title" type="text" required>
                            </p>
                            <p>
                                <label>Description</label>
                                <input class="w3-input w3-sand w3-border w3-round" name="description" id="description" type="text" required>
                            </p>
                            <p>
                                <label>Price</label>
                                <input class="w3-input w3-sand w3-border w3-round" name="price" id="price" type="text" required>
                            </p>
                            <p>
                                <label>Deposit</label>
                                <input class="w3-input w3-sand w3-border w3-round" name="deposit" id="deposit" type="text" required>
                            </p>
                            <p>
                                <label>State</label>
                                <input class="w3-input w3-sand w3-border w3-round" name="state" id="state" type="text" required>
                            </p>
                            <p>
                                <label>Area</label>
                                <input class="w3-input w3-sand w3-border w3-round" name="area" id="area" type="text" required>
                            </p>
                            <p>
                                <label>Latitude</label>
                                <input class="w3-input w3-sand w3-border w3-round" name="latitude" id="latitude" type="text" required>
                            </p>
                            <p>
                                <label>Longitude</label>
                                <input class="w3-input w3-sand w3-border w3-round" name="longitude" id="longitude" type="text" required>
                            </p>
                            <br>

                    <div class="row">
                        <input class="w3-input w3-border w3-text-amber w3-block w3-round pointer" type="submit" name="submit" value="Submit" style="background-color: rgb(3, 3, 65);">
                    </div>

                </form>


            </div>
        </div>

        <footer class="w3-text-amber w3-container w3-center" style="font-size: 0.8em; background-color: rgb(3, 3, 65);">
                <p>Copyright: Amier Putra<br>All Rights Reserved.</p>
            </footer>

    </body>
    <script>
        function previewFile() {
        const preview = document.querySelector('.w3-image');
        const file = document.querySelector('input[type=file]').files[0];
        const reader = new FileReader();
        reader.addEventListener("load", function() {
            // convert image file to base64 string
            preview.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    function confirmDialog() {
        var r = confirm("Register this tenant?");
        if (r == true) {
            return true;
        } else {
            return false;
        }
    }
    </script>
    </html>