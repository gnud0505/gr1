<?php
include('../database.php');

$id = $_GET['id'];

$sql = "DELETE FROM student_subject WHERE student_id=$id";
if ($conn->query($sql) === TRUE) {
    $sql = "DELETE FROM students WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: list.php");
    } else {
        echo "Error deleting record from students: " . $conn->error;
    }
} else {
    echo "Error deleting record from student_subject: " . $conn->error;
}
?>
