<?php
include '../config/db.php';

header('Content-Type: application/json');

if (isset($_GET['student_number'])) {
    $student_number = trim($_GET['student_number']);

    $sql = "SELECT * FROM projects WHERE student_number = ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_number);
    $stmt->execute();
    $result = $stmt->get_result();

    $projects = [];
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }

    echo json_encode($projects);

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["message" => "student_number is required"]);
}
?>

