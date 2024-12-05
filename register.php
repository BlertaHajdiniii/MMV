<?php
include 'includes/header.php';
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'user')";
    if ($conn->query($sql) === TRUE) {
        $success = "Registration successful! You can now log in.";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4">
                <h3 class="text-center">Register</h3>
                <?php
                if (!empty($success)) echo '<div class="alert alert-success">' . $success . '</div>';
                if (!empty($error)) echo '<div class="alert alert-danger">' . $error . '</div>';
                ?>
                <form id="register-form" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        <small class="text-danger" id="name-error"></small>
                    </div>
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
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                        <input type="password" id="confirm-password" class="form-control" required>
                        <small class="text-danger" id="confirm-password-error"></small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript validation
document.getElementById('register-form').addEventListener('submit', function (e) {
    let isValid = true;
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const confirmPassword = document.getElementById('confirm-password').value.trim();

    // Clear errors
    document.getElementById('name-error').innerText = '';
    document.getElementById('email-error').innerText = '';
    document.getElementById('password-error').innerText = '';
    document.getElementById('confirm-password-error').innerText = '';

    if (!name) {
        document.getElementById('name-error').innerText = 'Name is required.';
        isValid = false;
    }
    if (!email) {
        document.getElementById('email-error').innerText = 'Email is required.';
        isValid = false;
    }
    if (!password) {
        document.getElementById('password-error').innerText = 'Password is required.';
        isValid = false;
    }
    if (password !== confirmPassword) {
        document.getElementById('confirm-password-error').innerText = 'Passwords do not match.';
        isValid = false;
    }

    if (!isValid) e.preventDefault(); // Prevent form submission if invalid
});
</script>

<?php include 'includes/footer.php'; ?>
