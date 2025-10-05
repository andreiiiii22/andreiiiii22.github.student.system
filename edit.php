<?php
session_start();
include 'db.php';
if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM students WHERE id = $id");
$student = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("UPDATE students SET student_id=?, name=?, email=?, course=?, phone=?
