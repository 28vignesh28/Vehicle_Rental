<?php
include 'header.php';


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle the stop renting action
if (isset($_POST['stop_rental']) && isset($_POST['rental_id'])) {
    $rental_id_to_stop = $_POST['rental_id'];

    // Get the vehicle ID associated with the rental
    $sql_select_vehicle = "SELECT vehicle_id FROM rentals WHERE id = ? AND user_id = ?";
    $stmt_select_vehicle = $conn->prepare($sql_select_vehicle);
    $stmt_select_vehicle->bind_param("ii", $rental_id_to_stop, $user_id);
    $stmt_select_vehicle->execute();
    $result_select_vehicle = $stmt_select_vehicle->get_result();

    if ($result_select_vehicle->num_rows > 0) {
        $row_vehicle = $result_select_vehicle->fetch_assoc();
        $vehicle_id_to_update = $row_vehicle['vehicle_id'];

        // Update the vehicle availability
        $sql_update_vehicle = "UPDATE vehicles SET availability = 1 WHERE id = ?";
        $stmt_update_vehicle = $conn->prepare($sql_update_vehicle);
        $stmt_update_vehicle->bind_param("i", $vehicle_id_to_update);
        $stmt_update_vehicle->execute();
        $stmt_update_vehicle->close();

        // Delete the rental record
        $sql_delete_rental = "DELETE FROM rentals WHERE id = ? AND user_id = ?";
        $stmt_delete_rental = $conn->prepare($sql_delete_rental);
        $stmt_delete_rental->bind_param("ii", $rental_id_to_stop, $user_id);
        $stmt_delete_rental->execute();
        $stmt_delete_rental->close();

        echo '<div style="color: green; text-align: center; margin-top: 20px;">Rental stopped successfully!</div>';
    } else {
        echo '<div style="color: red; text-align: center; margin-top: 20px;">Error: Could not stop rental.</div>';
    }
    $stmt_select_vehicle->close();
}

// Fetch current rentals for the user
$sql = "SELECT rentals.id AS rental_id, vehicles.make, vehicles.model, vehicles.image_path, rentals.rental_date, rentals.return_date
        FROM rentals
        INNER JOIN vehicles ON rentals.vehicle_id = vehicles.id
        WHERE rentals.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<section class="deals" id="deals">
    <div class="section__container deals__container">
        <h2 class="section__header">My Rentals</h2>
        <p class="section__description">Here are the vehicles you have rented.</p>
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
                                <span><i class="ri-calendar-line"></i> Rental Date:</span> <?php echo htmlspecialchars(date('Y-m-d', strtotime($row['rental_date']))); ?><br>
                                <span><i class="ri-calendar-line"></i> Return Date:</span> <?php echo htmlspecialchars(date('Y-m-d', strtotime($row['return_date']))); ?>
                            </div>

                        </div>
                        <hr>
                        <div class="deals__card__footer">
                            <h3>Rental ID: <?php echo htmlspecialchars($row['rental_id']); ?></h3>
                            <form method="post">
                                <input type="hidden" name="rental_id" value="<?php echo htmlspecialchars($row['rental_id']); ?>">
                                <button type="submit" name="stop_rental" class="btn">Stop Renting</button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No rentals found.</p>";
            }
            ?>
        </div>
    </div>
</section>
<?php
include 'footer.php';
?>
<script>
    ScrollReveal().reveal(".deals__card", {
        ...scrollRevealOption,
        interval: 200,
        delay : 500,
    });
</script>