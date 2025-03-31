<footer class="footer">
    <div class="section__container footer__container">
        <div class="footer__col">
            <div class="footer__logo">
                <a href="index.php" class="logo">
                    <img src="assets/logo-white.png" alt="logo">
                    <span>UDrive</span>
                </a>
            </div>
            <p>
                We're here to provide you with the best vehicles and a seamless
                rental experience. Stay connected for updates, special offers, and
                more. Drive with confidence!
            </p>
            <ul class="footer__socials">
                <li>
                    <a href="#"><i class="ri-facebook-fill"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ri-twitter-fill"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ri-linkedin-fill"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ri-instagram-line"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ri-youtube-fill"></i></a>
                </li>
            </ul>
        </div>
        <div class="footer__col">
            <h4>Our Services</h4>
            <ul class="footer__links">
                <li><a href="index.php">Home</a></li>
                <li><a href="rental_deals.php">Rental Deals</a></li>
                <li><a href="why_choose_us.php">Why Choose Us</a></li>
            </ul>
        </div>
        <div class="footer__col">
            <h4>Contact</h4>
            <ul class="footer__links">
                <li>
                    <a href="#">
                        <span><i class="ri-phone-fill"></i></span> +91 9898989898
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span><i class="ri-map-pin-fill"></i></span> Palakollu, Andhra Pradesh, India
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span><i class="ri-mail-fill"></i></span> udrive@gmail.com
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="footer__bar">
        Copyright © 2025 UDrive. All rights reserved.
    </div>
</footer>
<script src="https://unpkg.com/scrollreveal"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="main.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileIcon = document.querySelector('.profile-icon-button');
        const dropdownContent = document.querySelector('.profile-dropdown-content');
        if (profileIcon && dropdownContent) {
            profileIcon.addEventListener('click', function() {
                dropdownContent.style.display = (dropdownContent.style.display === 'block') ? 'none' : 'block';
            });
            document.addEventListener('click', function(event) {
                if (!profileIcon.contains(event.target) && !dropdownContent.contains(event.target)) {
                    dropdownContent.style.display = 'none';
                }
            });
        }
    });
</script>
</body>
</html>