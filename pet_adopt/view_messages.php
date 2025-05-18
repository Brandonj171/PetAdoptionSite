<?php
// view_messages.php - Admin interface to view and manage contact form submissions

session_start(); // Resume session to check for admin authentication
require_once("config.php"); // Load database connection settings

// Redirect to login page if admin is not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$success = ""; // Initialize success message
$error   = ""; // Initialize error message

try {
    // Establish PDO connection to the database
    $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Handle deletion of a specific message
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
        $deleteId = intval($_POST['delete_id']); // Ensure ID is integer
        $delStmt  = $conn->prepare("DELETE FROM contact_messages WHERE id = :id");
        $delStmt->bindParam(':id', $deleteId, PDO::PARAM_INT);
        $delStmt->execute();
        $success = "Message #{$deleteId} deleted."; // Set confirmation message
    }

    // 2. Mark all unread messages as read
    $conn->exec("UPDATE contact_messages SET is_read = 1 WHERE is_read = 0");

    // 3. Fetch all messages ordered by submission time (newest first)
    $stmt     = $conn->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage(); // Capture any database errors
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact Messages – Admin</title>
    <!-- Ensure proper scaling on mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS for layout and styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <script>
        // Confirm deletion prompt
        function confirmDelete() {
            return confirm("Are you sure you want to delete this message?");
        }
    </script>
</head>

<body>

    <!-- Include the site-wide navigation bar -->
    <?php include 'nav.php'; ?>

    <main class="container my-5">
        <!-- Page header with back-to-dashboard link -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Contact Form Submissions</h2>
            <a href="dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
        </div>

        <!-- Display success message if set -->
        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <!-- Display error message if set -->
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- If no messages exist, show placeholder text -->
        <?php if (empty($messages)): ?>
            <p>No messages submitted yet.</p>
        <?php else: ?>
            <!-- Responsive table for message listings -->
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Submitted At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through each message and output row -->
                        <?php foreach ($messages as $msg): ?>
                            <tr>
                                <td><?= htmlspecialchars($msg['id']) ?></td>
                                <td><?= htmlspecialchars($msg['name']) ?></td>
                                <td><?= htmlspecialchars($msg['email']) ?></td>
                                <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                                <td><?= htmlspecialchars($msg['submitted_at']) ?></td>
                                <td>
                                    <!-- Delete button with confirmation -->
                                    <form method="POST" onsubmit="return confirmDelete();" style="display:inline-block;">
                                        <input type="hidden" name="delete_id" value="<?= $msg['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </main>

    <!-- Footer with dynamic current year -->
    <footer class="bg-light text-center py-3">
        <p class="mb-0">&copy; <?= date('Y') ?> PetAdopt. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JavaScript bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>