<?php
session_start();
require_once("../database.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "INSERT INTO students (name, email) VALUES ('$name', '$email')";

    if ($conn->query($sql) === TRUE) {
        header("Location: list.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
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
    <link rel="stylesheet" href="../styles/add.css">
    <title>Add Student</title>
</head>
<body>
    <header class="navbar">
        <ul class="nav-item nav-menu">
            <li><a href="../index.php">Dashboard</a></li>
            <li><a href="../students/list.php" class="menu-active">Manage Students</a></li>
            <li><a href="../subjects/list.php">Manage Subjects</a></li>
        </ul>
        <form class="nav-item search-form" action="../search.php" method="GET">
            <input type="search" name="query" placeholder="Search" aria-label="Search">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
        <button class="nav-item logout-btn" onclick="window.location.href='../login_register/logout.php'">Logout</button>
    </header>
    <div class="container mt-4">
        <h1>Add New Student</h1>
        <form action="add.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Student</button>
        </form>
        <a href="list.php" class="btn btn-secondary mt-3">Back to List</a>
    </div>
</body>
</html>
