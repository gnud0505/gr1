<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: ../login_register/login.php");
   exit();
}

require_once("../database.php");

$id = $_GET['id'];

$sql = "SELECT 
    students.id AS student_id,
    students.name AS student_name,
    students.email AS student_email,
    subjects.id AS subject_id,
    subjects.name AS subject_name,
    student_subject.grade
FROM 
    students
JOIN 
    student_subject ON students.id = student_subject.student_id
JOIN 
    subjects ON subjects.id = student_subject.subject_id
WHERE subject_id = $id;";
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
    <title>Manage Subjects</title>
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
        <h1>Subject: 
            <?php
            if ($result->num_rows > 0) {
                // Get the first row to display the subject name
                $firstRow = $result->fetch_assoc();
                echo $firstRow['subject_name'];
                // Reset the result pointer and re-execute the query to fetch all rows again
                $result->data_seek(0);
            } else {
                echo "Not Found";
            }
            ?>
        </h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Student Id</th>
                    <th>Student Name</th>
                    <th>Student Email</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $stt = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$stt}</td>
                                <td>{$row['student_id']}</td>
                                <td>{$row['student_name']}</td>
                                <td>{$row['student_email']}</td>
                                <td>{$row['grade']}</td>
                              </tr>";
                        $stt++;
                    }
                } else {
                    echo "<tr><td colspan='3'>No subject found.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
