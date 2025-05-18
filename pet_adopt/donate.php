<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Donate - PetAdopt</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet"> 
</head>
<body>

  <?php include 'nav.php'; ?>

  <header class="bg-light py-2">
    <div class="container text-center">
      <h1 class="display-2">Support Our Mission</h1>
      <p class="lead">Your gift helps us care for more animals and find them loving homes.</p>
    </div>
  </header>

  <main class="container my-5">
    <div class="row justify-content-center mb-4">
      <div class="col-md-10 text-center">
        <img src="images/pleaseadopt.png" alt="Donate to PetAdopt" class="img-fluid rounded shadow-sm" width="450">
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <form action="emildonationregistry.php" method="post">
          <div class="mb-3">
            <label for="email" class="form-label">Your Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="donation" class="form-label">Donation Amount ($):</label>
            <input type="number" class="form-control" id="donation" name="donation" step="0.01" required>
          </div>
          <div class="mb-3">
            <label for="comment" class="form-label">Comment (Optional):</label>
            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Donate Now</button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <footer class="bg-light text-center py-3 mt-5">
    <p>&copy; 2025 PetAdopt. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
