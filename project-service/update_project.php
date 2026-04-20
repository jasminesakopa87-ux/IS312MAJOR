<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $student_number = trim($_POST['student_number']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $technologies = trim($_POST['technologies']);
    $github_link = trim($_POST['github_link']);

    if ($id <= 0 || empty($student_number) || empty($title)) {
        die("Project id, student number, and title are required.");
    }

    $sql = "UPDATE projects
            SET title = ?, description = ?, technologies = ?, github_link = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $description, $technologies, $github_link, $id);

    if ($stmt->execute()) {
        header("Location: ../frontend/project_list.php?student_number=" . urlencode($student_number));
        exit();
    } else {
        echo "Error updating project: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

