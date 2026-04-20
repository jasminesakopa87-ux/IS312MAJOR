<?php
include '../config/db.php';

$student_number = isset($_GET['student_number']) ? trim($_GET['student_number']) : '';
$projects = [];

if (!empty($student_number)) {
    $sql = "SELECT * FROM projects WHERE student_number = ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_number);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Projects</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>View Projects</h1>

        <div class="card">
            <form method="GET" action="">
                <label>Enter Student Number</label>
                <input type="text" name="student_number" value="<?php echo htmlspecialchars($student_number); ?>" required>
                <button type="submit">Load Projects</button>
            </form>
        </div>

        <?php if (!empty($student_number)): ?>
            <div class="card">
                <h2>Projects for: <?php echo htmlspecialchars($student_number); ?></h2>

                <?php if (!empty($projects)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Technologies</th>
                                <th>GitHub</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projects as $project): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($project['title']); ?></td>
                                    <td><?php echo htmlspecialchars($project['description']); ?></td>
                                    <td><?php echo htmlspecialchars($project['technologies']); ?></td>
                                    <td>
                                        <?php if (!empty($project['github_link'])): ?>
                                            <a href="<?php echo htmlspecialchars($project['github_link']); ?>" target="_blank">Open</a>
                                        <?php else: ?>
                                            No link
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="edit_project.php?id=<?php echo $project['id']; ?>">Edit</a> |
                                        <a href="../project-service/delete_project.php?id=<?php echo $project['id']; ?>&student_number=<?php echo urlencode($project['student_number']); ?>"
                                           onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No projects found for this student number.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="back-link">
            <a href="index.php">← Back to Home</a>
        </div>
    </div>
</body>
</html>

