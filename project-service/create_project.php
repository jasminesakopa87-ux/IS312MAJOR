<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_number = trim($_POST['student_number']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $technologies = trim($_POST['technologies']);
    $github_link = trim($_POST['github_link']);

    if (empty($student_number) || empty($title)) {
        die("Student number and project title are required.");
    }

    $sql = "INSERT INTO projects (student_number, title, description, technologies, github_link)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $student_number, $title, $description, $technologies, $github_link);

    if ($stmt->execute()) {
        header("Location: ../frontend/project_list.php?student_number=" . urlencode($student_number));
        exit();
    } else {
        echo "Error creating project: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

