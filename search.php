<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: ../login_register/login.php");
   exit();
}

require_once("database.php");

$query = "";
if (isset($_GET['query'])) {
    $query = $_GET['query'];
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
    WHERE 
        students.name LIKE '%$query%' OR 
        students.email LIKE '%$query%' OR 
        subjects.name LIKE '%$query%'";
    $result = $conn->query($sql);
} else {
    $result = null;
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
    <title>Search Students</title>
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
        <h1>Search Results</h1>
        <?php if ($result && $result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Student Email</th>
                        <th>Subject Name</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_email']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['grade']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No results found for "<?php echo htmlspecialchars($query); ?>"</p>
        <?php endif; ?>
        <?php $conn->close(); ?>
    </div>
</body>
</html>
