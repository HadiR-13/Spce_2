<?php
require './content/conf.php';
require './content/database_conf.php';
if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
    exit();
}

$username = $_SESSION['username'];

if ($username) {
    $stmt = $conn->prepare("
        SELECT b.* 
        FROM user u
        JOIN booking b ON u.user_id = b.user_id
        WHERE u.username = ?
    ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $bookings = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $bookings = [];
}

$planetMap = [];
$planetData = @file_get_contents('./data/planets.json');
if ($planetData) {
    $planets = json_decode($planetData, true);
    foreach ($planets as $planet) {
        $planetMap[$planet['planet_id']] = $planet;
    }
}
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
        <style>
            :root {
                --primary-color: #0099cc;
                --glass-bg: linear-gradient(to right bottom, rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.3));
                --text-light: rgba(0, 0, 0, 0.6);
                --text-dark: rgba(0, 0, 0, 0.8);
                --shadow-light: rgba(0, 0, 0, 0.05);
                --shadow-dark: rgba(0, 0, 0, 0.08);
            }

            main {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 80%;
            }

            .contained-profile {
                display: grid;
                grid-template-columns: 1fr 2fr;
                grid-template-areas:
                    "header header"
                    "userProfile user_info"
                    "settings user_info";
                width: 85vw;
                background: var(--glass-bg);
                padding: 1rem;
                box-shadow: 0 0 5px rgba(255, 255, 255, 0.5), 0 0 25px var(--shadow-dark);
                gap: 1rem;
            }

            .card {
                background: var(--glass-bg);
                backdrop-filter: blur(3rem);
                border-radius: 0.5rem;
                box-shadow: 0 0 25px var(--shadow-light);
                padding: 1rem;
            }

            .userProfile {
                grid-area: userProfile;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .userProfile .profile img {
                width: 18rem;
                height: 18rem;
                border-radius: 50%;
                object-fit: cover;
            }

            .settings {
                grid-area: settings;
                padding: 1.5rem;
            }

            .settings .heading {
                font-size: 1rem;
                color: var(--text-light);
                text-transform: uppercase;
                margin-bottom: 1.5rem;
                position: relative;
            }

            .settings .heading::before {
                content: "";
                position: absolute;
                bottom: 0;
                left: 0;
                height: 0.1rem;
                width: 88%;
                background: rgba(0, 0, 0, 0.4);
            }

            .settings .work h1 {
                font-size: 1.4rem;
                color: var(--text-dark);
                margin-bottom: 0.6rem;
            }

            .settings .work div span {
                position: absolute;
                top: 0;
                right: 3rem;
                font-weight: 700;
                font-size: 1.1rem;
                color: var(--primary-color);
                background: #e6f2ff;
                padding: 0.4rem 1rem;
                border-radius: 0.4rem;
            }

            .settings .work div p {
                font-size: 1.4rem;
                color: var(--text-light);
                line-height: 1.6rem;
                margin-bottom: 1.8rem;
            }

            .settings .work a:hover h1 {
                color: var(--text-light);
                text-decoration: underline;
                cursor: pointer;
            }

            .user_info {
                grid-area: user_info;
                padding: 2.5rem;
            }

            .tabs ul {
                display: flex;
                list-style: none;
                padding: 0;
                margin: 0 0 2.5rem 0;
                border-bottom: 1px solid rgba(0, 0, 0, 0.2);
            }

            .tabs ul li {
                margin-right: 2.5rem;
                padding-bottom: 0.8rem;
                cursor: pointer;
                position: relative;
            }

            .tabs ul li span {
                font-size: 1.2rem;
                font-weight: 500;
            }

            .tabs ul .active::before {
                content: "";
                position: absolute;
                bottom: 0;
                left: 0;
                height: 2px;
                width: 100%;
                background: var(--primary-color);
            }

            .user_detail .heading {
                font-size: 1rem;
                color: var(--text-light);
                text-transform: uppercase;
                margin-bottom: 1.5rem;
            }

            .user_detail ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .user_detail ul li {
                display: flex;
                margin: 0.5rem 0;
            }

            .user_detail ul li h1 {
                font-weight: 500;
                font-size: 1.2rem;
                min-width: 12rem;
            }

            .user_detail ul li span {
                font-size: 1.2rem;
            }

            .user_detail#map {
                height: 80%;
                padding: 0;
                margin: 0;
            }

            .map-frame {
                width: 100%;
                height: 80%;
                border: none;
                display: block;
            }
        </style>
        <?php include './content/navbar.php'; ?> 
        <main>
            <div class="contained-profile">
                <section class="userProfile card">
                    <div class="profile">
                        <figure>
                            <img src="./asset/img/user.webp" alt="profile" width="250px" height="250px">
                        </figure>
                    </div>
                </section>
                <section class="settings card">
                    <div class="work">
                        <h1 class="heading">Settings</h1>
                        <div>
                            <a href="./" style="text-decoration: none; color: inherit;">
                                <h1>Account</h1>
                            </a>
                        </div>
                        <div>
                            <a href="./logout.php" style="text-decoration: none; color: inherit;">
                                <h1>Log Out</h1>
                            </a>
                        </div>
                    </div>
                </section>
                <section class="user_info card">
                    <div class="tabs">
                        <ul>
                            <li class="timeline tab" data-target="ticket">
                                <span>Ticket</span>
                            </li>
                            <li class="about tab active" data-target="about">
                                <span>About</span>
                            </li>
                            <li class="map tab" data-target="map">
                                <span>Map</span>
                            </li>
                        </ul>
                    </div>

                    <div class="user_detail" id="about">
                        <h1 class="heading">Personal Information</h1>
                        <ul>
                            <li class="Username">
                                <h1 class="label">Username:</h1>
                                <?php echo '<span class="info">'. $_SESSION["username"] .'</span>'; ?>
                            </li>
                            <li class="phone">
                                <h1 class="label">Phone:</h1>
                                <?php echo '<span class="info">'. $_SESSION["phone"] .'</span>'; ?>
                            </li>
                            <li class="email">
                                <h1 class="label">E-mail:</h1>
                                <?php echo '<span class="info">'. $_SESSION["email"] .'</span>'; ?>
                            </li>
                        </ul>
                    </div>
                    <div class="user_detail" id="ticket" style="display: none;">
                        <h1 class="heading">Ticket Information</h1>
                        <?php if (!empty($bookings)): ?>
                        <ul>
                        <?php foreach ($bookings as $booking): 
                            $planet_id = $booking['planet_id']; 
                            $planet = $planetMap[$planet_id] ?? null;
                        ?>
                            <?php if ($planet): ?>
                            <li style="margin-bottom: 1.5rem;">
                            <h1>Planet Tujuan: <span><?= htmlspecialchars($planet['planet_id']) ?></span></h1><br>
                            <p 
                                style="color: var(--text-light); margin: 0.3rem 0;">Jarak: <?= htmlspecialchars($planet['distance']) ?><br>
                                Estimasi Perjalanan: <?= htmlspecialchars($planet['estimasi']) ?><br>
                                Biaya: <?= htmlspecialchars($planet['cost']) ?><br>
                                No Tempat Duduk: <?= htmlspecialchars($booking['seat_number']) ?><br>
                            </p>
                            </li>
                            <?php else: ?>
                            <li><p style="color:red;">Data planet dengan ID <?= htmlspecialchars($planet_id) ?> tidak ditemukan.</p></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </ul>
                        <?php else: ?>
                        <p>You have no tickets at the moment.</p>
                        <?php endif; ?>
                    </div>
                    <div class="user_detail" id="map" style="display: none; height: 100%;">
                        <iframe src="./content/map" frameborder="0" class="map-frame"></iframe>
                    </div>
                </section>
            </div>
        </main>
        <script src="js/script.js?v=1.0"></script>
    </body>
</html>