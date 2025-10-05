<?php
session_start();
include 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("No student ID provided!");
}

$id = $_GET['id'];

// Fetch existing student data
$result = $conn->query("SELECT * FROM students WHERE id = '$id'");
if ($result->num_rows == 0) {
    die("Student not found!");
}

$student = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $student_id = trim($_POST['student_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $phone = trim($_POST['phone']);

    // Update student record
    $update = $conn->query("UPDATE students 
        SET student_id='$student_id', name='$name', email='$email', course='$course', phone='$phone'
        WHERE id='$id'");

    if ($update) {
        $_SESSION['msg'] = "Student record updated successfully!";
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Edit Student Record</h2>
    <form method="POST">
        <label>Student ID:</label>
        <input type="text" name="student_id" value="<?= $student['student_id'] ?>" required><br>

        <label>Name:</label>
        <input type="text" name="name" value="<?= $student['name'] ?>" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?= $student['email'] ?>" required><br>

        <label>Course:</label>
        <input type="text" name="course" value="<?= $student['course'] ?>" required><br>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?= $student['phone'] ?>" required><br>

        <button type="submit" name="update">Update</button>
        <a href="index.php" class="cancel-btn">Cancel</a>
    </form>
</div>
</body>
</html>
