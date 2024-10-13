document.querySelector("form").addEventListener("submit", function(event) {
    const selectedSongs = document.querySelector("select[name='songs[]']").selectedOptions;
    if (selectedSongs.length === 0) {
        event.preventDefault();
        alert("Please select at least one song for the playlist.");
    }
});

// Optional: Show a success message on successful playlist creation
// This can be implemented based on your PHP response handling
