<?php
require_once("config.php"); // Include database connection settings

// Create a new PDO instance for database operations
$conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);

// Handle form submission for updating a pet
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    // Prepare the UPDATE statement with named placeholders
    $stmt = $conn->prepare(
        "UPDATE pets 
         SET name = :name, age = :age, breed = :breed, notes = :notes 
         WHERE id = :id"
    );
    // Bind form values to the statement parameters
    $stmt->bindParam(':name',  $_POST['name']);
    $stmt->bindParam(':age',   $_POST['age']);
    $stmt->bindParam(':breed', $_POST['breed']);
    $stmt->bindParam(':notes', $_POST['notes']);
    $stmt->bindParam(':id',    $_POST['id']);
    $stmt->execute(); // Execute the update

    // Redirect back to the dashboard after successful update
    header("Location: dashboard.php");
    exit;
}

// Load existing pet information for editing
if (isset($_GET['id'])) {
    // Prepare SELECT statement to fetch pet by ID
    $stmt = $conn->prepare("SELECT * FROM pets WHERE id = :id");
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $pet = $stmt->fetch(); // Retrieve the pet record

    // If no pet found with given ID, show an error and exit
    if (!$pet) {
        echo "Pet not found.";
        exit;
    }
} else {
    // If no ID provided in query string, show an error and exit
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Pet</title> <!-- Page title -->
    <!-- Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <!-- Heading displaying the pet's current name -->
        <h2>Update Pet: <?= htmlspecialchars($pet['name']) ?></h2>
        <!-- Update form -->
        <form method="POST">
            <!-- Hidden field to pass the pet ID -->
            <input type="hidden" name="id" value="<?= htmlspecialchars($pet['id']) ?>">

            <!-- Name input -->
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="<?= htmlspecialchars($pet['name']) ?>"
                    required>
            </div>

            <!-- Age input -->
            <div class="mb-3">
                <label class="form-label">Age</label>
                <input
                    type="text"
                    name="age"
                    class="form-control"
                    value="<?= htmlspecialchars($pet['age']) ?>"
                    required>
            </div>

            <!-- Breed input -->
            <div class="mb-3">
                <label class="form-label">Breed</label>
                <input
                    type="text"
                    name="breed"
                    class="form-control"
                    value="<?= htmlspecialchars($pet['breed']) ?>"
                    required>
            </div>

            <!-- Notes textarea -->
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea
                    name="notes"
                    class="form-control"
                    rows="3"><?= htmlspecialchars($pet['notes']) ?></textarea>
            </div>

            <!-- Form action buttons -->
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>