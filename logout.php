<?php
session_start(); // Start the session

// Destroy the session to log out the user
session_unset();
session_destroy();

// Optionally, clear client-side cookies related to the session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Display a logout successful message
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .message-box {
            text-align: center;
            background-color: #ad8cac;
            padding: 20px;
            border-radius: 5px;
            color: whitesmoke;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #1a73e8;
            font-size: 16px;
            background-color: #ffffff;
            padding: 10px 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: 0.3s;
        }

        a:hover {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="message-box">
        <h1>You have successfully logged out.</h1>
        <p>Thank you for visiting. Click the link below to log in again.</p>
        <a href="index.html">Go to Login Page</a>
    </div>
</body>
</html>
