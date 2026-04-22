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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        /* Register Card Container */
        .register-container {
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

        /* Message Styling (Error & Success) */
        .error-message {
            color: #e74c3c;
            background-color: #fceceb;
            padding: 10px;
            border-radius: 4px;
            border-left: 4px solid #e74c3c;
            margin-bottom: 20px;
            font-size: 0.9em;
        }

        .success-message {
            color: #27ae60;
            background-color: #eafaf1;
            padding: 10px;
            border-radius: 4px;
            border-left: 4px solid #27ae60;
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
    </style>
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