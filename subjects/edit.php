<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: ../login_register/login.php");
   exit();
}

require_once("../database.php");
$subject_id = intval($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    $sql = "UPDATE subjects SET name='$name' WHERE id=$subject_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: list.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT name FROM subjects WHERE id = $subject_id";
$result = $conn->query($sql);
$student = $result->fetch_assoc();
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
    <link rel="stylesheet" href="../styles/edit.css">
    <title>Edit Student</title>
</head>
<body>
    <header class="navbar">
        <ul class="nav-item nav-menu">
            <li><a href="../index.php">Dashboard</a></li>
            <li><a href="../students/list.php">Manage Students</a></li>
            <li><a href="../subjects/list.php" class="menu-active">Manage Subjects</a></li>
        </ul>
        <form class="nav-item search-form" action="../search.php" method="GET">
            <input type="search" name="query" placeholder="Search" aria-label="Search">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
        <button class="nav-item logout-btn" onclick="window.location.href='../login_register/logout.php'">Logout</button>
    </header>
    <div class="container mt-4">
        <h1>Edit Subject</h1>
        <form action="edit.php?id=<?php echo $subject_id; ?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $student['name']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Subject</button>
        </form>
        <a href="list.php" class="btn btn-secondary mt-3">Back to List</a>
    </div>
</body>
</html>
