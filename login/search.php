<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Artist</title>
</head>
<body>
    <h2>Search for an Artist</h2>
    <form method="POST" action="">
        <label for="name">Artist Name:</label>
        <input type="text" id="name" name="name" required>
        <input type="submit" value="Search">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        session_start();
        include("connection.php");
        include("functions.php");

        $user_data = check_login($conn);


        // Get the name from form input and sanitize it
        $artistName = $conn->real_escape_string($_POST["name"]);

        // SQL query to search for the artist by name
        $sql = "SELECT * FROM artists WHERE name LIKE '%$artistName%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display results if any matches are found
            echo "<h3>Search Results:</h3>";
            echo "<table border='1'><tr><th>Artist ID</th><th>Name</th><th>Genre</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["genre"] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No artists found with that name.</p>";
        }

        // Close the connection
        $conn->close();
    }
    ?>
</body>
</html>
