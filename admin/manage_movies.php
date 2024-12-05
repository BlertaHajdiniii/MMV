<?php
include '../includes/header.php';
include '../includes/db.php';
session_start();

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

// Handle adding a new movie
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_movie'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $genre = $_POST['genre'];
    $language = $_POST['language'];
    $duration = $_POST['duration'];
    $release_date = $_POST['release_date'];

    // Handle file upload
    $target_dir = "../assets/images/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO movies (title, description, genre, language, duration, release_date, image)
                VALUES ('$title', '$description', '$genre', '$language', $duration, '$release_date', '$image_name')";

        if ($conn->query($sql) === TRUE) {
            $success = "Movie added successfully!";
        } else {
            $error = "Error: " . $conn->error;
        }
    } else {
        $error = "Error uploading image.";
    }
}

// Handle deleting a movie
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM movies WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        $success = "Movie deleted successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Fetch all movies
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
?>

<div class="container my-5">
    <h1 class="text-center">Manage Movies</h1>

    <?php
    if (isset($success)) {
        echo "<div class='alert alert-success'>$success</div>";
    }
    if (isset($error)) {
        echo "<div class='alert alert-danger'>$error</div>";
    }
    ?>

    <!-- Add Movie Form -->
    <div class="card mb-5">
        <div class="card-body">
            <h3>Add New Movie</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <input type="text" name="genre" id="genre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="language" class="form-label">Language</label>
                    <input type="text" name="language" id="language" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Duration (minutes)</label>
                    <input type="number" name="duration" id="duration" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="release_date" class="form-label">Release Date</label>
                    <input type="date" name="release_date" id="release_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" id="image" class="form-control" required>
                </div>
                <button type="submit" name="add_movie" class="btn btn-primary">Add Movie</button>
            </form>
        </div>
    </div>

    <!-- Movies List -->
    <h3>Existing Movies</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Genre</th>
                <th>Language</th>
                <th>Duration</th>
                <th>Release Date</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($movie = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$movie['id']}</td>
                        <td>{$movie['title']}</td>
                        <td>{$movie['genre']}</td>
                        <td>{$movie['language']}</td>
                        <td>{$movie['duration']} minutes</td>
                        <td>{$movie['release_date']}</td>
                        <td><img src='../assets/images/{$movie['image']}' alt='{$movie['title']}' width='80'></td>
                        <td>
                            <a href='manage_movies.php?delete_id={$movie['id']}' class='btn btn-danger btn-sm'>Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>No movies found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include '../includes/footer.php';
?>
