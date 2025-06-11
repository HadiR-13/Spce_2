<?php
    require './database_conf.php';
    require './conf.php';

    if (!isset($_SESSION['username'])) {
        header("Location: ../login.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit-payment'])) {
        $planetId = $_POST['planet_id'] ?? null;
        $planetName = $_POST['planet_name'] ?? null;
        $cost = $_POST['cost'] ?? null;
        $seatNumber = $_POST['seat_number'] ?? null;
        $username = $_SESSION['username'] ?? null;

        $userQuery = "SELECT user_id FROM `user` WHERE username = ?";
        $userStmt = $conn->prepare($userQuery);
        if (!$userStmt) {
            die("Prepare failed (user): " . $conn->error);
        }
        $userStmt->bind_param("s", $username);
        $userStmt->execute();
        $userStmt->bind_result($userId);
        $userStmt->fetch();
        $userStmt->close();

        $insertQuery = "INSERT INTO booking (user_id, seat_number, planet_id) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        if (!$insertStmt) {
            die("Prepare failed (insert): " . $conn->error);
        }
        $insertStmt->bind_param("iss", $userId, $seatNumber, $planetId);
        $insertStmt->execute();

        if ($insertStmt->affected_rows > 0) {
            header('Location: ../');
            exit;
        } else {
            echo "Booking failed.";
        }

        $insertStmt->close();
        $conn->close();
    }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }

        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #0C4160;
            padding: 30px 10px;
        }

        .card {
            max-width: 500px;
            margin: auto;
            color: black;
            border-radius: 20px;
        }

        .h8 {
            font-size: 30px;
            font-weight: 800;
            text-align: center;
        }

        .btn-primary {
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 15px;
            background-image: linear-gradient(to right, #77A1D3 0%, #79CBCA 51%, #77A1D3 100%);
            border: none;
            transition: 0.5s;
            background-size: 200% auto;
        }

        .btn-primary:hover {
            background-position: right center;
            color: #fff;
        }

        .btn-primary:hover .fas.fa-arrow-right {
            transform: translateX(15px);
            transition: transform 0.2s ease-in;
        }

        .form-control {
            color: white;
            background-color: #223C60;
            border: 2px solid transparent;
            height: 60px;
            padding-left: 20px;
        }

        .form-control:focus {
            background-color: #0C4160;
            border-color: #2d4dda;
            box-shadow: none;
            color: white;
        }

        input[readonly] {
            background-color: #0C4160 !important;
            color:rgb(231, 234, 236);
            opacity: 1;
            pointer-events: none;
        }

        .text, ::placeholder {
            font-size: 14px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container p-0">
        <div class="card px-4">
            <p class="h8 py-3">Payment Details</p>
            <form method="post">
                <input type="hidden" name="planet_id" value="<?php echo htmlspecialchars($_POST['planet_id'] ?? ''); ?>">
                <input type="hidden" name="planet_name" value="<?php echo htmlspecialchars($_POST['planet_name'] ?? ''); ?>">
                <input type="hidden" name="cost" value="<?php echo htmlspecialchars($_POST['cost'] ?? ''); ?>">

                <p class="text mb-1">Username</p>
                <input class="form-control mb-3" type="text" value="<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>" readonly>

                <p class="text mb-1">Planet</p>
                <input class="form-control mb-3" type="text" value="<?php echo htmlspecialchars($_POST['planet_name'] ?? ''); ?>" readonly>

                <p class="text mb-1">Seat</p>
                <input class="form-control mb-3" name="seat_number" type="number" placeholder="Number" min="1" max="5" required>

                <button class="btn btn-primary mb-3" type="submit" name="submit-payment">
                    <?php echo '<span class="ps-3"> Pay $'. htmlspecialchars($_POST['cost'] ?? '0') .'</span>'; ?>
                    <span class="fas fa-arrow-right"></span>
                </button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
