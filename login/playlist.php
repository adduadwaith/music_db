<?php
session_start();
include("connection.php");
include("functions.php");

// Check if the user is logged in
$user_data = check_login($conn);
if (!$user_data) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $user_data['id']; // Get the logged-in user ID from session
    $playlist_name = mysqli_real_escape_string($conn, $_POST['playlist_name']);
    $songs = $_POST['songs']; // Array of selected song IDs

    // Insert new playlist into the database
    $query = "INSERT INTO playlists (user_id, name) VALUES ('$user_id', '$playlist_name')";
    if (mysqli_query($conn, $query)) {
        $playlist_id = mysqli_insert_id($conn); // Get the ID of the newly created playlist

        // Insert each selected song into the playlist_songs table
        if (is_array($songs)) { // Make sure songs is an array
            foreach ($songs as $song_id) {
                $song_id = mysqli_real_escape_string($conn, $song_id); // Escaping for safety
                $song_query = "INSERT INTO playlist_songs (playlist_id, song_id) VALUES ('$playlist_id', '$song_id')";
                mysqli_query($conn, $song_query);
            }
        }
        echo "Playlist created successfully!";
    } else {
        echo "Error creating playlist: " . mysqli_error($conn);
    }
}
?>

