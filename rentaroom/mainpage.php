<?php
session_start();
if (!isset($_SESSION['sessionid'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

$results_per_page = 4;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}

include_once("connect.php");

if (isset($_GET['op'])) {
    $op = $_GET['op'];
    if ($op == 'delete') {
        $id = $_GET['id'];
        $sqldelete = "DELETE FROM tbl_tenant WHERE id = '$id'";
        $stmt = $conn->prepare($sqldelete);
        if ($stmt->execute()) {
            echo "<script> alert('Delete Success')</script>";
            echo "<script>window.location.replace('mainpage.php')</script>";
        } else {
            echo "<script> alert('Delete Failed')</script>";
            echo "<script>window.location.replace('mainpage.php')</script>";
        }
    }
}

if (isset($_GET['button'])) {
    $op = $_GET['button'];
    $option = $_GET['option'];
    $search = $_GET['search'];
    if ($op == 'search') {
        if ($option == "contact") {
            $sqltenant = "SELECT * FROM tbl_tenant WHERE contact LIKE '%$search%'";
        }
        if ($option == "state") {
            $sqltenant = "SELECT * FROM tbl_tenant WHERE `state` LIKE '%$search%'";
        }
    }
} else {
    $sqltenant = "SELECT * FROM tbl_tenant ORDER BY `date` DESC";
}

$stmt = $conn->prepare($sqltenant);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqltenant = $sqltenant . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqltenant);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

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
                    RentARoom
                </h1>
        </div>
        <div class="w3-bar w3-amber">
            <a href="#contact" class="w3-bar-item w3-button w3-right">Logout</a>
            <a href="newrent.php" class="w3-bar-item w3-button w3-
            left">New Tenant</a>
    </div>

    <div class="w3-grid-template">
        <?php
        foreach ($rows as $tenant) {
            $id = $tenant['id'];
            $ctc = $tenant['contact'];
            $title = $tenant['title'];
            $desc = $tenant['description'];
            $price = $tenant["price"];
            $depo = $tenant["deposit"];
            $state = $tenant["state"];
            $area = $tenant["area"];
            $date = $tenant["date"];
            $lat = $tenant["latitude"];
            $long = $tenant["longitude"];
            echo "<div class='w3-center w3-padding'>";
            echo "<div class='w3-card-4 w3-dark-grey'>";
            echo "<header class='w3-container w3-blue'";
            echo "<h5>$id</h5>";
            echo "</header>";
            echo "<div class='w3-padding'><img class='w3-image' src= res/images/$id.png" .
                " onerror=this.onerror=null;this.src='res/images/profile.png'"
                . " '></div>";
            echo "<div class='w3-container w3-left-align'><hr>";
            echo "<p>
            <i class='fa fa-id-card' style='font-size:16px'>
            </i>&nbsp&nbsp$id<br>
            <i class='fa fa-phone' style='font-size:16px'>
            </i>&nbsp&nbsp$ctc<br>
            <i class='fa fa-flag' style='font-size:16px'>
            </i>&nbsp&nbsp$title<br>
            <i class='fa fa-flag' style='font-size:16px'>
            </i>&nbsp&nbsp$desc<br>
            <i class='fa fa-flag' style='font-size:16px'>
            </i>&nbsp&nbsp$price<br>
            <i class='fa fa-flag' style='font-size:16px'>
            </i>&nbsp&nbsp$depo<br>
            <i class='fa fa-flag' style='font-size:16px'>
            </i>&nbsp&nbsp$state<br>
            <i class='fa fa-flag' style='font-size:16px'>
            </i>&nbsp&nbsp$area<br>
            <i class='fa fa-flag' style='font-size:16px'>
            </i>&nbsp&nbsp$date<br>
            <i class='fa fa-flag' style='font-size:16px'>
            </i>&nbsp&nbsp$lat<br>
            <i class='fa fa-flag' style='font-size:16px'>
            </i>&nbsp&nbsp$long<br>
            </p><hr>";
            
             echo "<table class='w3-table'><tr>
            <td class='w3-center'><a href='mainpage.php?op=delete&id=$id'>
            <i class='fa fa-trash-o' style='font-size:32px' onClick=
            'return deleteDialog($id)' style='text-decoration:none'></i></a></td>
            </tr></table>";


            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
    <?php
    $num = 1;
    if ($pageno == 1) {
        $num = 1;
    } else if ($pageno == 2) {
        $num = ($num) + $results_per_page;
    } else {
        $num = $pageno * $results_per_page - 9;
    }
    echo "<div class='w3-container w3-row'>";
    echo "<center>";
    for ($page = 1; $page <= $number_of_page; $page++) {
        echo '<a href = "mainpage.php?pageno=' . $page . '" style=
        "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
    }
    echo " ( " . $pageno . " )";
    echo "</center>";
    echo "</div>";
    ?>

    <footer class="w3-footer w3-center w3-blue-grey">
        <p>Amier Putra</p>
    </footer>
    </body>

</html>    