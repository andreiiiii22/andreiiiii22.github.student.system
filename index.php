<?php
session_start();
include 'db.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$search = "";

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $query = "SELECT * FROM students WHERE 
              student_id LIKE '%$search%' OR 
              name LIKE '%$search%' OR 
              email LIKE '%$search%' OR 
              course LIKE '%$search%'";
} else {
    $query = "SELECT * FROM students";
}

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Records</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logout-btn {
            background-color: #f44336;
            padding: 8px 12px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background-color: #e53935;
        }
        .action-btn {
            display: inline-block;
            padding: 5px 10px;
            margin: 2px;
            text-decoration: none;
            border-radius: 5px;
            color: white;
        }
        .edit-btn {
            background-color: #2196F3;
        }
        .delete-btn {
            background-color: #f44336;
        }
        .add-btn {
            background-color: #4CAF50;
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
        }
        .export-btn {
            background-color: #009688;
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
        }
        .search-bar {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }
        .search-bar input {
            flex: 1;
            padding: 8px;
        }
        .search-bar button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Student Records</h2>
        <div>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <?php if ($role == 'admin'): ?>
    <div style="margin-top: 15px;">
        <a href="add.php" class="add-btn">➕ Add Student</a>
        <a href="export.php" class="export-btn">⬇ Export CSV</a>
    </div>
    <?php endif; ?>

    <form class="search-bar" method="GET">
        <input type="text" name="search" placeholder="Search students..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Phone</th>
                <?php if ($role == 'admin'): ?>
                <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['student_id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['course']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <?php if ($role == 'admin'): ?>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">No students found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
