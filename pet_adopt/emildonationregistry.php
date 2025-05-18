<?php
require_once 'config.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    $donation = trim($_POST['donation'] ?? '');

    if ($email && is_numeric($donation) && $donation > 0) {
        try {
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare(
                "INSERT INTO donations (email, comment, donation_amount) VALUES (?, ?, ?)"
            );
            $stmt->execute([$email, $comment, $donation]);

            $success = "🎉 Thank you for your generous donation!";
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    } else {
        $error = "Please enter a valid email and donation amount.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You - PetAdopt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <?php include 'nav.php'; ?>

    <header class="py-0" style="background-color: #e0f2f1;">
        <div class="container text-center">
            <h1 class="display-5">Make a Donation</h1>
        </div>
    </header>

    <div class="container py-5">

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" class="mx-auto" style="max-width: 600px;">
            <div class="mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="donation" class="form-label">Donation Amount ($)</label>
                <input type="number" class="form-control" name="donation" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Comment (Optional)</label>
                <textarea class="form-control" name="comment" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit Donation</button>
        </form>
    </div>

    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">&copy; <?= date('Y') ?> PetAdopt. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
