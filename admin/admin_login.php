<?php
require '../config/db.php';
require '../vendor/autoload.php';  // Load the JWT library
use \Firebase\JWT\JWT;

session_start();

$secretKey = "your-secret-key";  // Use a strong, secure key

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch the admin user from the database
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify the password (you should hash passwords in production)
    if ($admin && $password === $admin['password']) {
        // Create the payload for the JWT
        $payload = [
            'iss' => 'yourdomain.com',  // Issuer
            'iat' => time(),            // Issued at
            'exp' => time() + 3600,     // Token expires in 1 hour
            'admin_id' => $admin['id']  // Admin ID
        ];

        // Encode the payload to create a JWT
        $jwt = JWT::encode($payload, $secretKey);

        // Set the JWT as a cookie
        setcookie("admin_token", $jwt, time() + 3600, "/", "", false, true);  // Set as HTTP only cookie
        header('Location: admin.php');
        exit;
    } else {
        echo "Invalid login!";
    }
}
?>

<!-- Login form -->
<form method="POST" action="admin_login.php">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Login">
</form>
