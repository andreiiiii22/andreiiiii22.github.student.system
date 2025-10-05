<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$search = "";

if (isset($_GET['search']) && !empty($_GET['search'])) {
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
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }
        body {
            margin: 0;
            background-color: #f7faf7;
            color: #333;
        }
        .container {
            max-width: 1100px;
            margin: 50px auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
        }
        .header h2 {
            color: #2e7d32;
            margin: 0;
            font-size: 26px;
        }
        .logout-btn {
            background-color: #e53935;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            transition: background 0.3s;
            font-weight: 500;
        }
        .logout-btn:hover {
            background-color: #c62828;
        }
        .top-actions {
            margin-top: 25px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .add-btn, .export-btn {
            background-color: #43a047;
            color: white;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }
        .add-btn:hover, .export-btn:hover {
            background-color: #2e7d32;
        }
        .search-bar {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }
        .search-bar input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            transition: 0.2s;
        }
        .search-bar input:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76,175,80,0.3);
        }
        .search-bar button {
            background-color: #43a047;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }
        .search-bar button:hover {
            background-color: #2e7d32;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f8f1;
        }
        .action-btn {
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            transition: 0.2s;
        }
        .edit-btn {
            background-color: #43a047;
        }
        .edit-btn:hover {
            background-color: #2e7d32;
        }
        .delete-btn {
            background-color: #e53935;
        }
        .delete-btn:hover {
            background-color: #c62828;
        }
        .no-data {
            text-align: center;
            color: #777;
            padding: 20px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Student Records</h2>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <?php if ($role == 'admin'): ?>
    <div class="top-actions">
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
            <tr><td colspan="7" class="no-data">No students found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
