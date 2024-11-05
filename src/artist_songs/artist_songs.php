<?php
session_start();
include("../connection.php");

// Get the artist_id from the URL
$artist_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$artist_id) {
    echo "No artist selected.";
    exit();
}

// Fetch artist details
$artist_query = "SELECT * FROM artists WHERE id = '$artist_id'";
$artist_result = mysqli_query($conn, $artist_query);
if (mysqli_num_rows($artist_result) > 0) {
    $artist = mysqli_fetch_assoc($artist_result);
    $artist_name = $artist['name'];
    $artist_genre = $artist['genre'];
} else {
    echo "Artist not found.";
    exit();
}

// Fetch songs by this artist
$song_query = "SELECT * FROM songs WHERE artist_id = '$artist_id'";
$song_result = mysqli_query($conn, $song_query);

if (!$song_result) {
    echo "Error fetching songs: " . mysqli_error($conn);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Songs by <?php echo $artist_name; ?></title>
    <link rel="stylesheet" href="artist_songs.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h1>Songs by <?php echo $artist_name; ?> (Genre: <?php echo $artist_genre; ?>)</h1>

        <?php
        if (mysqli_num_rows($song_result) > 0) {
            echo "<ul>";
            while ($song_row = mysqli_fetch_assoc($song_result)) {
                $song_title = $song_row['title'];
                $song_file = $song_row['file_path']; // Path to the song file
                $song_id = $song_row['id'];

                echo "<li>";
                echo "$song_title";
                echo "<a href='../now_playing/now_playing.php?url=$song_file&id=$song_id' target=\"_blank\">play</a>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No songs found for this artist.</p>";
        }
        ?>
    </div>
</body>
</html>
