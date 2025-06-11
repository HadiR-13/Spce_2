<?php
    require './content/conf.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Space</title>
</head>
<body>
    <?php include './content/navbar.php'; ?>
    <main>
        <div id="container3D"></div>
        <section class="container" id="main-page">
            <div class="title">
                <h1 class="main-title">Hello</h1>
            </div>
            <div class="line"></div>
            <div class="sub-title">
                <p id="main-description">Hello</p>
            </div>
        </section>
        <section class="description" id="description-planet">
            <div class="container">
                <h2 class="main-title">Hellow</h2>
                <p id="detail-description">Haloha</p>
                <div class="line"></div>
                <div class="info">
                    <div>
                        <h3>AVG DISTANCE</h3>
                        <p id="distance-planet">0 KM</p>
                    </div>
                    <div>
                        <h3>EST. TRAVEL TIME</h3>
                        <p id="estimate-planet">0 DAYS</p>
                    </div>
                    <div>
                        <h3>COST</h3>
                        <p id="cost-travel">0 DOLLAR</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="booking" id="booking-planet">
            <div class="container">
                <div class="planet-id"></div>
                <h2>Book your seat to <span class="main-title">Hello</span></h2>
                <div class="user-seat">
                    <div class="seat" data-seat="1">
                        <img src="./asset/img/user.webp" alt="">
                        <h4>Seat 1</h4>
                    </div>
                    <div class="seat" data-seat="2">
                        <img src="./asset/img/user.webp" alt="">
                        <h4>Seat 2</h4>
                    </div>
                    <div class="seat" data-seat="3">
                        <img src="./asset/img/user.webp" alt="">
                        <h4>Seat 3</h4>
                    </div>
                    <div class="seat" data-seat="4">
                        <img src="./asset/img/user.webp" alt="">
                        <h4>Seat 4</h4>
                    </div>
                    <div class="seat" data-seat="5">
                        <img src="./asset/img/user.webp" alt="">
                        <h4>Seat 5</h4>
                    </div>
                </div>
                <button class="submit-btn" onclick="goToPayment()">Book Seat</button>
            </div>
        </section>
    </main>
    <script>
        const jsonUrl = "./data/planets.json?v=<?= filemtime('data/planets.json') ?>";
    </script>
    <script type="module" src="./js/app.js?v=<?= filemtime('js/app.js') ?>"></script>
    <script src="js/script.js?v=1.0"></script>
</body>
</html>