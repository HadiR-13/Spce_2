<?php
    header('Content-Type: application/json');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require './database_conf.php';

    $input = json_decode(file_get_contents("php://input"), true);
    $planetId = $input['id'];

    $stmt = $conn->prepare("SELECT b.seat_number, u.username FROM booking b JOIN `user` u ON b.user_id = u.user_id WHERE b.planet_id = ?");
    $stmt->bind_param("s", $planetId);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookedSeats = [];
    while ($row = $result->fetch_assoc()) {
        $bookedSeats[] = $row;
    }

    echo json_encode($bookedSeats);
?>