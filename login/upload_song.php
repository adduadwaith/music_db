<?php include 'connection.php'; ?>
<form action="upload_song.php" method="POST" enctype="multipart/form-data">
    <label for="artist_id">Artist ID:</label>
    <input type="text" name="artist_id" required><br>
    
    <label for="title">Song Title:</label>
    <input type="text" name="title" required><br>
    
    <label for="genre">Genre:</label>
    <input type="text" name="genre" required><br>
    
    <label for="file">Choose MP3 File:</label>
    <input type="file" name="file" accept="audio/mp3" required><br><br>
    
    <input type="submit" name="upload" value="Upload Song">
</form>

<?php
if (isset($_POST['upload'])) {
    $artist_id = $_POST['artist_id']; 
    $title = $_POST['title']; 
    $genre = $_POST['genre']; 

    // Use a relative path for uploads (ensure this is accessible via the web)
    $targetDir = "uploads/songs/"; // This is now a relative path
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    // Check if the uploads/songs/ directory exists, if not, create it
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true); 
    }

    // Check if file is a valid MP3 file
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    if ($fileType == 'mp3') {
        // Check if there was an error during the file upload
        if ($_FILES["file"]["error"] === UPLOAD_ERR_OK) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                // Store the relative path in the database
                $query = "INSERT INTO songs (artist_id, title, genre, file_path) 
                          VALUES ('$artist_id', '$title', '$genre', '$targetFilePath')";
                if (mysqli_query($conn, $query)) {
                    echo "Song uploaded and stored in the database!";
                } else {
                    echo "Database error: " . mysqli_error($conn);
                }
            } else {
                echo "Failed to move the uploaded file.";
            }
        } else {
            echo "File upload error. Code: " . $_FILES["file"]["error"];
        }
    } else {
        echo "Only MP3 files are allowed.";
    }
}

?>
