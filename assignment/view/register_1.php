<?php
/*require 'db.php';
$error = '';
$success = '';*/

/*if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 1. Input Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } else {
        // 2. Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email is already registered.";
        } else {
            // 3. Hash Password (NEVER store plain text)
            // PASSWORD_DEFAULT currently uses bcrypt, which is highly secure
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // 4. Insert User
            $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            if ($stmt->execute([$email, $hashed_password])) {
                $success = "Registration successful! You can now login.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/styles.css">
    <title>Register</title>
    
</head>
<body>

<div class="register-container">
    <h2>Register</h2>
    
    <?php 
    // Display error message nicely if it exists
    if(!empty($error)) { 
        echo "<div class='error-message'>" . htmlspecialchars($error) . "</div>"; 
    } 
    // Display success message nicely if it exists
    if(!empty($success)) { 
        echo "<div class='success-message'>" . htmlspecialchars($success) . "</div>"; 
    } 
    ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="role">I am registering as a(n):</label>
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
            <input type="password" name="password" id="password" placeholder="Create a password" required>
        </div>

        <button type="submit">Register</button>
    </form>

    <div class="links-container">
        <a href="login_1.php">Already have an account? Login here</a>
    </div>
</div>

</body>
</html>