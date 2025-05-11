<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Volunteer - PetAdopt</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet"> <!-- Your custom theme file -->
</head>

<body>

  <?php include 'nav.php'; ?>

  <header class="py-0" style="background-color: #e0f2f1;">
    <div class="container text-center">
      <h1 class="display-5">Volunteer Opportunities</h1>
    </div>
  </header>

  <main class="container my-5">
    <div class="row justify-content-center mb-4">
      <div class="col-md-10 text-center">
        <img src="images/volunteer_holding_dachshund.png" alt="PetAdopt Volunteer Image" class="img-fluid rounded shadow-sm">
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-10">

        <!--About Volunteering-->
        <p>
          At <strong>PetAdopt</strong>, we rely on a dedicated group of volunteers like you! Thank you for your interest in 
          helping our vision of giving every loving animal a forever home. We are looking for like-minded people to help this vision
          become a reality.
        </p>
        <p>
          Volunteers at PetAdopt will find like-minded and caring people focused on giving every animal a forever home. We are a small, 
          but dedicated community that loves animals and strives to see every animal paired with a caring family. If that describes you, 
          then we would love for you to <a href="contact.php">Contact Us</a> about volunteering to help the <strong>PetAdopt</strong> vision become reality. 
        </p>
        <hr><br>

        <!--Volunteer Opportunities-->
        <h2>Tell us how you would like to volunteer!</h2>
        <br>
        <p>
          Do you enjoy <em>walking dogs</em>? Do you love <em>socializing with cats</em>? You could share the love of pets with potential families by 
          helping us host <em>adoption events</em>. We need volunteers to help with <em>community outreach</em> to raise awareness of the need for
          adoptive families.         
        </p>
        <h4>Some other opportunites to volunteer include:</h4>
        <ul>
          <li>Cleaning kennels</li>
          <li>Feeding and watering animals</li>
          <li>Animal photography</li>
          <li>Veterenary technicians/assistants</li>
          <li>And much much more!</li>
        </ul>

        <!--FAQs-->
        <hr><br>
        <h2>FAQs</h2>
        <br>
        <div class="faq-buttons">

          <!--Buttons with collapse mechanic on toggle-->
          <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#faq1">What hours can I volunteer?</button>
          <div class="collapse" id="faq1"> 
            <p>
              Our volunteer hours are Monday thru Friday from 8am to 5pm and on Saturday from 8am to 12pm.
            </p>
          </div>
          <br><br>

          <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#faq2">Does petAdopt provide group volunteer opportunities?</button>
          <div class="collapse" id="faq2">
            <p>
              Absolutely! Your group could help us with adoption events, cleaning and grooming animals, or even feeding the animals.
              We are always looking for help!
            </p>
          </div>
          <br><br>

          <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#faq3">How old do I have to be to volunteer with PetAdopt?</button>
          <div class="collapse" id="faq3">
            <p>
              Volunteers must be at least 16 years old. Dog handlers must be at least 18 years old and complete our dog handling course.
            </p>
          </div>
          <br><br>

          <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#faq4">Can I be scheduled to volunteer with my friends?</button>
          <div class="collapse" id="faq4">
            <p>Absolutely! We can schedule you to volunteer with your friends and family, but please refrain from bringing unauthorized visitors with you during your volunteer hours.</p>
          </div>
          <br><br>

        </div>
      </div>
    </div>
  </main>

  <footer class="bg-light text-center py-3 mt-5">
    <p>&copy; 2025 PetAdopt. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>