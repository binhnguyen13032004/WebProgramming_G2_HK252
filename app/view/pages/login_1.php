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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Login Card Container */
        .login-container {
            background: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 30px;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #34495e;
        }

        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #3498db;
            outline: none;
        }

        /* Submit Button */
        button[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.3s ease, transform 0.1s ease;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
        }

        button[type="submit"]:active {
            transform: scale(0.99);
        }

        /* Error Message Styling */
        .error-message {
            color: #e74c3c;
            background-color: #fceceb;
            padding: 10px;
            border-radius: 4px;
            border-left: 4px solid #e74c3c;
            margin-bottom: 20px;
            font-size: 0.9em;
        }

        /* Footer Links */
        .links-container {
            text-align: center;
            margin-top: 25px;
            font-size: 0.9em;
        }

        .links-container a {
            color: #3498db;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .links-container a:hover {
            color: #2980b9;
            text-decoration: underline;
        }

        .links-separator {
            color: #bdc3c7;
            margin: 0 10px;
        }
    </style>
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