<?php
require_once 'config.php'; // Load database connection constants (DBCONNSTRING, DBUSER, DBPASS)

// Handle form submission for scheduling a meeting
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['schedule_meeting'])) {
    try {
        $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $petId = $_POST['pet_id'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $appointmentDate = $_POST['appointment_date'];
        $appointmentTime = $_POST['appointment_time'];
        $notes = $_POST['notes'];

        $stmt = $conn->prepare("INSERT INTO appointment (pet_id, name, phone, email, appointment_date, appointment_time, notes, created_at) VALUES (:pet_id, :name, :phone, :email, :appointment_date, :appointment_time, :notes, NOW())");
        $stmt->bindParam(':pet_id', $petId, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':appointment_date', $appointmentDate, PDO::PARAM_STR);
        $stmt->bindParam(':appointment_time', $appointmentTime, PDO::PARAM_STR);
        $stmt->bindParam(':notes', $notes, PDO::PARAM_STR);
        $stmt->execute();

        $successMessage = "Your meeting request has been submitted!";
    } catch (PDOException $e) {
        $errorMessage = "Error submitting your request: " . $e->getMessage();
    }
}

// Handle search functionality
$searchTerm = '';
$searchResults = [];
if (isset($_GET['search'])) {
    $searchTerm = trim($_GET['search']);
    if (!empty($searchTerm)) {
        try {
            $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT * FROM pets WHERE name LIKE :term OR breed LIKE :term");
            $stmt->bindValue(':term', '%' . $searchTerm . '%', PDO::PARAM_STR);
            $stmt->execute();
            $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $errorMessage = "Error searching pets: " . $e->getMessage();
        }
    }
}

// Fetch all pets for display
try {
    $conn = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT * FROM pets");
    $allPets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Determine which pets to display and the message
$petsToDisplay = $allPets; // Always display all pets
$searchResultMessage = '';
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    if (empty($searchResults)) {
        $searchResultMessage = '<p class="alert alert-warning">No pets found matching your search criteria for "'. htmlspecialchars($searchTerm) .'". Showing all available pets.</p>';
    } else {
        $searchResultMessage = '<p class="alert alert-success">' . count($searchResults) . ' pet(s) found matching your search for "'. htmlspecialchars($searchTerm) .'".</p>';
        $petsToDisplay = $searchResults; // If results are found, display only those
    }
} elseif (isset($errorMessage)) {
    // Display general error message if search failed
    $searchResultMessage = '<p class="alert alert-danger">' . $errorMessage . '</p>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Available Pets - PetAdopt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        /* Basic styling for the modal */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <?php include 'nav.php'; ?>

    <header class="py-0" style="background-color: #e0f2f1;">
        <div class="container text-center">
            <h1 class="display-5">Available Pets</h1>
        </div>
    </header>

    <main class="container my-5">

        <form class="mb-3" method="get" action="">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search by name or breed" name="search" value="<?= htmlspecialchars($searchTerm) ?>">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>

        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success"><?= $successMessage ?></div>
        <?php endif; ?>

        <?php if (isset($errorMessage) && !isset($_GET['search'])): ?>
            <div class="alert alert-danger"><?= $errorMessage ?></div>
        <?php endif; ?>

        <?= $searchResultMessage ?>

        <?php if (!empty($petsToDisplay)): ?>
            <table class="table table-borderless">
                <tbody>
                    <?php foreach ($petsToDisplay as $pet): ?>
                        <tr class="align-top mb-4">
                            <td style="width: 300px;">
                                <img
                                    src="pet_images/<?= htmlspecialchars($pet['id']) ?>.png"
                                    class="img-fluid rounded shadow-sm"
                                    alt="<?= htmlspecialchars($pet['name']) ?>">
                            </td>
                            <td>
                                <h5 class="mb-1"><?= htmlspecialchars($pet['name']) ?></h5>
                                <p class="mb-1"><strong>Age:</strong> <?= htmlspecialchars($pet['age']) ?></p>
                                <p class="mb-1"><strong>Breed:</strong> <?= htmlspecialchars($pet['breed']) ?></p>
                                <p class="mb-0"><?= htmlspecialchars($pet['notes']) ?></p>
                                <button class="btn btn-primary mt-2" data-pet-id="<?= htmlspecialchars($pet['id']) ?>" data-pet-name="<?= htmlspecialchars($pet['name']) ?>" onclick="openModal(this)">Meet <?= htmlspecialchars($pet['name']) ?></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No pets available at the moment.</p>
        <?php endif; ?>

        <div id="meetingModal" class="modal">
            <div class="modal-content">
                <span class="close-button" onclick="closeModal()">&times;</span>
                <h3>Schedule a Meeting with <span id="modal-pet-name"></span></h3>
                <form method="post" action="">
                    <input type="hidden" name="pet_id" id="modal-pet-id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number:</label>
                        <input type="tel" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="appointment_date" class="form-label">Preferred Date:</label>
                        <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="appointment_time" class="form-label">Preferred Time:</label>
                        <input type="time" class="form-control" id="appointment_time" name="appointment_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Additional Notes (optional):</label>
                        <textarea class="form-control" id="notes" name="notes"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="schedule_meeting">Submit Request</button>
                </form>
            </div>
        </div>
    </main>

    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">&copy; <?= date('Y') ?> PetAdopt. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Get the modal
        var modal = document.getElementById("meetingModal");

        // Get the close button
        var closeButton = document.querySelector(".close-button");

        // Function to open the modal
        function openModal(button) {
            var petId = button.getAttribute("data-pet-id");
            var petName = button.getAttribute("data-pet-name");
            document.getElementById("modal-pet-id").value = petId;
            document.getElementById("modal-pet-name").innerText = petName;
            modal.style.display = "block";
        }

        // Function to close the modal
        function closeModal() {
            modal.style.display = "none";
        }

        // Close the modal if the user clicks outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>