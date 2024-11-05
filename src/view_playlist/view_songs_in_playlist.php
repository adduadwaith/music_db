<?php
session_start();
include("../connection.php");
include("../functions.php");

// Check if the user is logged in
$user_data = check_login($conn);

// Check if the playlist_id is provided in the GET request
if (isset($_GET['playlist_id'])) {
    $playlist_id = intval($_GET['playlist_id']); // Ensure playlist_id is treated as an integer

    // Fetch songs for the given playlist_id
    $query = "SELECT songs.* FROM songs 
              INNER JOIN playlist_songs ON songs.id = playlist_songs.song_id 
              WHERE playlist_songs.playlist_id = '$playlist_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error fetching songs: " . mysqli_error($conn);
        exit();
    }

    // Display the songs
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Songs in Playlist</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            .song {
                margin: 10px 0;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            .song h2 {
                margin: 0;
            }
        </style>
    </head>
    <body>

    <h1>Songs in Playlist ID: <?php echo $playlist_id; ?></h1>
    <div class="songs-container">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='song'>";
                echo "{$row['title']}<a href=../now_playing/now_playing.php?url={$row['file_path']}&id={$row['id']} target=\"_blank\">hello</a>"; // Display song title
                //echo "<a href='../now_playing/now_playing.php?url={$row['file_path']}&id={$row['id']} target=\"_blank\"></a>";; // Display artist name (if available)
                echo "</div>";
            }
        } else {
            echo "<p>No songs found in this playlist.</p>";
        }
        ?>
    </div>

    </body>
    </html>
    <?php
} else {
    echo "Playlist ID is not specified.";
}
$conn->close();
?>
