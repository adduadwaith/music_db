<?php
session_start();
include("../connection.php");
include("../functions.php");

$user_data = check_login($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sangita - Music Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">SANGITA</div>
            <nav class="main-nav">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="artist_inser.html">Artist</a></li>
                    <li><a href="#">Music</a></li>
                    <li><a href="create_playlist.php">PlayList</a></li>
                    <li><a href="view_playlist.php">view playlist</a></li>
                    <li><a href="#">Download</a></li>
                    <li><a href="#">Privacy</a></li>
                    <li><a href="#">Terms</a></li>
                    <li> <a href="../logout/logout.php">logout</a></li>
                </ul>
            </nav>
            <div class="auth-buttons">
                <a href="index.php" class="login">Log in</a>
                <a href="index.php" class="signup">Sign up</a>
            </div>
            <div class="hamburger-menu" onclick="openNav()">
                &#9776;
            </div>
        </div>
    </header>

    <!-- Sidebar for mobile view (now from right to left) -->
    <div id="sidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <a href="#">Home</a>
        <a href="artist_inser.html">Artist</a>
        <a href="#">Music</a>
        <a href="create_playlist.php">PlayList</a>
        <a href="#">Help</a>
        <a href="#">Download</a>
        <a href="#">Privacy</a>
        <a href="#">Terms</a>
        <a href="../login/index.php" class="login">Log in</a>
        <a href="../login/index.php" class="signup">Sign up</a>
    </div>
    <section class="popular-artists">
    <h2>Popular Artists</h2>
    <div class="artist-scroll">
        <?php
        // Fetch popular artists from the database
        $query = "SELECT * FROM artists"; // Make sure your table name and fields are correct
        $result = mysqli_query($conn, $query);

        // Loop through each artist and display their image and name
        while ($row = mysqli_fetch_assoc($result)) {
            $artist_id = $row['id'];
            $artist_name = $row['name'];
            $artist_image = $row['image_path']; // Path to the artist's image
            echo "<div class='artist'>";
            echo "<a href='artist_songs.php?id=$artist_id'><img src='$artist_image' alt='$artist_name'></a>";
            echo "<p>$artist_name</p>";
            echo "</div>";
        }
        ?>
    </div>
</section>

<section class="track-section">
    <h2>Tracks</h2>
    <div class="tracks">
        <div class="track" onclick="location.href='upload_song.php'">Melody</div>
        <div class="track" onclick="location.href='melody.php'">Rays</div>
        <div class="track" onclick="location.href='#hh'">HH</div>
        <div class="track" onclick="location.href='#classic'">Classic</div>
    </div>
</section>



    <script src="script1.js"></script>
</body>
</html>
