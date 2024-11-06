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
    <title>Songs by <?php echo htmlspecialchars($artist_name); ?></title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a2e;
            color: #e0e0ff;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Container for the page */
        .container {
            max-width: 600px;
            background-color: #222;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h1 {
            color: #9b59b6; /* Violet-blue accent */
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        /* Styling for the song list */
        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background-color: #333;
            color: #e0e0ff;
            margin: 10px 0;
            padding: 15px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.3s ease, background 0.3s;
        }

        li:hover {
            background-color: #3a3a55;
            transform: scale(1.03);
        }

        /* Styling for the play link */
        .play-link {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
            border: 2px solid #3498db;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .play-link:hover {
            background-color: #3498db;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Songs by <?php echo htmlspecialchars($artist_name); ?></h1>

        <?php
        if (mysqli_num_rows($song_result) > 0) {
            echo "<ul>";
            while ($song_row = mysqli_fetch_assoc($song_result)) {
                $song_title = $song_row['title'];
                $song_file = $song_row['file_path']; // Path to the song file
                $song_id = $song_row['id'];

                echo "<li>";
                echo "<span>$song_title</span>";
                echo "<a href='../now_playing/now_playing.php?url=$song_file&id=$song_id' class='play-link' target='_blank'>Play</a>";
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
