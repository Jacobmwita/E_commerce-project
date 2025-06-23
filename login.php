<?php
session_start();

// Hardcoded credentials for the owner.
// !!! IMPORTANT: In a real production application, NEVER hardcode credentials like this.
// Use hashed passwords stored in a database and a more robust authentication system.
$owner_username = "jacob"; // Your desired username
$owner_password = "password123"; // Your desired password

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submitted_username = $_POST['username'] ?? '';
    $submitted_password = $_POST['password'] ?? '';

    if ($submitted_username === $owner_username && $submitted_password === $owner_password) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $owner_username; // Store username in session
        header("Location: index.php"); // Redirect to home page after successful login
        exit();
    } else {
        $login_error = "Invalid username or password.";
    }
}

// If already logged in, redirect to index
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Login - Jacob's Portfolio</title>
    <style>
        /* Shared Styling for Layout */
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .login-container h2 {
            font-size: 2.2em;
            color: #222;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: calc(100% - 20px);
            padding: 12px 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="password"]:focus {
            border-color: #00bcd4;
            box-shadow: 0 0 8px rgba(0, 188, 212, 0.2);
            outline: none;
        }

        .submit-btn {
            display: block;
            width: 100%;
            background: linear-gradient(45deg, #00bcd4, #0097a7);
            color: #fff;
            padding: 15px 25px;
            border: none;
            border-radius: 30px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 188, 212, 0.4);
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 188, 212, 0.6);
            background: linear-gradient(45deg, #0097a7, #00bcd4);
        }

        .error-message {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
        }

        .home-link {
            display: block;
            margin-top: 30px;
            text-decoration: none;
            color: #00bcd4;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .home-link:hover {
            color: #0097a7;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Owner Login</h2>
        <?php if ($login_error): ?>
            <div class="error-message"><?php echo $login_error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">Login</button>
        </form>
    </div>
    <a href="index.php" class="home-link">Back to Home Page</a>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log('login.php loaded.');
        });
    </script>
</body>
</html>
