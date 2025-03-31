<?php


include 'admin_layout.php';

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    
    $sql_select = "SELECT vehicle_id FROM rentals WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $booking_id);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();
    if ($result_select->num_rows > 0) {
        $row_select = $result_select->fetch_assoc();
        $vehicle_id = $row_select['vehicle_id'];

      
        $sql_delete = "DELETE FROM rentals WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $booking_id);

        if ($stmt_delete->execute()) {
          
            $sql_update = "UPDATE vehicles SET availability = 1 WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("i", $vehicle_id);
            if ($stmt_update->execute()) {
                $success = "Booking deleted successfully and vehicle made available!";
            } else {
                $error = "Booking deleted successfully, but failed to update vehicle availability: " . $conn->error;
            }
            $stmt_update->close();
        } else {
            $error = "Error deleting booking: " . $conn->error;
        }
        $stmt_delete->close();
    } else {
        $error = "Booking not found.";
    }
    $stmt_select->close();
} else {
    echo "Booking ID not provided.";
    exit;
}

?>

<div class="manage-bookings-content">
    <h2>Delete Booking</h2>
    <p><a href="manage_bookings.php">Back to Manage Bookings</a></p>

    <?php if (isset($error)): ?>
        <div style="color:red;"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div style="color:green;"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if (isset($vehicle_id)): ?>
        <p>Booking with ID <?php echo htmlspecialchars($booking_id); ?> has been deleted, and vehicle ID <?php echo htmlspecialchars($vehicle_id); ?> is now available.</p>
    <?php endif; ?>
</div>

<?php
include 'admin_layout_footer.php';
?>