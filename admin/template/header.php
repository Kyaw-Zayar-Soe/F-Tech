<?php
ob_start();
session_start();
include("./inc/config.php");
include("./inc/function.php");
include("./inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';


if(!isset($_SESSION['user'])) {
	header('location: login.php');
	exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="./assets/vendor/feather-icons-web/feather.css">
    <link rel="stylesheet" href="./assets/vendor/data_table/dataTables.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="icon" href="./assets/img/logo-modified.png">
</head>
<body>

<section class="main container-fluid">
    <div class="row">
        <!--        sidebar start-->
        <?php include "sidebar.php"; ?>
        <!--        sidebar end-->
        <div class="col-12 col-lg-9 col-xl-10 vh-100 py-3 content">
            <div class="row header mb-4">
                <div class="col-12">
                    <div class="p-2 bg-dark d-flex justify-content-between align-items-center rounded">
                        <button class="show-sidebar-btn btn-sm btn btn-light d-block d-lg-none">
                            <i class="feather-menu text-dark" style="font-size: 2em;"></i>
                        </button>
                        <form action="" method="post" class="d-none d-lg-block">
                            <div class="form-inline">
                                <input type="text" class="form-control mr-2" placeholder="Search Everything">
                                <button class="btn btn-light">
                                    <i class="feather-search text-primary"></i>
                                </button>
                            </div>
                        </form>
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="../assets/uploads/<?php echo $_SESSION['user']['photo']; ?>"  class="user-img shadow-sm" alt=""> 
                                <?php echo $_SESSION['user']['name']; ?>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="profile.php"><i class="feather-user"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i class="feather-eye"></i> Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php"><i class="feather-log-out"></i> Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>