<?php
session_start();
include 'db.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if ($username === '' || $password === '') {
        $msg = "<p class='error'>⚠ Please enter both fields.</p>";
    } else {
        // Safe query to check user
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Check hashed password
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Redirect
                header("Location: index.php");
                exit();
            } else {
                $msg = "<p class='error'>❌ Incorrect password.</p>";
            }
        } else {
            $msg = "<p class='error'>⚠ User not found.</p>";
        }

        $stmt->close();
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
        background-color: #f4f6f8;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #333;
    }

    .login-card {
        background: #fff;
        width: 380px;
        padding: 40px;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        text-align: center;
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    h2 {
        color: #2e7d32;
        margin-bottom: 8px;
    }

    p.subtitle {
        color: #777;
        margin-bottom: 25px;
        font-size: 14px;
    }

    label {
        display: block;
        text-align: left;
        font-weight: 600;
        margin: 10px 0 5px;
    }

    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
        transition: 0.3s;
        outline: none;
    }

    input:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 5px rgba(76,175,80,0.2);
    }

    button {
        width: 100%;
        margin-top: 15px;
        padding: 10px;
        border: none;
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #43a047;
    }

    .error {
        background-color: #ffebee;
        color: #c62828;
        padding: 10px;
        border-radius: 6px;
        font-weight: bold;
        margin-bottom: 10px;
        text-align: left;
    }

    .footer {
        margin-top: 20px;
        font-size: 13px;
        color: #777;
    }

    .footer a {
        color: #2e7d32;
        text-decoration: none;
        font-weight: 600;
    }

    .footer a:hover {
        text-decoration: underline;
    }

</style>
</head>
<body>

<div class="login-card">
    <h2>Student System</h2>
    <p class="subtitle">Sign in to continue</p>

    <?= $msg ?>

    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" placeholder="Enter username" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" required>

        <button type="submit">Login</button>
    </form>

    <div class="footer">
        <p>© <?= date('Y') ?> Student Management System</p>
    </div>
</div>

</body>
</html>

