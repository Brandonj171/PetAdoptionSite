<?php
session_start(); // Start or resume session for authentication
// Redirect to login if admin not authenticated
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

require_once 'config.php'; // Include database connection constants

$success = ""; // Message shown on successful pet addition
$error   = ""; // Message shown on error

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Check if form was submitted
    // Retrieve submitted form values (default to empty string)
    $name  = $_POST['name']  ?? '';
    $age   = $_POST['age']   ?? '';
    $breed = $_POST['breed'] ?? '';
    $notes = $_POST['notes'] ?? '';

    try {
        // Create PDO instance for database operations
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Step 1: Insert new pet record (without image filename yet)
        $stmt = $pdo->prepare(
            "INSERT INTO pets (name, age, breed, notes) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$name, $age, $breed, $notes]);
        $newId = $pdo->lastInsertId(); // Get the ID of the newly inserted pet

        // Step 2: Handle uploaded PNG image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = "pet_images/$newId.png"; // Destination path for the image
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

            // Step 3: Update pet record with the image filename
            $stmt = $pdo->prepare(
                "UPDATE pets SET image_filename = ? WHERE id = ?"
            );
            $stmt->execute(["{$newId}.png", $newId]);
        }

        $success = "New pet added successfully."; // Set success message
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage(); // Capture any database errors
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add New Pet - PetAdopt</title> <!-- Page title -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Responsive meta tag -->
    <!-- Bootstrap CSS for styling -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <!-- Custom stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Include site-wide navigation bar -->
    <?php include 'nav.php'; ?>

    <main class="container my-5" style="max-width: 600px;">
        <!-- Header with back link -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Add New Pet</h2>
            <a href="dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
        </div>

        <!-- Display success or error alert if set -->
        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Pet addition form with file upload enabled -->
        <form method="POST" enctype="multipart/form-data">
            <!-- Name field -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    required>
            </div>

            <!-- Age field -->
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input
                    type="text"
                    name="age"
                    id="age"
                    class="form-control">
            </div>

            <!-- Breed field -->
            <div class="mb-3">
                <label for="breed" class="form-label">Breed</label>
                <input
                    type="text"
                    name="breed"
                    id="breed"
                    class="form-control">
            </div>

            <!-- Notes textarea -->
            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea
                    name="notes"
                    id="notes"
                    class="form-control"
                    rows="4"></textarea>
            </div>

            <!-- Image upload field (PNG only) -->
            <div class="mb-4">
                <label for="image" class="form-label">Image (PNG)</label>
                <input
                    type="file"
                    name="image"
                    id="image"
                    class="form-control"
                    accept="image/png"
                    required>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-success w-100">Add Pet</button>
        </form>
    </main>

    <!-- Footer with dynamic current year -->
    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">&copy; <?= date('Y') ?> PetAdopt. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS bundle for interactive components -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>