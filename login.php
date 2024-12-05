<?php
include 'includes/header.php';
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            header('Location: ' . ($row['role'] == 'admin' ? 'admin/dashboard.php' : 'user/dashboard.php'));
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4">
                <h3 class="text-center">Login</h3>
                <?php if (!empty($error)) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
                <form id="login-form" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                        <small class="text-danger" id="email-error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        <small class="text-danger" id="password-error"></small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript validation
document.getElementById('login-form').addEventListener('submit', function (e) {
    let isValid = true;
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    // Clear errors
    document.getElementById('email-error').innerText = '';
    document.getElementById('password-error').innerText = '';

    if (!email) {
        document.getElementById('email-error').innerText = 'Email is required.';
        isValid = false;
    }
    if (!password) {
        document.getElementById('password-error').innerText = 'Password is required.';
        isValid = false;
    }

    if (!isValid) e.preventDefault(); // Prevent form submission if invalid
});
</script>

<?php include 'includes/footer.php'; ?>
