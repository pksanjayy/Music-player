<?php
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

$conn = new mysqli('localhost', 'root', '', 'test');
if ($conn->connect_error) {
    echo "$conn->connect_error";
    die("Connection Failed : " . $conn->connect_error);
} else {
    // Check if the email already exists
    $checkQuery = "SELECT email FROM signup WHERE email = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();
    
    if ($checkStmt->num_rows > 0) {
        echo "Email already registered. Please retry with a different email.";
        $checkStmt->close();
        $conn->close();
        exit();
    }

    // Insert the new user if the email is not already registered
    $insertQuery = "INSERT INTO signup (username, password, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sss", $username, $password, $email);
    $stmt->execute();
    echo "Registration successful...";
    
    $stmt->close();
    $conn->close();

    header("Location: index.php");
    exit();
}
?>
