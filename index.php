<?php
include 'header.php'; 


if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_destroy();
    header("Location: index.php"); 
    exit();
}

?>
<div class="header__container" id="home">
    <div class="header__image">
        <img src="assets/header.png" alt="header">
    </div>
    <div class="header__content">
        <h2>👍 100% Trusted vehicle rental platform in India</h2>
        <h1>FAST AND EASY WAY TO RENT A VEHICLE</h1>
        <p class="section__description">
            Rent your dream vehicle today! Choose from a diverse fleet of cars and bikes, all designed to meet your travel needs. Enjoy seamless booking, unbeatable prices, and exceptional service every step of the way.
        </p>
    </div>
</div>
</header>

  <section class="subscribe__container">
      <div class="subscribe__image">
        <img src="assets/slide1.png" alt="subscribe" />
      </div>
      <div class="subscribe__content">
        <h2 class="section__header">
            Experience top-notch quality vehicles for your journeys
        </h2>
        <p class="section__description">
            Feel the thrill of the open road with our meticulously maintained vehicles. 
            Designed for comfort, performance, and style, every drive becomes an 
            unforgettable experience. Whether it's a short trip or a long journey, 
            our cars ensure you travel with confidence and joy.
        </p>
        
      </div>
    </section>

<?php
include 'footer.php'; 
?> 
    
