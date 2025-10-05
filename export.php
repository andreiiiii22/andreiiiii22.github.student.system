<?php
include 'db.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=student_records.csv');

$output = fopen("php://output", "w");
fputcsv($output, array('Student ID', 'Name', 'Email', 'Course', 'Phone'));

$result = $conn->query("SELECT student_id, name, email, course, phone FROM students");
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}
fclose($output);
exit();
?>

