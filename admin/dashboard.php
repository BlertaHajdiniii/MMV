<?php
include '../includes/header.php';
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}
?>

<div class="container my-5">
    <h1 class="text-center">Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <a href="manage_movies.php" class="btn btn-primary w-100 mb-3">Manage Movies</a>
        </div>
        <div class="col-md-4">
            <a href="manage_users.php" class="btn btn-secondary w-100 mb-3">Manage Users</a>
        </div>
        <div class="col-md-4">
            <a href="manage_bookings.php" class="btn btn-success w-100 mb-3">Manage Bookings</a>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>
