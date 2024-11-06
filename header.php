<?php
    require_once('core.inc.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="Certificate Verification System" content="" />
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Phudu:wght@500&family=Ubuntu:wght@500&display=swap');
            body{
                font-family: 'Ubuntu', sans-serif;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    </head>
    <body class="d-flex flex-column h-100">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand fw-bold" href="index.php">Certificate Verification System</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                            <?php
                                if (loggedin()) {
                            ?>

                                <li class="nav-item"><a class="nav-link" href="home.php">Dashboard</a></li>
                                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                                
                            <?php
                                }else{
                            ?>
                                <li class="nav-item"><a class="nav-link" href="login.php">User</a></li>
                                <li class="nav-item"><a class="nav-link" href="login.php">Admin</a></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Header-->