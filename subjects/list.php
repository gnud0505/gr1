<?php
session_start();
require_once("../database.php");
$sql = "SELECT id, name FROM subjects;";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/list.css">
    <title>Manage Subjects</title>
</head>
<body>
    <header class="navbar">
        <ul class="nav-item nav-menu">
            <li><a href="../index.php">Dashboard</a></li>
            <li><a href="../students/list.php">Manage Students</a></li>
            <li><a href="../subjects/list.php"  class="menu-active">Manage Subjects</a></li>
        </ul>
        <form class="nav-item search-form" action="../search.php" method="GET">
            <input type="search" name="query" placeholder="Search" aria-label="Search">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
        <button class="nav-item logout-btn" onclick="window.location.href='../login_register/logout.php'">Logout</button>
    </header>
    <div class="container mt-4">
        <h1>Manage Subjects</h1>
        <a href="add.php" class="btn-link">Add New Subject</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $stt=1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$stt}</td>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>
                                    <a href='detail.php?id={$row['id']}' class='btn btn-primary'>View Details</a>
                                    <a href='edit.php?id={$row['id']}' class='btn btn-warning'>Edit</a>
                                    <a href='delete.php?id={$row['id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>
                                </td>
                              </tr>";
                        $stt++;
                    }
                } else {
                    echo "<tr><td colspan='3'>No students found.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
