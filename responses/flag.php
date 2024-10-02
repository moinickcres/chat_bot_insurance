<?php
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $queryId = $_POST['query_id'];

    // Update the query to mark it as flagged
    $stmt = $pdo->prepare("UPDATE queries SET flagged = 1 WHERE id = :id");
    $stmt->execute([':id' => $queryId]);

    echo json_encode(['success' => true]);
}
?>
