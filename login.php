<?php
$email = $_POST['email'];
$password = $_POST['password'];

$conn = new mysqli('localhost:3308', 'root', 'root', 'test');
if ($conn->connect_error) {
    echo "$conn->connect_error";
    die("Connection Failed: " . $conn->connect_error);
} else {
    $stmt = $conn->prepare("SELECT * FROM signup WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows >= 1) {
        $row = $result->fetch_assoc();
        if ($row['password'] === $password) {
            echo "success";
            header("Location: index.php");
            exit();
        } else {
            echo "invalid_password";
        }
    } else {
        echo "invalid_email";
    }
    
    $stmt->close();
    $conn->close();
}
?>
