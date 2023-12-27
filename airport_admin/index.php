<?php
include "app/database/db.php";
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/014c37252f.js" crossorigin="anonymous"></script>

    <!-- Custom Styling-->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <title>AIRPORT_ADMIN demo</title>
    <link rel="icon" href=https://i.ibb.co/09w47pS/logo.png type="image/x-icon">
</head>
<body>

<!-- Блок хедера -->
<?php include("app/include/header-user.php"); ?>

<!-- Блок карусели - START -->
<div id="carouselExampleDark" class="carousel carousel-dark slide">
    <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="10000">
            <img src="assets/images/p_1.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5><a href="">Slide label</a></h5>
                <p>Some representative placeholder content for the first slide.</p>
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="2000">
            <img src="assets/images/p_2.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5><a href="">Slide label</a></h5>
                <p>Some representative placeholder content for the second slide.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/images/p_3.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5><a href="">Slide label</a></h5>
                <p>Some representative placeholder content for the third slide.</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<!-- Блок карусели - END-->

<!-- Блок футера -->
<?php include("app/include/footer-bottom.php"); ?>

</body>
</html>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>