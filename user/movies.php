<?php
include '../includes/db.php';
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<div>";
    echo "<h3>" . $row['title'] . "</h3>";
    echo "<p>" . $row['description'] . "</p>";
    echo "<p>Genre: " . $row['genre'] . "</p>";
    echo "</div>";
}
?>
