<?php
// Check if the 'url' parameter is provided in the GET request
if (isset($_GET['url'])) {
    $url = htmlspecialchars($_GET['url']); // Sanitize the input to prevent XSS attacks
} else {
    // Default to an empty string or set a default audio file path
    $url = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoplay Audio</title>
</head>
<body>

<?php if ($url): ?>
    <audio controls autoplay>
        <source src="<?php echo $url; ?>" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
<?php else: ?>
    <p>No audio file specified.</p>
<?php endif; ?>

</body>
</html>
