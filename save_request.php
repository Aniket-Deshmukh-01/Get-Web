<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method.");
}

// Database connection settings
$servername = "localhost";
$username   = "";  
$password   = "";       // Add your credentials
$dbname     = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve POST data
$name     = trim($_POST['name'] ?? '');
$business = trim($_POST['business'] ?? '');
$project  = trim($_POST['project'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');

// Validate required fields
if (empty($name) || empty($business) || empty($project) || empty($email)) {
    die("Please fill in all required fields.");
}

// Prepare statement
$stmt = $conn->prepare("INSERT INTO requests (name, business, project, email, phone) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sssss", $name, $business, $project, $email, $phone);

if ($stmt->execute()) {
    echo "✅ Request submitted successfully!";
} else {
    die("Insert failed: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
