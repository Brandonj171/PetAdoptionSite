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

  <header class="py-0" style="background-color: #e0f2f1;">
    <div class="container text-center">
      <h1 class="display-5">Support Our Mission</h1>
    </div>
  </header>

  <main class="container my-5">
    <div class="row justify-content-center mb-4">
      <div class="col-md-10 text-center">
      <img src="images/pleaseadopt.png" alt="Donate to PetAdopt" class="img-fluid rounded shadow-sm" width="450">
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-10">

        <p>
          At <strong>PetAdopt</strong>, your donation directly helps save and improve the lives of countless animals in need. When you contribute through our website, you're making a real impact. Here's why your support matters:
        </p>

        <ul>
          <li><strong>🐾 Rescue & Shelter:</strong> Provide a safe home for abandoned and abused pets.</li>
          <li><strong>🩺 Medical Care:</strong> Fund vaccinations, surgeries, and emergency treatments.</li>
          <li><strong>❤️ Loving Matches:</strong> Help us match animals with the perfect forever families.</li>
          <li><strong>📢 Community Education:</strong> Spread awareness about responsible pet ownership.</li>
          <li><strong>💯 Transparency:</strong> Every donation is used wisely and with care.</li>
        </ul>

        <p class="mt-4">
          <strong>Every dollar counts</strong> and brings us closer to a world where every pet has a loving home. Please consider making a one-time or recurring donation using the button below.
        </p>

        <div class="text-center my-4">
        <a href="emildonationregistry.php" class="btn btn-success btn-lg">Donate Now</a>        
      </div>

        <hr><br>

        <h2>Frequently Asked Questions</h2>
        <br>
        <div class="faq-buttons">
          <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#faq1">Is my donation tax-deductible?</button>
          <div class="collapse" id="faq1">
            <p>Yes! PetAdopt is a registered nonprofit organization and your donation may be tax-deductible. Please consult your tax advisor.</p>
          </div>
          <br><br>

          <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#faq2">Can I donate in honor of someone?</button>
          <div class="collapse" id="faq2">
            <p>Absolutely! You can dedicate your donation to a person or pet during the donation process.</p>
          </div>
          <br><br>

          <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#faq3">Will I receive a receipt?</button>
          <div class="collapse" id="faq3">
            <p>Yes, you will receive an email receipt immediately after donating. You can use it for your records and tax purposes.</p>
          </div>
          <br><br>
        </div>

      </div>
    </div>
  </main>
    <!-- QR Code Donation Section -->
    <div class="container text-center my-5">
      <h3>Scan to Donate</h3>
      <p>Use your phone to donate securely to <strong>PetAdopt</strong> by scanning this QR code:</p>
      <img src="images/petadoptQR.png" alt="QR Code to Donate to PetAdopt" class="img-fluid" style="max-width: 250px;">
    </div>

  <footer class="bg-light text-center py-3 mt-5">
    <p>&copy; 2025 PetAdopt. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
