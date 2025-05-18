<?php
session_start(); // Start a new or resume existing session for user authentication
require_once 'config.php'; // Load database connection constants (DBCONNSTRING, DBUSER, DBPASS)

$error = ""; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] === "POST") { // Check if the form was submitted
  $username = $_POST['username'] ?? ''; // Retrieve submitted username (or empty string)
  $password = $_POST['password'] ?? ''; // Retrieve submitted password (or empty string)

  try {
    // Create a new PDO instance for database interaction
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception mode on errors

    // Prepare and execute query to fetch admin user by username
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the user record as an associative array

    // Verify password hash and set session variable on success
    if ($user && password_verify($password, $user['password_hash'])) {
      $_SESSION['admin_logged_in'] = true; // Mark user as logged in
      header("Location: dashboard.php");   // Redirect to the dashboard page
      exit;
    } else {
      $error = "Invalid username or password."; // Prepare error message for invalid credentials
    }
  } catch (PDOException $e) {
    // Handle any database errors
    $error = "Database error: " . $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login - PetAdopt</title>
  <!-- Ensure proper scaling on mobile devices -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS for styling -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom stylesheet -->
  <link href="css/style.css" rel="stylesheet">
</head>

<body>

  <!-- Include the site-wide navigation bar -->
  <?php include 'nav.php'; ?>

  <header class="py-0" style="background-color: #e0f2f1;">
    <div class="container text-center">
      <h1 class="display-5">Administrator Login</h1>
    </div>
  </header>

  <!-- Main content container, centered and constrained in width -->
  <main class="container my-5" style="max-width: 500px;">

    <!-- Login form -->
    <form method="POST" action="">
      <!-- Username input field -->
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" required>
      </div>

      <!-- Password input field -->
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>

      <!-- Display error message if login fails -->
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <!-- Submit button -->
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
  </main>

  <!-- Footer with dynamic current year -->
  <footer class="bg-light text-center py-3 mt-5">
    <p class="mb-0">&copy; <?= date('Y') ?> PetAdopt. All rights reserved.</p>
  </footer>

  <!-- Bootstrap JavaScript bundle (includes Popper for dropdowns, tooltips, etc.) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>