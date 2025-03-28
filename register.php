<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get input values from the POST request
$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

// Check if the input fields are not empty
if (!empty($name) && !empty($email) && !empty($password)) {

    // Database connection parameters
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = '';
    $dbname = "user_database";

    // Create a connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    // Check for connection error
    if ($conn->connect_error) {
        die('Connect Error('. $conn->connect_errno .') ' . $conn->connect_error);
    } else {
        // Prepare the SQL query
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        
        // Hash the password for secure storage
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Bind parameters to the SQL query
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        // Execute the query
        if ($stmt->execute()) {
            echo "New record is inserted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }

} else {
    // Check which field is empty and provide feedback
    if (empty($name)) {
        echo "Name should not be empty";
    } elseif (empty($email)) {
        echo "Email should not be empty";
    } elseif (empty($password)) {
        echo "Password should not be empty";
    }
    die();
}
?>