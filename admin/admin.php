<?php
require '../config/db.php';
require '../vendor/autoload.php';  // Load the JWT library
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$secretKey = "your-secret-key";

// Check for the JWT token in cookies
if (!isset($_COOKIE['admin_token'])) {
    header('Location: admin_login.php');
    exit;
}

$token = $_COOKIE['admin_token'];

try {
    // Decode and verify the JWT token
    $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));

    // Access granted, proceed with fetching flagged queries
    $stmt = $pdo->query("SELECT * FROM queries WHERE flagged = 1");
    $flaggedQueries = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    // If the token is invalid or expired, redirect to login
    header('Location: admin_login.php');
    exit;
}
?>

<h1>Flagged Queries</h1>

<?php foreach ($flaggedQueries as $query): ?>
    <div>
        <strong>Query:</strong> <?= htmlspecialchars($query['user_query']) ?><br>
        <strong>Response:</strong> <?= htmlspecialchars($query['ai_response']) ?><br>
        <em>Flagged as incorrect.</em>
    </div>
    <hr>
<?php endforeach; ?>
