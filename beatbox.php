<?php

$conn = new mysqli('localhost', 'root', '', 'test');
if ($conn->connect_error) {
    echo "$conn->connect_error";
    die("Connection Failed : " . $conn->connect_error);
} else {
    // Check if the email already exists
    $query = "SELECT name, artist, src, thumbnail FROM beats";
    $result = mysqli_query($connection, $query);
    
    // Create an empty array to store the beats
    $beatpack = array();
    
    // Loop through the result and populate the beatpack array
    while ($row = mysqli_fetch_assoc($result)) {
        $beatpack[] = $row;
    }
    
    // Convert the beatpack array to JSON
    $beatpackJson = json_encode($beatpack);
    
    // Return the JSON response
    header('Content-Type: application/json');
    echo $beatpackJson;
}
?>