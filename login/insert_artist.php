<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $artist_name = mysqli_real_escape_string($conn, $_POST['artist_name']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    
    // Handle the uploaded image
    if (isset($_FILES['artist_image']) && $_FILES['artist_image']['error'] === UPLOAD_ERR_OK) {
        // Define the target directory for the image upload
        $target_dir = "uploads2/artists/";
        // Ensure the directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // Get file info
        $file_name = basename($_FILES["artist_image"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allowed file types (images only)
        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        if (in_array($file_type, $allowed_types)) {
            // Move uploaded file to the target directory
            if (move_uploaded_file($_FILES["artist_image"]["tmp_name"], $target_file)) {
                // Insert artist data into the database (in the specified order)
                $query = "INSERT INTO artists (name, image_path, genre) VALUES ('$artist_name', '$target_file', '$genre')";
                if (mysqli_query($conn, $query)) {
                    echo "Artist inserted successfully!";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Error uploading the file.";
            }
        } else {
            echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    } else {
        echo "No image uploaded or an error occurred during the upload.";
    }
}
?>
