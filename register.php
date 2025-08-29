<?php
session_start();
require_once "db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        // dla prostego testu – hasło w czystym tekście
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        try {
            $stmt->execute([$username, $password]);
            $success = "User registered successfully!";
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
            padding-top: 50px;
        }

        .register-box {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 350px;
            text-align: center;
        }

        .register-box h2 {
            margin-bottom: 20px;
            color: #333;
            text-transform: uppercase;
            matgin-bottom: 20px;
            letter-spacing: 1px;
        }

        .register-box input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .register-box button {
            width: 100%;
            padding: 10px;
            background-color: #667eea;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .register-box button:hover {
            background-color: #5a67d8;
        }
        .error{color:red;
        margin-bottom: 15px;
        font-size: 14px;}

        .success{color:green;
        margin-bottom: 15px;
        font-size: 14px;}
        
    </style>
</head>
<body>
    <h2>Register</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>

