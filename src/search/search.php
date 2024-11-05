<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Artist</title>
    <style>
        /* Overall body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: #e0e0e0; /* Light text color */
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Centering content */
            justify-content: center;
            height: 100vh; /* Full viewport height */
        }

        h2 {
            color: #d1b3ff; /* Light violet color for headings */
            margin-bottom: 20px; /* Spacing below the heading */
        }

        /* Styling for song results */
        .song {
            background-color: #1f1f1f; /* Slightly lighter background for song containers */
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s, transform 0.2s;
            width: 80%; /* Width of the song container */
        }

        .song:hover {
            background-color: #292929; /* Darker background on hover */
            transform: scale(1.02);
        }

        /* Styling for play link */
        .song a {
            color: #00bcd4; /* Teal color for links */
            text-decoration: none;
            font-weight: bold;
            border: 2px solid #00bcd4;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .song a:hover {
            background-color: #00bcd4; /* Teal background on hover */
            color: #ffffff; /* White text on hover */
        }
    </style>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        session_start();
        include("../connection.php");
        include("../functions.php");

        $user_data = check_login($conn);

        // Check if the form is submitted
        if (isset($_GET['search-term'])) {
            $searchTerm = $conn->real_escape_string($_GET['search-term']);
            
            // Prepare the SQL statement
            $sql = "SELECT * FROM songs WHERE title LIKE '%$searchTerm%'";
            $result = $conn->query($sql);

            // Check if any results were returned
            if ($result->num_rows > 0) {
                // Output data of each row
                echo "<h2>Search Results for '$searchTerm':</h2>";
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='song'>";
                    echo "{$row['title']}<a href='../now_playing/now_playing.php?url={$row['file_path']}&id={$row['id']}' target='_blank'>Play</a>";
                    echo "</div>";
                }
            } else {
                echo "<h2>No results found for '$searchTerm'.</h2>";
            }
        }

        $conn->close();
    }
    ?>
</body>
</html>
