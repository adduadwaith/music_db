<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($conn);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sangita Music App</title>
    <link rel="stylesheet" href="styles_h.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <h1 class="logo">SANGITA</h1>
            <div class="auth-buttons">
                <a class="signup-btn">Sign up</a>
                <button class="login-btn" onclick="window.location.href='./index1.php';">Log in</button>

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
                
                <a href="./create_playlist.php"><img src="./images/plus.png" class="plus" alt="search icon"></a>
            </div>
            <?php
                    // Fetch user's playlists
                    $user_id = $user_data['id']; // Make sure 'id' matches the column name in the users table
                    $query = "SELECT * FROM playlists WHERE user_id = '$user_id'";
                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        echo "Error fetching playlists: " . mysqli_error($conn);
                        exit();
                    }

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
            <img src="./images/book.png" class="book">
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
                    echo "<a href='artist_songs.php?id=$artist_id'><img src='$artist_image' alt='$artist_name'></a>";
                    echo "<div>$artist_name</div>";
                    echo "</div>";
                }
            ?>

            <div><a href=""><img src="./images/vidya.png" class="vid"></a></div>
            <div><a href=""><img src="./images/chitra.png" class="ks"></a></div>
            <div><a href=""><img src="./images/ar.png" class="ar"></a></div>
            <div><a href=""><img src="./images/sreya.png" class="sr"></a></div>
            <div><a href=""><img src="./images/ani.png" class="an"></a></div>
            </div>
        </div>
        <div class="track"> 
            <h2 class="t">Tracks</h2>
            <div class="but">
            <div class="bu1"><div class="mel">Melody</div></div>
            <div class="bu2"><div class="rap">Rap</div></div>
            <div class="bu3"><div class="hh">H-H</div></div>
            <div class="bu4"><div class="cl">Classic</div></div>
            </div>
        </div>   
    </div>
</body>
</html>

