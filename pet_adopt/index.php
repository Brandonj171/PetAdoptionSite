<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Home - PetAdopt</title>
  <!-- Ensure proper scaling on mobile devices -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom stylesheet -->
  <link href="css/style.css" rel="stylesheet">
</head>

<body>

  <!-- Include the site-wide navigation bar -->
  <?php include 'nav.php'; ?>

  <!-- Hero header section -->
  <header class="bg-light py-2">
    <div class="container text-center">
      <!-- Main page heading -->
      <h1 class="display-2">Welcome to PetAdopt</h1>
      <!-- Subheading / tagline -->
      <p class="lead">Your new best friend is waiting for you.</p>
      <!-- Call-to-action button linking to available pets -->
      <a href="pets.php" class="btn btn-primary btn-lg mt-3">View Available Pets</a>
    </div>
  </header>

  <!-- Main content area -->
  <main class="container my-5">
    <!-- Section heading -->
    <h2>Why Adopt With Us?</h2>
    <!-- Introductory paragraph -->
    <p>We believe every pet deserves a loving home. PetAdopt connects animals in need with people ready to give them care, comfort, and a second chance.</p>

    <!-- Feature cards row -->
    <div class="row mt-4">
      <!-- Card 1: Happy Tails -->
      <div class="col-md-4 d-flex"><a class="card-anchor" href="happy_tails.php">
        <div class="card h-100">
          <!-- Card image -->
          <img src="images/happy-dog.png" class="card-img-top" alt="Happy dog">
          <div class="card-body">
            <!-- Card title -->
            <h5 class="card-title">Happy Tails</h5>
            <!-- Card description -->
            <p class="card-text">Read stories of successful adoptions from our wonderful community.</p>
          </div>
        </div>
        </a>
      </div>

      <!-- Card 2: Volunteer -->
      <div class="col-md-4 d-flex"><a class="card-anchor" href="volunteer.php">
        <div class="card h-100">      
          <!-- Card image -->
          <img src="images/volunteer.png" class="card-img-top" alt="Volunteer with pets">
          <div class="card-body">
            <!-- Card title -->
            <h5 class="card-title">Volunteer</h5>
            <!-- Card description -->
            <p class="card-text">Join our team and make a difference in a pet’s life.</p> 
          </div>
        </div>
        </a>
      </div>

      <!-- Card 3: Support Our Mission -->
      <div class="col-md-4 d-flex"><a class="card-anchor" href="donate.php">
        <div class="card h-100">
          <!-- Card image -->
          <img src="images/donate.png" class="card-img-top" alt="Donate to support">
          <div class="card-body">
            <!-- Card title -->
            <h5 class="card-title">Support Our Mission</h5>
            <!-- Card description -->
            <p class="card-text">Every donation helps us care for more animals. Thank you!</p>
          </div>
        </div>
      </div>
      </a>
    </div>

  </main>

  <!-- Footer section -->
  <footer class="bg-light text-center py-3 mt-5">
    <!-- Copyright notice -->
    <p>&copy; 2025 PetAdopt. All rights reserved.</p>
  </footer>

  <!-- Bootstrap JavaScript bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>