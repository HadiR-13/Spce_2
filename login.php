<?php
    require './content/conf.php';
    require './content/database_conf.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST["action"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        if ($action === "login") {
            $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $_SESSION["username"] = $username;
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["email"] = $row["email"];
                $_SESSION["phone"] = $row["phone"];
                $_SESSION["role"] = $row["role"];
                header("Location: ./");
                exit();
            } else {
                echo '<script>alert("User not found.");</script>';
            }
            $stmt->close();

        } elseif ($action === "register") {
            $email = $_POST["email"];
            $phone = $_POST["phone"];

            $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                echo '<script>alert("Username already taken.");</script>';
            } else {
                $stmt = $conn->prepare("INSERT INTO user (username, password, email, phone, role) VALUES (?, ?, ?, ?, 'user')");
                $stmt->bind_param("ssss", $username, $password, $email, $phone);
                if ($stmt->execute()) {
                    echo '<script>alert("Registration successful. You can now log in.");</script>';
                } else {
                    echo '<script>alert("Registration failed.");</script>';
                }
            }
            $stmt->close();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/style.css" />
    <title>Space</title>
    <style>
        .hidden { display: none; }
        .form-toggle-link {
        display: inline-block;
        margin-top: 10px;
        color: blue;
        text-decoration: underline;
        cursor: pointer;
        }
    </style>
    </head>
    <body>
    <?php include './content/navbar.php'; ?>
    <main class="register-page">
        <h2 class="register-subheading"><span>SPACE STATION</span> | JOIN US TO SPACE</h2>

        <!-- Login Form -->
        <form id="loginForm" class="register-card" method="POST">
            <h3>Login</h3>
            <input type="hidden" name="action" value="login" />
            <label for="loginUsername">Username</label>
            <input id="loginUsername" name="username" type="text" required />

            <label for="loginPassword">Password</label>
            <input id="loginPassword" name="password" type="password" required />
            <button type="submit">Log In</button>
            <a class="form-toggle-link" onclick="showRegister()">Don't have an account? Register</a>
        </form>

        <!-- Register Form -->
        <form id="registerForm" class="register-card hidden" method="POST">
            <h3>Register</h3>
            <input type="hidden" name="action" value="register" />
            <label for="regUsername">Username</label>
            <input id="regUsername" name="username" type="text" required />

            <label for="regPassword">Password</label>
            <input id="regPassword" name="password" type="password" required />

            <label for="regEmail">Email</label>
            <input id="regEmail" name="email" type="email" required />

            <label for="regPhone">Phone Number</label>
            <input id="regPhone" name="phone" type="text" required />

            <button type="submit">Register</button>
            <a class="form-toggle-link" onclick="showLogin()">Already have an account? Log in</a>
        </form>
    </main>

    <script>
        function showRegister() {
            document.getElementById('loginForm').classList.add('hidden');
            document.getElementById('registerForm').classList.remove('hidden');
        }

        function showLogin() {
            document.getElementById('registerForm').classList.add('hidden');
            document.getElementById('loginForm').classList.remove('hidden');
        }
    </script>
    </body>
</html>
