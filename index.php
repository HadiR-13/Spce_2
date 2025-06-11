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
            <div class="hero-content">
                <div class="text-content">
                    <h2>WANNA TRAVEL TO....</h2>
                    <h1>SPACE?</h1>
                    <p> When you want to go to space, <br /> you might as well bring back something worth the journey. <br /> Sit down and buckle up for a new experience! </p>
                </div>
                <div class="explore-button">
                    <button>
                        <a href="destination.php">EXPLORE</a>
                    </button>
                </div>
            </div>
        
            
            <div class="mission-content">
                <div class="mission-image">
                    <img id="mission-img" src="" alt="" />
                </div>
                <div class="mission-info">
                    <h2 class="mission-section-title">Our Missions</h2>
                    <ul class="mission-tabs">
                        <li class="active">Exploration</li>
                        <li>Travel</li>
                        <li>Mining</li>
                        <li>Colonization</li>
                    </ul>
                    <h1 id="mission-name" class="mission-name" style="font-size: 70px;">EXPLORATION</h1>
                    <p class="mission-description"> See our planet as you’ve never seen it before. A perfect relaxing trip away to help regain perspective and come back refreshed. While you’re there, take in some history by visiting the Luna 2 and Apollo 11 landing sites. </p>
                    <hr />
                    <div class="stats">
                        <div>
                            <h3>DURATION</h3>
                            <p id="mission-duration" style="font-size: 14px;">384,400 KM</p>
                        </div>
                        <div>
                            <h3>EQUIPMENT</h3>
                            <p id="mission-equipment" style="font-size: 14px;">3 DAYS</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script src="./js/home.js"></script>
        <script>
            let missions = {};

            document.addEventListener("DOMContentLoaded", function () {
                fetch("./data/missions.json")
                .then((res) => res.json())
                .then((data) => {
                    missions = data;
                    updateMission("Exploration");
                });

                const tabs = document.querySelectorAll(".mission-tabs li");
                tabs.forEach((tab) => {
                tab.addEventListener("click", function () {
                    tabs.forEach((t) => t.classList.remove("active"));
                    this.classList.add("active");
                    const selected = this.textContent.trim();
                    updateMission(selected);
                });
                });
            });

            function updateMission(key) {
                const mission = missions[key];
                if (!mission) return;

                document.getElementById("mission-img").src = mission.image;
                document.getElementById("mission-name").textContent = mission.name;
                document.querySelector(".mission-description").textContent = mission.description;
                document.getElementById("mission-duration").textContent = mission.duration;
                document.getElementById("mission-equipment").textContent = mission.equipment;
            }
        </script>
    </body>
</html>