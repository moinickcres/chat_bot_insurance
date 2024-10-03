<?php
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new admin into the database
    $stmt = $pdo->prepare("INSERT INTO admin_users (username, password) VALUES (:username, :password)");
    $stmt->execute([':username' => $username, ':password' => $hashedPassword]);

    echo "New admin registered successfully!";
}
?>

<!-- Registration form for new admin -->
<form method="POST" action="admin_register.php">
    <input type="text" name="username" placeholder="New Username" required>
    <input type="password" name="password" placeholder="New Password" required>
    <input type="submit" value="Register Admin">
</form>
