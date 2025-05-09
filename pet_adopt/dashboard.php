<?php
session_start(); // Start or resume the session for authentication checks
require_once("config.php"); // Load database connection constants (DBCONNSTRING, DBUSER, DBPASS)

// Redirect to login page if admin is not authenticated
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

try {
    // Establish PDO connection to the database
    $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Count unread contact form submissions
    $stmtUnread   = $conn->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0");
    $unreadCount  = (int)$stmtUnread->fetchColumn();

    // Handle deletion of a pet when delete button is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_pet_id'])) {
        $id = intval($_POST['delete_pet_id']); // Ensure the ID is an integer
        // Remove corresponding image file if it exists
        $imagePath = "pet_images/$id.png";
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        // Delete pet record from the database
        $stmtDel = $conn->prepare("DELETE FROM pets WHERE id = :id");
        $stmtDel->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtDel->execute();
    }

    // Load all pet records for display
    $stmtPets = $conn->query("SELECT * FROM pets");
    $pets     = $stmtPets->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Terminate script and show error if database operation fails
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - PetAdopt</title> <!-- Page title -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Responsive meta tag -->
    <!-- Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Include the site-wide navigation bar -->
    <?php include 'nav.php'; ?>

    <main class="container my-5">

        <!-- Display alert if there are unread contact messages -->
        <?php if ($unreadCount > 0): ?>
            <div class="alert alert-warning" role="alert">
                🔔 You have <?= $unreadCount ?> new contact message<?= $unreadCount > 1 ? 's' : '' ?>.
                <a href="view_messages.php" class="alert-link">View Messages</a>
            </div>
        <?php endif; ?>

        <!-- Dashboard header with action buttons -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Available Pets</h2>
            <div>
                <!-- Link to add a new pet -->
                <a href="add_pet.php" class="btn btn-success">+ Add New Pet</a>
                <!-- Link to view messages with unread count badge -->
                <a href="view_messages.php" class="btn btn-info ms-2">
                    View Messages
                    <?php if ($unreadCount > 0): ?>
                        <span class="badge bg-light text-dark ms-1"><?= $unreadCount ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </div>

        <!-- Table listing all pets with actions -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Breed</th>
                    <th>Notes</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through each pet and output its details -->
                <?php foreach ($pets as $pet): ?>
                    <tr>
                        <!-- Pet name column -->
                        <td><?= htmlspecialchars($pet['name']) ?></td>
                        <!-- Pet age column -->
                        <td><?= htmlspecialchars($pet['age']) ?></td>
                        <!-- Pet breed column -->
                        <td><?= htmlspecialchars($pet['breed']) ?></td>
                        <!-- Pet notes column -->
                        <td><?= htmlspecialchars($pet['notes']) ?></td>
                        <!-- Pet image thumbnail column -->
                        <td>
                            <img src="pet_images/<?= $pet['id'] ?>.png"
                                width="80" height="80" alt="Pet">
                        </td>
                        <!-- Action buttons column for delete and update -->
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <!-- Delete form with confirmation dialog -->
                                <form method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this pet?');"
                                    style="margin:0;">
                                    <input type="hidden" name="delete_pet_id" value="<?= $pet['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                <!-- Link to update pet details -->
                                <a href="update_pet.php?id=<?= $pet['id'] ?>"
                                    class="btn btn-primary btn-sm">Update</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <!-- Footer section with dynamic current year -->
    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">&copy; <?= date('Y') ?> PetAdopt. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS bundle for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>