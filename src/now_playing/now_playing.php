<?php
session_start();

// Check if the 'url' parameter is provided in the GET request
if (isset($_GET['url'])) {
    $url = htmlspecialchars($_GET['url']); // Sanitize the input to prevent XSS attacks
    $song_id = $_GET['id'];
} else {
    $url = ''; // Default to an empty string if no URL is provided
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Now Playing</title>
    <style>
        /* Gradient Background Animation */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(45deg, #1b1b2f, #2d2d44, #3a3a5f, #1b1b2f);
            background-size: 400% 400%;
            animation: gradientAnimation 10s ease infinite;
            color: #e0e0e0;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            text-align: center;
            background-color: rgba(30, 30, 30, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            max-width: 500px;
            width: 90%;
        }

        h2 {
            color: #d1b3ff;
            font-size: 1.6em;
            margin-bottom: 20px;
        }

        audio {
            width: 100%;
            margin: 20px 0;
            background-color: #2e2e2e;
            border-radius: 5px;
        }

        /* Playlist Link Styling */
        .playlist-link {
            display: block;
            margin: 15px 0;
            color: #ffffff;
            background-color: #4a4a7d;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .playlist-link:hover {
            background-color: #373764;
        }

        /* Playlist Container Styling */
        .playlists {
            margin-top: 20px;
            text-align: left;
        }

        .playlist-item {
            background-color: #33334d;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            text-align: center;
            transition: transform 0.3s ease, background 0.3s;
        }

        .playlist-item:hover {
            transform: scale(1.05);
            background-color: #444466;
        }

        .playlist-item a {
            text-decoration: none;
            color: #d1b3ff;
            font-weight: bold;
        }

        .playlist-item a:hover {
            color: #b39ddb;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if ($url): ?>
        <h2>Now Playing</h2>
        <audio controls autoplay>
            <source src="<?php echo $url; ?>" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    <?php else: ?>
        <p>No audio file specified.</p>
    <?php endif; ?>

    <!-- Display Playlists -->
    <h3 style="color: #d1b3ff;">Click on your playlists to add this song</h3>
    <div class="playlists">
        <?php
        include("../connection.php");
        include("../functions.php");

        $user_data = check_login($conn);
        $user_id = $_COOKIE['user_id']; // Retrieve the cookie value
        
        // Fetch user's playlists
        $query = "SELECT * FROM playlists WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "Error fetching playlists: " . mysqli_error($conn);
            exit();
        }
        
        if (mysqli_num_rows($result) > 0) {
            // Loop through each playlist
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='playlist-item'>";
                echo "<a href='add_to_playlist.php?song_id=$song_id&playlist_id={$row['id']}' target='_blank'>Add to {$row['name']}</a>";
                echo "</div>";
            }
        } else {
            echo "<p>You have no playlists yet. Create one!</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
