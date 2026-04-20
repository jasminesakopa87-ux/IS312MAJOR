<?php
include '../config/db.php';

if (isset($_GET['id']) && isset($_GET['student_number'])) {
    $id = intval($_GET['id']);
    $student_number = trim($_GET['student_number']);

    if ($id <= 0) {
        die("Invalid project id.");
    }

    $sql = "DELETE FROM projects WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../frontend/project_list.php?student_number=" . urlencode($student_number));
        exit();
    } else {
        echo "Error deleting project: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    die("Project id and student number are required.");
}
?>
