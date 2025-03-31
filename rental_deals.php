<?php
include 'header.php';

if (isset($_POST['confirm_booking']) && isset($_POST['vehicle_id'])) {
    $vehicle_id = $_POST['vehicle_id'];
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id']; 

        $sql_check_user = "SELECT id FROM users WHERE id = ?";
        $stmt_check_user = $conn->prepare($sql_check_user);
        $stmt_check_user->bind_param("i", $user_id);
        $stmt_check_user->execute();
        $stmt_check_user->store_result();

        if ($stmt_check_user->num_rows === 0) {
            die("Error: Invalid user ID.");
        }
        $stmt_check_user->close();
    } else {
        die("Error: User is not logged in.");
    }

    
    $sql_update = "UPDATE vehicles SET availability = 0 WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $vehicle_id);
    $stmt_update->execute();
    $stmt_update->close();

    
    $rental_date = date("Y-m-d H:i:s");
    $return_date = date("Y-m-d H:i:s", strtotime("+1 day"));
    $sql_insert = "INSERT INTO rentals (user_id, vehicle_id, rental_date, return_date) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iiss", $user_id, $vehicle_id, $rental_date, $return_date);
    $stmt_insert->execute();
    $stmt_insert->close();

    $booking_success = true;
    $success_vehicle_id = $vehicle_id; 
}

$sql = "SELECT * FROM vehicles";
$result = $conn->query($sql);
?>
<section class="deals" id="deals">
    <div class="section__container deals__container">
        <h2 class="section__header">Available Vehicle Rentals</h2>

        <div id="confirmationModal" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid #ccc; z-index: 1001;">
          <h3>Confirm Booking?</h3>
          <form method="post" action="">
            <input type="hidden" id="modal_vehicle_id" name="vehicle_id" value="">
            <button type="submit" name="confirm_booking" id="confirmBooking">Confirm</button>
            <button type="button" id="cancelBooking">Cancel</button>
          </form>
        </div>
        <div id="modalBackdrop" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000;"></div>

        <p class="section__description">
            Browse our wide selection of vehicles available for rent. Find the perfect vehicle for your needs at a great price!
        </p>
        <div class="tab__content active">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="deals__card">
                        <img src="<?php echo htmlspecialchars($row['image_path'] ? $row['image_path'] : 'assets/deals-default.png'); ?>" alt="<?php echo htmlspecialchars($row['make'] . ' ' . $row['model']); ?>">
                        <h4><?php echo htmlspecialchars($row['make'] . ' ' . $row['model']); ?></h4>
                        <div class="deals__card__grid">
                            <div>
                                <span><i class="ri-calendar-line"></i></span> <?php echo htmlspecialchars($row['year']); ?>
                            </div>
                            <div>
                                <span><i class="ri-roadster-line"></i></span> <?php echo htmlspecialchars($row['registration_number']); ?>
                            </div>
                            <div>
                                <span><i class="ri-gas-station-line"></i></span> <?php echo htmlspecialchars($row['mileage']); ?> km/l
                            </div>
                        </div>
                        <hr>
                        <div class="deals__card__footer">
                            <h3>₹<?php echo htmlspecialchars($row['price_per_day']); ?><span>/Per Day</span></h3>
                            <?php if ($row['availability'] == 1) { ?>
                                <a href="#" class="rent-now-button" data-vehicle-id="<?php echo htmlspecialchars($row['id']); ?>">
                                    Rent Now
                                    <span><i class="ri-arrow-right-line"></i></span>
                                </a>
                            <?php } else { ?>
                                <a href="#" class="rent-now-button booked" style="pointer-events: none; cursor: default; color: grey;">
                                    Booked
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "No vehicles available for rent.";
            }
            ?>
        </div>
    </div>
</section>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const rentNowButtons = document.querySelectorAll('.rent-now-button:not(.booked)');
    const confirmationModal = document.getElementById('confirmationModal');
    const modalBackdrop = document.getElementById('modalBackdrop');
    const confirmBookingButton = document.getElementById('confirmBooking');
    const cancelBookingButton = document.getElementById('cancelBooking');
    const modalVehicleIdInput = document.getElementById('modal_vehicle_id');

    rentNowButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); 
            const vehicleId = this.dataset.vehicleId;
            modalVehicleIdInput.value = vehicleId;
            modalBackdrop.style.display = 'block';
            confirmationModal.style.display = 'block';
        });
    });

    cancelBookingButton.addEventListener('click', function() {
        modalBackdrop.style.display = 'none';
        confirmationModal.style.display = 'none';
    });

    <?php if (isset($booking_success) && $booking_success): ?>
        modalBackdrop.style.display = 'block';
        confirmationModal.style.display = 'block';
        confirmationModal.innerHTML = '<h3>Booking Successful!</h3>';
        setTimeout(function(){
            window.location.href = 'rental_deals.php'; 
        }, 2000);
    <?php endif; ?>
});
</script>
<?php
include 'footer.php';
?>
<script>
    // <script src="https://unpkg.com/scrollreveal">
    

    ScrollReveal().reveal(".deals__card", {
        ...scrollRevealOption,
        interval: 200,
        delay : 500,
    });
</script>