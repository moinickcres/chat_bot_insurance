<?php
require '../config/db.php';
require '../vendor/autoload.php';  // Load the JWT library
use \Firebase\JWT\JWT;

session_start();

$secretKey = "your-secret-key";  // Use a secure key to sign the JWT

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch the admin user from the database
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify the password
    if ($admin && password_verify($password, $admin['password'])) {
        // Password is valid, create the payload for the JWT
        $payload = [
            'iss' => 'yourdomain.com',  // Issuer
            'iat' => time(),            // Issued at
            'exp' => time() + 3600,     // Token expires in 1 hour
            'admin_id' => $admin['id'], // Admin ID from database
            'username' => $admin['username'] // Admin username
        ];

        // Generate the JWT
        $jwt = JWT::encode($payload, $secretKey, 'HS256');

        // Send the JWT as a response (usually in a header or cookie)
        setcookie("admin_token", $jwt, time() + 3600, "/", "", false, true); // HTTP only cookie

        // Redirect to admin.php after successful login
        header('Location: admin.php');
        exit;
    } else {
        echo "Invalid username or password!";
    }
}
?>

<!-- Login form -->
<form method="POST" action="admin_login.php">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Login">
</form>
