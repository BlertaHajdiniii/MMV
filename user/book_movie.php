<?php
include '../includes/header.php';
include '../includes/db.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header('Location: ../login.php');
    exit;
}

// Get the movie ID from the query string
if (!isset($_GET['movie_id'])) {
    echo "<div class='container'><p class='alert alert-danger'>Invalid movie selection.</p></div>";
    include '../includes/footer.php';
    exit;
}

$movie_id = intval($_GET['movie_id']);
$sql = "SELECT * FROM movies WHERE id = $movie_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<div class='container'><p class='alert alert-danger'>Movie not found.</p></div>";
    include '../includes/footer.php';
    exit;
}

$movie = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];

    $sql = "INSERT INTO bookings (user_id, movie_id, show_date, show_time, status) 
            VALUES ($user_id, $movie_id, '$show_date', '$show_time', 'pending')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='container'><p class='alert alert-success'>Booking successful! Your booking is pending approval.</p></div>";
    } else {
        echo "<div class='container'><p class='alert alert-danger'>Error: " . $conn->error . "</p></div>";
    }
}
?>

<div class="container my-5">
    <h1 class="text-center">Book Movie</h1>
    <div class="card">
        <div class="card-body">
            <h3><?php echo $movie['title']; ?></h3>
            <p><?php echo $movie['description']; ?></p>
            <p><strong>Genre:</strong> <?php echo $movie['genre']; ?></p>
            <p><strong>Language:</strong> <?php echo $movie['language']; ?></p>
            <p><strong>Duration:</strong> <?php echo $movie['duration']; ?> minutes</p>
        </div>
    </div>

    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label for="show_date" class="form-label">Show Date</label>
            <input type="date" name="show_date" id="show_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="show_time" class="form-label">Show Time</label>
            <input type="time" name="show_time" id="show_time" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Confirm Booking</button>
    </form>
</div>

<?php
include '../includes/footer.php';
?>
