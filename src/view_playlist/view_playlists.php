<?php
session_start();
include("../connection.php");
include("../functions.php");

// Check if the user is logged in
$user_data = check_login($conn);



$user_id = intval($_COOKIE['user_id']); // Ensure user_id is treated as an integer

// Fetch playlists for the given user_id
$query = "SELECT * FROM playlists WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error fetching playlists: " . mysqli_error($conn);
    exit();
}

// Display the playlists
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Playlists</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .playlist {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .playlist h2 {
            margin: 0;
        }
    </style>
</head>
<body>

<h1>Your Playlists</h1>
<div class="playlists-container">
    <?php
    if (mysqli_num_rows($result) > 0) {
        // Loop through each playlist and display it
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='playlist'>";
            echo "<h2>{$row['name']}</h2>"; // Display playlist name
            echo "<p><a href='view_songs_in_playlist.php?playlist_id={$row['id']}'>View playlist</a></p>"; // Display playlist ID (optional)
            echo "</div>";
        }
    } else {
        echo "<p>You have no playlists yet. Create one!</p>";
    }
    ?>
</div>

</body>
</html>
<?php

$conn->close();
?>
