<?php
// Include common files
include '../includes/header.php';
include '../includes/db.php';
session_start();

// Ensure the user is logged in and is a regular user
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header('Location: ../login.php'); // Redirect to login if not authorized
    exit;
}

// Fetch user-specific bookings
$user_id = $_SESSION['user_id'];
$sql = "SELECT b.id, m.title, b.show_date, b.show_time, b.status 
        FROM bookings b 
        INNER JOIN movies m ON b.movie_id = m.id 
        WHERE b.user_id = $user_id";
$result = $conn->query($sql);
?>

<div class="container my-5">
    <h1 class="text-center">User Dashboard</h1>
    
    <h2 class="mt-4">My Bookings</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Movie</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['show_date']}</td>
                        <td>{$row['show_time']}</td>
                        <td>{$row['status']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No bookings found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include '../includes/footer.php';
?>
