<?php


include 'admin_layout.php';


if (isset($_GET['id'])) {
    $vehicle_id = $_GET['id'];

    
    $sql = "DELETE FROM vehicles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vehicle_id);

    if ($stmt->execute()) {
        $success = "Vehicle deleted successfully!";
    } else {
        $error = "Error deleting vehicle: " . $conn->error;
    }
    $stmt->close();
} else {
    echo "Vehicle ID not provided.";
    exit;
}

?>

<div class="manage-vehicles-content">
    <h2>Delete Vehicle</h2>
    <p><a href="manage_vehicles.php">Back to Manage Vehicles</a></p>

    <?php if (isset($error)): ?>
        <div style="color:red;"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div style="color:green;"><?php echo $success; ?></div>
    <?php endif; ?>

    <p>Vehicle with ID <?php echo htmlspecialchars($vehicle_id); ?> has been deleted.</p>
</div>

<?php
include 'admin_layout_footer.php';
?>