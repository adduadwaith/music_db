<?php
session_start();
include("../connection.php");
include("../functions.php");

// Check if the user is logged in
$user_data = check_login($conn);

// Check if the required parameters are present
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['song_id']) && isset($_GET['playlist_id'])) {
        $song_id = intval($_GET['song_id']); // Ensure song_id is treated as an integer
        $playlist_id = intval($_GET['playlist_id']); // Ensure playlist_id is treated as an integer

        // Insert the song into the playlist_songs table
        $query = "INSERT INTO playlist_songs (playlist_id, song_id) VALUES ('$playlist_id', '$song_id')";
        
        if (mysqli_query($conn, $query)) {
            echo "Song added to the playlist successfully!";
        } else {
            echo "Error adding song to playlist: " . mysqli_error($conn);
        }
    } else {
        echo "Missing required parameters.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
