<?php
include '../includes/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $genre = $_POST['genre'];
    $language = $_POST['language'];
    $duration = $_POST['duration'];
    $release_date = $_POST['release_date'];

    $sql = "INSERT INTO movies (title, description, genre, language, duration, release_date) 
            VALUES ('$title', '$description', '$genre', '$language', $duration, '$release_date')";

    if ($conn->query($sql) === TRUE) {
        echo "Movie added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<form method="POST">
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="text" name="genre" placeholder="Genre">
    <input type="text" name="language" placeholder="Language">
    <input type="number" name="duration" placeholder="Duration (minutes)">
    <input type="date" name="release_date">
    <button type="submit">Add Movie</button>
</form>
