<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pet_id'])) {
    $id = intval($_POST['pet_id']);

    // Delete pet image
    $imagePath = "pet_images/$id.png";
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete pet from DB
    $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $stmt = $conn->prepare("DELETE FROM pets WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: dashboard.php");
    exit;
}
