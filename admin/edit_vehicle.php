<?php


include 'admin_layout.php';

$error = '';
$success = '';

if (isset($_GET['id'])) {
    $vehicle_id = $_GET['id'];

    
    $sql = "SELECT * FROM vehicles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $vehicle = $result->fetch_assoc();
    $stmt->close();

    if (!$vehicle) {
        echo "Vehicle not found.";
        exit;
    }
} else {
    echo "Vehicle ID not provided.";
    exit;
}

if (isset($_POST['edit_vehicle'])) {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $registration_number = $_POST['registration_number'];
    $price_per_day = $_POST['price_per_day'];
    $mileage = $_POST['mileage'];
    $availability = isset($_POST['availability']) ? 1 : 0;
   

    if (empty($make) || empty($model) || empty($year) || empty($registration_number) || empty($price_per_day)) {
        $error = "All fields are required.";
    } else {
        $sql = "UPDATE vehicles SET make=?, model=?, year=?, registration_number=?, availability=?, price_per_day=?, mileage=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisdisi", $make, $model, $year, $registration_number, $availability, $price_per_day, $mileage, $vehicle_id);

        if ($stmt->execute()) {
            $success = "Vehicle updated successfully!";
            $sql = "SELECT * FROM vehicles WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $vehicle_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $vehicle = $result->fetch_assoc();
            $stmt->close();
        } else {
            $error = "Error updating vehicle: " . $conn->error;
        }
        
    }
}

?>

<div class="manage-vehicles-content">
    <h2>Edit Vehicle</h2>
    <p><a href="manage_vehicles.php">Back to Manage Vehicles</a></p>

    <?php if ($error): ?>
        <div style="color:red;"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div style="color:green;"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div>
            <label for="make">Brand:</label>
            <input type="text" id="make" name="make" value="<?php echo htmlspecialchars($vehicle['make']); ?>" required>
        </div>
        <div>
            <label for="model">Model:</label>
            <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($vehicle['model']); ?>" required>
        </div>
        <div>
            <label for="year">Year:</label>
            <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($vehicle['year']); ?>" required>
        </div>
        <div>
            <label for="registration_number">Registration Number:</label>
            <input type="text" id="registration_number" name="registration_number" value="<?php echo htmlspecialchars($vehicle['registration_number']); ?>" required>
        </div>
        <div>
            <label for="price_per_day">Price Per Day:</label>
            <input type="number" id="price_per_day" name="price_per_day" step="100" value="<?php echo htmlspecialchars($vehicle['price_per_day']); ?>" required>
        </div>
        <div>
            <label for="mileage">Mileage:</label>
            <input type="number" id="mileage" name="mileage"     step="any" value="<?php echo htmlspecialchars($vehicle['mileage']); ?>" >
        </div>
        <div>
            <label for="availability">Availability:</label>
            <input type="checkbox" id="availability" name="availability" value="1" <?php echo $vehicle['availability'] ? 'checked' : ''; ?>>
        </div>
        <button type="submit" name="edit_vehicle">Update Vehicle</button>
    </form>
</div>

<?php
include 'admin_layout_footer.php';
?>