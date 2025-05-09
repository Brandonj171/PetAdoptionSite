<?php
require_once 'config.php'; // Include database connection configuration

$success = ""; // Initialize success message variable
$error = "";   // Initialize error message variable

// Handle form submission when the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and trim form input values, providing defaults if unset
    $name    = trim($_POST['name']    ?? '');
    $email   = trim($_POST['email']   ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate that all fields have values
    if ($name && $email && $message) {
        try {
            // Create a new PDO instance for database operations
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception mode

            // Prepare and execute insert statement to save the contact message
            $stmt = $pdo->prepare(
                "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)"
            );
            $stmt->execute([$name, $email, $message]);

            // Set success message on successful insert
            $success = "Message sent successfully!";
        } catch (PDOException $e) {
            // Handle any PDO exceptions by setting an error message
            $error = "Database error: " . $e->getMessage();
        }
    } else {
        // Set error message if any field is empty
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact Us - PetAdopt</title> <!-- Page title -->
    <!-- Include Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'nav.php'; ?> <!-- Include site navigation -->

    <div class="container py-5">
        <h2 class="mb-4 text-center">Contact Us</h2> <!-- Page heading -->

        <!-- Display success or error alert if set -->
        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Contact form -->
        <form method="POST" class="mx-auto" style="max-width: 600px;">
            <!-- Name field -->
            <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <!-- Email field -->
            <div class="mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <!-- Message field -->
            <div class="mb-3">
                <label for="message" class="form-label">Your Message</label>
                <textarea class="form-control" name="message" rows="5" required></textarea>
            </div>
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>

    <!-- Optional: include Bootstrap JS for interactive components -->
</body>

</html>