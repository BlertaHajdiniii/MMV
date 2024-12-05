<?php
include 'includes/header.php';
include 'includes/db.php';

$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
?>

<div class="container my-5">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Welcome to the Movie Booking System</h1>
            <p class="lead">Book your favorite movies and enjoy the show!</p>
        </div>
    </div>
    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while ($movie = $result->fetch_assoc()) {
                echo '
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="assets/images/' . $movie['image'] . '" class="card-img-top" alt="' . $movie['title'] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . $movie['title'] . '</h5>
                            <p class="card-text">' . $movie['description'] . '</p>
                            <p><strong>Genre:</strong> ' . $movie['genre'] . '</p>
                            <p><strong>Language:</strong> ' . $movie['language'] . '</p>
                            <a href="user/book_movie.php?movie_id=' . $movie['id'] . '" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="col-12"><p class="text-muted">No movies available right now. Check back later!</p></div>';
        }
        ?>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
