<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'];

// Search
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT * FROM students WHERE name LIKE '%$search%' OR student_id LIKE '%$search%'";
} else {
    $query = "SELECT * FROM students";
}
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Student Records</h2>
    <p>Welcome, <b><?php echo $_SESSION['username']; ?></b> (<?php echo $role; ?>)</p>
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search..." value="<?php echo $search; ?>">
        <button type="submit">Search</button>
    </form>

    <?php if ($role == 'admin'): ?>
        <a href="add.php" class="btn">Add Student</a>
        <a href="export.php" class="btn">Export CSV</a>
    <?php endif; ?>
    <a href="logout.php" class="btn logout">Logout</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Student ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Phone</th>
            <?php if ($role == 'admin') echo "<th>Actions</th>"; ?>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['student_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['course']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <?php if ($role == 'admin'): ?>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this record?')">Delete</a>
                </td>
            <?php endif; ?>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
