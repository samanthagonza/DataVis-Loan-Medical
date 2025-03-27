<?php
include "dbconfig.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate input
    if (empty($username) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Both username and password are required."]);
        exit();
    }

    // Database connection
    $con = new mysqli('imc.kean.edu', 'gonzasa3', '1182658', '2024F_gonzasa3');
    if ($con->connect_error) {
        echo json_encode(["success" => false, "message" => "Database connection failed: " . $con->connect_error]);
        exit();
    }

    // Query to check credentials
    $stmt = $con->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Validate password
        if ($row['password'] === $password) {
            $_SESSION['username'] = $username;
            $_SESSION['logged_in'] = true; // Mark the user as logged in
            echo json_encode(["success" => true, "message" => "Login successful."]);
        } else {
            echo json_encode(["success" => false, "message" => "Incorrect password."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Username not found."]);
    }

    $stmt->close();
    $con->close();
}
?>
