<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login_register/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./styles/header.css">
    <link rel="stylesheet" href="./styles/index.css">
    <title>User Dashboard</title>
</head>
<body>
    <header class="navbar">
        <ul class="nav-item nav-menu">
            <li><a href="index.php" class="menu-active">Dashboard</a></li>
            <li><a href="students/list.php">Manage Students</a></li>
            <li><a href="subjects/list.php">Manage Subjects</a></li>
        </ul>
        <form class="nav-item search-form" action="search.php" method="GET">
            <input type="search" name="query" placeholder="Search" aria-label="Search">
            <button type="submit" onclick="window.location.href='search.php'"><i class="fas fa-search"></i></button>
        </form>
        <button class="nav-item logout-btn" onclick="window.location.href='login_register/logout.php'">Logout</button>
    </header>
    <div class="container mt-4">
        <h2>Top Students by Average Grades</h2>
        <?php
            require_once "database.php";
            $sql = "
                SELECT students.id ,students.name, students.email, AVG(student_subject.grade) as average_grade
                FROM students
                JOIN student_subject ON students.id = student_subject.student_id
                GROUP BY students.id
                ORDER BY average_grade DESC
                LIMIT 10
            ";
        
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $stt=1;
                echo '<table class="table">';
                echo '<thead><tr><th>STT</th><th>Id</th><th>Name</th><th>Email</th><th>Average Grade</th></tr></thead><tbody>';
                while($row = $result->fetch_assoc()) {
                    echo '<tr><td>' . $stt . '</td><td>' . $row["id"] . '</td><td>' . $row["name"] . '</td><td>' . $row["email"] . '</td><td>' . $row["average_grade"] . '</td></tr>';
                    $stt++;
                }
                echo '</tbody></table>';
            } else {
                echo '<p>No students found.</p>';
            }
            $conn->close();
        ?>
    </div>
</body>
</html>
