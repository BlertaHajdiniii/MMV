<?php
include '../includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $movie_id = $_POST['movie_id'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];

    $sql = "INSERT INTO bookings (user_id, movie_id, show_date, show_time) 
            VALUES ($user_id, $movie_id, '$show_date', '$show_time')";

    if ($conn->query($sql) === TRUE) {
        echo "Booking request submitted!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
