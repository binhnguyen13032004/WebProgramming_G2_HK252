<?php
/*require 'db.php';
$error = '';

// If user is already logged in, redirect them away from the login page
if (isset($_SESSION['user_id'])) {
    header("Location: public/index.php"); // Or search.php
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Fetch user by email
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // password_verify() safely compares the plain text input against the hashed DB entry
    if ($user && password_verify($password, $user['password'])) {
        // Login Success! Set session variables.
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $email;
        
        header("Location: public/index.php"); // Redirect to a protected page
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}*/
?>

<h2>Login</h2>
<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">
    <label>Email:</label>
    <input type="email" name="email" required><br><br>
    
    <label>Password:</label>
    <input type="password" name="password" required><br><br>
    
    <button type="submit">Login</button>
</form>
<a href="register_1.php">Need an account? Register</a> | 
<a href="forgot_password.php">Forgot Password?</a>