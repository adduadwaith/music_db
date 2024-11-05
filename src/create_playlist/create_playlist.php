<?php
session_start();
include("../connection.php");
include("../functions.php");

// Check if the user is logged in
$user_data = check_login($conn);
$user_id = $_COOKIE['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $playlist_name = $_GET['playlist-name'];
    // Insert new playlist into the database
    $query = "INSERT INTO playlists (user_id, name) VALUES ('$user_id', '$playlist_name')";
    if (mysqli_query($conn, $query)) {
        $playlist_id = mysqli_insert_id($conn); // Get the ID of the newly created playlist

        echo "Playlist created successfully!";
    } else {
        echo "Error creating playlist: " . mysqli_error($conn);
    }
}
?>

