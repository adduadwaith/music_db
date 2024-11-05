<?php
session_start();
include("../connection.php");
include("../functions.php");

check_login($conn);

$username = $_COOKIE['user_name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sangita Music App</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <h1 class="logo">SANGITA</h1>
            <div class="auth-buttons">
                
                <a class="signup-btn"><?php if($username){echo $username;}else{echo 'Sign up';}?></a>
            
                <a href="../logout/logout.php"><button class="login-btn">Log out</button></a>

            </div>
        </header>
        <div class="sidebar">
            <div class="home-container">
                <a href="./index.html"><img src="./images/home.png" class="img" alt="Home Icon"></a>
                <h2 class="ho"><a href="./index.html" class="nod">HOME</a></h2>
            </div>
            <div class="home-container2">
                <a href=""><img src="./images/search.png" class="img2"></a>
                <h2 class="se"><a href="./search.php" class="nod2"> SEARCH</a></h2>
            </div>
        </div>
        <div class="sidebar2">
            
            <div class="home3">
                <img src="./images/library.png" class="sei" alt="search icon">
                <h2 class="lib">MY LIBRARY</h2>
                
                <a id="show-form-link" href="#"><img src="./images/plus.png" class="plus" alt="search icon"></a>

                <!-- Playlist form -->
    <div id="playlist-form">
        <h2>New Playlist</h2>
        <form id="new-playlist-form" action='../create_playlist/create_playlist.php' method='get'>
            <label for="playlist-name">Playlist Name:</label>
            <input type="text" id="playlist-name" name="playlist-name" required>
            <button type="submit">Submit</button>
        </form>
    </div>
    <style>
        /* Initially hide the form */
        #playlist-form {
            display: none; /* Hidden by default */
            margin-top: 20px;
        }
    </style>
    <script>
        // JavaScript to toggle the form visibility
        document.getElementById('show-form-link').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default anchor behavior
            const form = document.getElementById('playlist-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none'; // Toggle form visibility
        });
    </script>
                
            </div>
            <div class="playlist_container">
            <?php

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
<?php
if (mysqli_num_rows($result) > 0) {
    // Loop through each playlist and display it
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>";
        //echo "<div class='playlist'>";
        echo "{$row['name']}"; // Display playlist name
        echo "<a href='../view_playlist/view_songs_in_playlist.php?playlist_id={$row['id']}'>View playlist</a>"; // Display playlist ID (optional)
        //echo "</div>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>You have no playlists yet. Create one!</p>";
}
?>
</div>
            
        </div>
        <div class="art">
            <h2 class="a">Artist</h2>
            <div class="g">
            <?php
                // Fetch popular artists from the database
                $query = "SELECT * FROM artists"; // Make sure your table name and fields are correct
                $result = mysqli_query($conn, $query);

                // Loop through each artist and display their image and name
                while ($row = mysqli_fetch_assoc($result)) {
                    $artist_id = $row['id'];
                    $artist_name = $row['name'];
                    $artist_image = $row['image_path']; // Path to the artist's image
                    echo "<div>";
                    echo "<a href='../artist_songs/artist_songs.php?id=$artist_id'><img src='$artist_image' alt='$artist_name'></a>";
                    echo "<div>$artist_name</div>";
                    echo "</div>";
                }
            ?>

            </div>
        </div>
        <div class="track"> 
            <h2 class="t">Tracks</h2>
            <div class="but">
            <div class="bu1"><a href='../view_playlist/view_songs_in_playlist.php?playlist_id=0'><div class="mel">Melody</div></a></div>
            <div class="bu2"><a href='../view_playlist/view_songs_in_playlist.php?playlist_id=1'><div class="rap">Rap</div></a></div>
            <div class="bu3"><a href='../view_playlist/view_songs_in_playlist.php?playlist_id=2'><div class="hh">H-H</div></a></div>
            <div class="bu4"><a href='../view_playlist/view_songs_in_playlist.php?playlist_id=3'><div class="cl">Classic</div></div>
            </div>
        </div>   
    </div>
</body>
</html>

