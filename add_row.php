<?php
$id = $_POST['id'];
$name = $_POST['name'];
$artist = $_POST['artist'];
$src = $_POST['src'];
$thumbnail = $_POST['thumbnail'];

$conn = new mysqli('localhost', 'root', '', 'test');
if ($conn->connect_error) {
  echo "$conn->connect_error";
  die("Connection Failed: " . $conn->connect_error);
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['name'], $_POST['artist'], $_POST['src'], $_POST['thumbnail'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $artist = $_POST['artist'];
        $src = $_POST['src'];
        $thumbnail = $_POST['thumbnail'];

        $sql = "INSERT INTO liked_songs (id, name, artist, src, thumbnail) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('issss', $id, $name, $artist, $src, $thumbnail); // Use the correct data types 'issss' for id, name, artist, src, and thumbnail

        if ($stmt->execute()) {
            echo "Song added to liked_songs table";
        } else {
            echo "Error adding song to liked_songs table: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
