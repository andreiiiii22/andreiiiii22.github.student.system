<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $delete = $conn->query("DELETE FROM students WHERE id='$id'");

    if ($delete) {
        header("Location: index.php?msg=deleted");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No ID provided!";
}
?>
