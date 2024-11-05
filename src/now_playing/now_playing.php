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
</head>
<body>

<?php if ($url): ?>
    <h2>Now Playing</h2>
    <audio controls autoplay>
        <source src="<?php echo $url; ?>" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
<?php else: ?>
    <p>No audio file specified.</p>
<?php endif; ?>

<!-- Link to Add to Playlist Page -->
<p><a href="add_to_playlist.php?url=<?php echo $url; ?>", target="_blank">Go to Add to Playlist</a></p>

<!-- Display Playlist -->
<h3>Your Playlists</h3>
<div class="container">
        <?php
        include("../connection.php");
        include("../functions.php");

        $user_data = check_login($conn);

        $user_id = $_COOKIE['user_id']; // Retrieve the cookie value
        // Fetch user's playlists
        //$user_id = $user_data['id']; // Make sure 'id' matches the column name in the users table
        $query = "SELECT * FROM playlists WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "Error fetching playlists: " . mysqli_error($conn);
            exit();
        }
        
        if (mysqli_num_rows($result) > 0) {
            // Loop through each playlist
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div>";
                // Create a button for each playlist as a link
                echo "<a href='add_to_playlist.php?song_id=$song_id&playlist_id={$row['id']}'>Add to {$row['name']}</a>";
                echo "</div>";
            }
        }
         else {
            echo "<p>You have no playlists yet. Create one!</p>";
        }
        ?>
    </div>

</body>
</html>
