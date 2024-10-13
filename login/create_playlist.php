<?php
session_start();
include("connection.php");
include("functions.php");

// Check if the user is logged in
$user_data = check_login($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Playlist</title>
    <link rel="stylesheet" href="playlist_style.css"> <!-- Include your CSS for styling -->
</head>
<body>
    <div class="container">
        <h1>Create a Playlist</h1>
        <form action="playlist.php" method="POST">
            <input type="hidden" name="user_id" value="<?php echo $user_data['id']; ?>"> <!-- Ensure 'id' is the correct key -->
            
            <label for="playlist_name">Playlist Name:</label>
            <input type="text" name="playlist_name" required placeholder="Enter playlist name">

            <label for="songs">Select Songs:</label>
            <select name="songs[]" multiple required> <!-- 'multiple' attribute allows multiple selections -->
                <?php
                // Fetch songs from the database
                $query = "SELECT id, title FROM songs"; // Assuming 'id' and 'title' are correct columns
                $result = mysqli_query($conn, $query);
                
                // Check if any songs are returned
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id']}'>{$row['title']}</option>";
                    }
                } else {
                    echo "<option disabled>No songs available</option>"; // If no songs are found
                }
                ?>
            </select>

            <button type="submit">Create Playlist</button>
        </form>
    </div>
    
    <script src="playlist_script.js"></script>
</body>
</html>