<?php
// Database credentials
$servername = "localhost";  // Change if your database server is different
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "villas";         // The database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $destination = htmlspecialchars($_POST['destination']);
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $rooms = $_POST['rooms'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO bookings (destination, check_in, check_out, rooms, adults, children, email, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sssiiiss", $destination, $check_in, $check_out, $rooms, $adults, $children, $email, $phone);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to a thank you page or display a success message
        header("Location: index.html");
        exit(); // Ensure no further code is executed
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}

