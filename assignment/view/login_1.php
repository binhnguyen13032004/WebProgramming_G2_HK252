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

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/styles.css">
    <title>Login</title>
    
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    
    <?php 
    // Display error message nicely if it exists
    if(!empty($error)) { 
        echo "<div class='error-message'>" . htmlspecialchars($error) . "</div>"; 
    } 
    ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="role">Login as:</label>
            <select name="role" id="role" required>
                <option value="" disabled selected>Select your role...</option>
                <option value="employee">Employee</option>
                <option value="employer">Employer</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Enter your email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <div class="links-container">
        <a href="register_1.php">Need an account? Register</a>
        <span class="links-separator">|</span>
        <a href="forgot_password.php">Forgot Password?</a>
    </div>
</div>

</body>
</html>