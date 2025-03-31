<?php

include 'admin_layout.php';

$error = '';
$success = '';

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    
    $sql = "SELECT rentals.id, rentals.user_id, users.name AS user_name, users.email AS user_email,
            rentals.vehicle_id, vehicles.make AS vehicle_make, vehicles.model AS vehicle_model,
            rentals.rental_date, rentals.return_date
            FROM rentals
            INNER JOIN users ON rentals.user_id = users.id
            INNER JOIN vehicles ON rentals.vehicle_id = vehicles.id
            WHERE rentals.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
    $stmt->close();

    if (!$booking) {
        echo "Booking not found.";
        exit;
    }
} else {
    echo "Booking ID not provided.";
    exit;
}

if (isset($_POST['edit_booking'])) {
    $rental_date = $_POST['rental_date'];
    $return_date = $_POST['return_date']; 

    if (empty($rental_date)) {
        $error = "Rental date is required.";
    } else {
        $sql = "UPDATE rentals SET rental_date=?, return_date=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $rental_date, $return_date, $booking_id);

        if ($stmt->execute()) {
            $success = "Booking updated successfully!";
            
            $sql = "SELECT rentals.id, rentals.user_id, users.name AS user_name, users.email AS user_email,
                    rentals.vehicle_id, vehicles.make AS vehicle_make, vehicles.model AS vehicle_model,
                    rentals.rental_date, rentals.return_date
                    FROM rentals
                    INNER JOIN users ON rentals.user_id = users.id
                    INNER JOIN vehicles ON rentals.vehicle_id = vehicles.id
                    WHERE rentals.id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $booking_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $booking = $result->fetch_assoc();
            $stmt->close();
        } else {
            $error = "Error updating booking: " . $conn->error;
        }
    }
}

?>

<div class="manage-bookings-content">
    <h2>Edit Booking</h2>
    <p><a href="manage_bookings.php">Back to Manage Bookings</a></p>

    <?php if ($error): ?>
        <div style="color:red;"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div style="color:green;"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div>
            <label for="user_name">User Name:</label>
            <input type="text" id="user_name" name="user_name" value="<?php echo htmlspecialchars($booking['user_name']); ?>" readonly>
        </div>
        <div>
            <label for="user_email">User Email:</label>
            <input type="text" id="user_email" name="user_email" value="<?php echo htmlspecialchars($booking['user_email']); ?>" readonly>
        </div>
        <div>
            <label for="vehicle">Vehicle:</label>
            <input type="text" id="vehicle" name="vehicle" value="<?php echo htmlspecialchars($booking['vehicle_make'] . ' ' . $booking['vehicle_model']); ?>" readonly>
        </div>
        <div>
            <label for="rental_date">Rental Date:</label>
            <input type="datetime-local" id="rental_date" name="rental_date" value="<?php echo date('Y-m-d\TH:i', strtotime($booking['rental_date'])); ?>" required>
        </div>
        <div>
            <label for="return_date">Return Date:</label>
            <input type="datetime-local" id="return_date" name="return_date" value="<?php echo date('Y-m-d\TH:i', strtotime($booking['return_date'])); ?>">
        </div>
        <button type="submit" name="edit_booking">Update Booking</button>
    </form>
</div>

<?php
include 'admin_layout_footer.php';
?>