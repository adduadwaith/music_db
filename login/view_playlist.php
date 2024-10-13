<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($conn);
if (!$user_data) {
    header("Location: login.php");
    exit();
}

// Fetch user's playlists
$user_id = $user_data['id']; // Make sure 'id' matches the column name in the users table
$query = "SELECT * FROM playlists WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error fetching playlists: " . mysqli_error($conn);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Playlists</title>
    <link rel="stylesheet" href="view_playlist.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h1>Your Playlists</h1>
        <?php
        if (mysqli_num_rows($result) > 0) {
            // Loop through each playlist
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='playlist'>";
                echo "<h2>{$row['name']}</h2>"; // Display playlist name

                // Fetch songs in the current playlist
                $playlist_id = $row['id']; // Assuming 'id' is the correct column in playlists table
                $song_query = "SELECT s.title, s.file_path FROM playlist_songs ps 
                               JOIN songs s ON ps.song_id = s.id 
                               WHERE ps.playlist_id = '$playlist_id'";
                $song_result = mysqli_query($conn, $song_query);

                if (!$song_result) {
                    echo "Error fetching songs: " . mysqli_error($conn);
                } elseif (mysqli_num_rows($song_result) > 0) {
                    echo "<ul>";
                    // Loop through each song in the playlist
                    while ($song_row = mysqli_fetch_assoc($song_result)) {
                        $song_title = $song_row['title'];
                        $song_path = $song_row['file_path']; // Path to the audio file
                        
                        echo "<li>{$song_title}</li>";
                        echo "<audio controls>";
                        echo "<source src='{$song_path}' type='audio/mpeg'>";
                        echo "Your browser does not support the audio element.";
                        echo "</audio>"; // Display HTML5 audio player for each song
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No songs in this playlist</p>"; // Message if no songs found
                }
                echo "</div>";
            }
        } else {
            echo "<p>You have no playlists yet. Create one!</p>";
        }
        ?>
    </div>
</body>
</html>
