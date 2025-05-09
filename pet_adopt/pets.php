<?php
require_once 'config.php'; // Load database connection constants (DBCONNSTRING, DBUSER, DBPASS)

try {
    // Create a new PDO instance and set error mode
    $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to select all pets
    $stmt = $conn->query("SELECT * FROM pets");
    // Fetch all rows as associative arrays
    $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Terminate script on database error
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Page title -->
    <title>Available Pets - PetAdopt</title>
    <!-- Ensure proper scaling on mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS for layout and styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Include the site-wide navigation bar -->
    <?php include 'nav.php'; ?>

    <!-- Main content container -->
    <main class="container my-5">
        <!-- Section heading -->
        <h2 class="mb-4">Available Pets</h2>

        <!-- Table to display pets without borders -->
        <table class="table table-borderless">
            <tbody>
                <!-- Loop through each pet record -->
                <?php foreach ($pets as $pet): ?>
                    <tr class="align-top mb-4">
                        <!-- Pet image cell -->
                        <td style="width: 300px;">
                            <img
                                src="pet_images/<?= htmlspecialchars($pet['id']) ?>.png"
                                class="img-fluid rounded shadow-sm"
                                alt="<?= htmlspecialchars($pet['name']) ?>">
                        </td>
                        <!-- Pet details cell -->
                        <td>
                            <!-- Pet name -->
                            <h5 class="mb-1"><?= htmlspecialchars($pet['name']) ?></h5>
                            <!-- Pet age -->
                            <p class="mb-1"><strong>Age:</strong> <?= htmlspecialchars($pet['age']) ?></p>
                            <!-- Pet breed -->
                            <p class="mb-1"><strong>Breed:</strong> <?= htmlspecialchars($pet['breed']) ?></p>
                            <!-- Additional notes -->
                            <p class="mb-0"><?= htmlspecialchars($pet['notes']) ?></p>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <!-- Footer section with dynamic year -->
    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">&copy; <?= date('Y') ?> PetAdopt. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JavaScript bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>