<?php
    require './content/conf.php';
    require './content/database_conf.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $stmt = $data->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $_SESSION["username"] = $username;
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["role"] = $row["role"];
            
            header("Location: ./");
            exit();
        } else {
            echo '<script>alert("Username or password incorrect");</script>';
        }

        $stmt->close();
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
    <?php include './content/navbar.php'; ?>
    <main class="register-page">
        <h2 class="register-subheading">
            <span>SPACE STATION</span> | JOIN US TO SPACE
        </h2>
        <form class="register-card" method="POST">
            <label for="inputEmail">Email</label>
            <input class="form-control" id="inputEmail" name="username" type="text" placeholder="Username" />
            <label for="inputPassword">Password</label>
            <input class="form-control" id="inputPassword" name="password" autocomplete="false" type="password" placeholder="Password" />
            <button type="submit" name="login">Log In</button>
        </form>
    </main>
    <script src="js/script.js"></script>
</body>
</html>