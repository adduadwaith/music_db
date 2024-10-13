<?php include 'connection.php'; ?>

<h2>Available Songs</h2>

<?php
$query = "SELECT title, file_path FROM songs where id IN (2,3)";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    // Make sure the file path is relative to your website's root
    $relativeFilePath = str_replace(__DIR__, '', $row['file_path']);
    echo "<div>{$row['title']}</div>";
    echo "<audio controls>
            <source src='$relativeFilePath' type='audio/mp3'>
            Your browser does not support the audio element.
          </audio><br>";
}
?>
