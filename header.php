<?php
include 'connect.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/logo-dark.png" >
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Vehicle Rental</title>
</head>
<body>
<header>
    <nav>
        <div class="nav__header">
            <div class="nav__logo">
                <a href="index.php" class="logo">
                    <img src="assets/logo-white.png" alt="logo" class="logo-white">
                    <img src="assets/logo-dark.png" alt="logo" class="logo-dark">
                    <span>UDrive</span>
                </a>
            </div>
            <div class="nav__menu__btn" id="menu-btn">
                <i class="ri-menu-line"></i>
            </div>
        </div>
        <ul class="nav__links" id="nav-links">
            <li><a href="index.php">Home</a></li>
            <!-- <li><a href="about.php">About</a></li> -->
            <li><a href="rental_deals.php">Rental Deals</a></li>
            <li><a href="why.php">Why Choose Us</a></li>
            <li><a href="#">Register</a></li>
        </ul>
        <div class="nav__btns">
            <?php
            if (isset($_SESSION['user_name'])) {
                ?>
                <div class="profile-dropdown" style="z-index: 10000;">
                    <span style="display: flex; align-items: center;">
                        <span style="margin-right: 10px;"> <?php echo $_SESSION['user_name']; ?> </span>
                        <button class="profile-icon-button"><i class="ri-user-3-fill" style="font-size: 1.5em;"></i></button>
                    </span>
                    <div class="profile-dropdown-content">
                        <a href="my_rentals.php">My Rentals</a>
                        <a href="index.php?logout=true">Logout</a>
                    </div>
                </div>
            <?php } else {
                echo '<button class="btn" onclick="window.location.href=\'login.php\'">Register</button>';
            }
            ?>
        </div>
    </nav>

