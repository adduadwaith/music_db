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
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        session_start();
        include("connection.php");
        include("functions.php");

        $user_data = check_login($conn);


        // Check if the form is submitted
        if (isset($_GET['search'])) {
            $searchTerm = $conn->real_escape_string($_GET['search']);
            
            // Prepare the SQL statement
            $sql = "SELECT * FROM songs WHERE name LIKE '%$searchTerm%'";
            $result = $conn->query($sql);

            // Check if any results were returned
            if ($result->num_rows > 0) {
                // Output data of each row
                echo "<h2>Search Results for '$searchTerm':</h2>";
                while ($row = $result->fetch_assoc()) {
                    echo "<div>";
                    echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                    echo "<p>Artist: " . htmlspecialchars($row['artist']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<h2>No results found for '$searchTerm'.</h2>";
            }
        }

        $conn->close();
        ?>
</body>
</html>
