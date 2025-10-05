<?php
session_start();
include 'db.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username && $password) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header("Location: index.php");
                exit();
            } else {
                $msg = "<p class='error'>❌ Incorrect password.</p>";
            }
        } else {
            $msg = "<p class='error'>⚠ User not found.</p>";
        }
        $stmt->close();
    } else {
        $msg = "<p class='error'>⚠ Please enter both fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login | Student System</title>
<style>
    * {
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
    }
    body {
        margin: 0;
        height: 100vh;
        background: linear-gradient(135deg, #4CAF50, #2e7d32);
        display: flex;
        justify-content: center;
        align-items: center;
        color: #333;
        animation: fadeIn 0.6s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .login-container {
        background-color: #fff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        width: 360px;
        text-align: center;
    }

    .login-container h2 {
        margin-bottom: 10px;
        color: #2e7d32;
    }

    .login-container p {
        color: #666;
        font-size: 14px;
        margin-bottom: 25px;
    }

    .form-group {
        text-align: left;
        margin-bottom: 15px;
    }

    label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 6px;
    }

    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #bbb;
        border-radius: 6px;
        font-size: 15px;
        outline: none;
        transition: 0.3s;
    }

    input:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.4);
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 10px;
    }

    button:hover {
        background-color: #43a047;
    }

    .error {
        background: #ffebee;
        color: #c62828;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 15px;
        font-weight: bold;
    }

    .footer {
        margin-top: 20px;
        font-size: 13px;
        color: #777;
    }

    .footer a {
        color: #2e7d32;
        text-decoration: none;
        font-weight: bold;
    }

    .footer a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>

<div class="login-container">
    <h2>Student Record System</h2>
    <p>Login to manage or view student data</p>

    <?= $msg ?>

    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter your username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <div class="footer">
        <p>© <?= date('Y') ?> Student Management System</p>
    </div>
</div>

</body>
</html>
