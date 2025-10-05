<?php
session_start();
include 'db.php';
if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST['student_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $phone = trim($_POST['phone']);

    $check = $conn->prepare("SELECT * FROM students WHERE student_id = ? OR email = ?");
    $check->bind_param("ss", $student_id, $email);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        $message = "Student already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO students (student_id, name, email, course, phone) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $student_id, $name, $email, $course, $phone);
        $stmt->execute();
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Add Student</h2>
    <?php if ($message) echo "<p class='error'>$message</p>"; ?>
    <form method="POST" action="">
        <input type="text" name="student_id" placeholder="Student ID" required>
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="course" placeholder="Course" required>
        <input type="text" name="phone" placeholder="Phone" required>
        <button type="submit">Save</button>
        <a href="index.php" class="btn cancel">Cancel</a>
    </form>
</div>
</body>
</html>
