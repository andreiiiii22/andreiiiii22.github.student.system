<?php
session_start();
include 'db.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $phone = trim($_POST['phone']);

    if ($student_id && $name && $email && $course && $phone) {
        $check = $conn->query("SELECT * FROM students WHERE student_id='$student_id' OR email='$email'");
        if ($check->num_rows > 0) {
            $msg = "<p class='error'>❌ Student already exists in the system.</p>";
        } else {
            $stmt = $conn->prepare("INSERT INTO students (student_id, name, email, course, phone) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $student_id, $name, $email, $course, $phone);
            $stmt->execute();
            $msg = "<p class='success'>✅ Student added successfully!</p>";
            $stmt->close();
        }
    } else {
        $msg = "<p class='error'>⚠ Please fill in all fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            display: flex;
        }
        .sidebar {
            width: 220px;
            background: #2e7d32;
            color: white;
            height: 100vh;
            padding: 20px;
            position: fixed;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #388e3c;
        }

        .main-content {
            margin-left: 240px;
            padding: 30px;
            flex: 1;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h2 {
            margin: 0;
        }
        .logout-btn {
            background-color: #f44336;
            padding: 8px 12px;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .form-container {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            width: 400px;
            margin-top: 40px;
            animation: fadeIn 0.6s ease;
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-10px);}
            to {opacity: 1; transform: translateY(0);}
        }
        label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
            font-weight: 600;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #bbb;
            border-radius: 6px;
            margin-bottom: 10px;
        }
        button {
            background-color: #4CAF50;
            border: none;
            padding: 10px;
            width: 100%;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .success {
            color: green;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Dashboard</h2>
    <a href="index.php">🏠 Home</a>
    <a href="add.php" style="background-color:#388e3c;">➕ Add Student</a>
    <a href="export.php">⬇ Export CSV</a>
    <a href="logout.php" class="logout-btn" style="margin-top:20px;">🚪 Logout</a>
</div>

<div class="main-content">
    <div class="header">
        <h2>Add a New Student</h2>
    </div>

    <div class="form-container">
        <?= $msg ?>
        <form method="POST">
            <label>Student ID</label>
            <input type="text" name="student_id" required>

            <label>Full Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Course</label>
            <input type="text" name="course" required>

            <label>Phone</label>
            <input type="text" name="phone" required>

            <button type="submit">Add Student</button>
        </form>
    </div>
</div>

</body>
</html>
