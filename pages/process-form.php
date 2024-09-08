<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "enquiry_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $state = htmlspecialchars(trim($_POST["stream"]));
    $course = htmlspecialchars(trim($_POST["course"]));

    // Validate inputs
    if (empty($name) || empty($email) || empty($phone) || empty($stream) || empty($course)) {
        die("All fields are required.");
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO enquiries (name, email, phone, stream, course) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $stream, $course);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Thank you for your enquiry. We will get back to you soon.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
