<?php


include 'admin_layout.php';


$error = '';
$success = '';

if (isset($_POST['add_vehicle'])) {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $registration_number = $_POST['registration_number'];
    $price_per_day = $_POST['price_per_day'];
    $mileage = $_POST['mileage'];
    $availability = isset($_POST['availability']) ? 1 : 0;
    $upload_dir = '../assets/';

    if (empty($make) || empty($model) || empty($year) || empty($registration_number) || empty($price_per_day)) {
        $error = "All fields are required.";
    } else {
        $image_path = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = array('gif', 'png', 'jpg', 'jpeg');
            $file_name = $_FILES['image']['name'];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

            if (in_array($file_ext, $allowed)) {
                $new_file_name = $registration_number . '.' . $file_ext;
                $destination = $upload_dir . $new_file_name;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $image_path = 'assets/' . $new_file_name;
                } else {
                    $error .= "Error uploading image. ";
                }
            } else {
                $error .= "Invalid image file type. Only GIF, PNG, JPG, and JPEG are allowed. ";
            }
        }

        $sql = "INSERT INTO vehicles (make, model, year, registration_number, availability, price_per_day, mileage, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisdiis", $make, $model, $year, $registration_number, $availability, $price_per_day, $mileage, $image_path);

        if ($stmt->execute()) {
            $success = "Vehicle added successfully!";
        } else {
            $error .= "Error adding vehicle: " . $conn->error;
        }
        $stmt->close();
    }
}

?>

<div class="manage-vehicles-content">
    <h2>Add New Vehicle</h2>
    <p><a href="manage_vehicles.php">Back to Manage Vehicles</a></p>

    <?php if ($error): ?>
        <div style="color:red;"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div style="color:green;"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <div>
            <label for="make">Brand:</label>
            <input type="text" id="make" name="make" required>
        </div>
        <div>
            <label for="model">Model:</label>
            <input type="text" id="model" name="model" required>
        </div>
        <div>
            <label for="year">Year:</label>
            <input type="number" id="year" name="year" required>
        </div>
        <div>
            <label for="registration_number">Registration Number:</label>
            <input type="text" id="registration_number" name="registration_number" required>
        </div>
        <div>
            <label for="price_per_day">Price Per Day:</label>
            <input type="number" id="price_per_day" name="price_per_day" step="0.01" required>
        </div>
        <div>
            <label for="mileage">Mileage:</label>
            <input type="number" name="mileage" step="any"></input>
        </div>
        <div>
            <label for="availability">Availability:</label>
            <input type="checkbox" id="availability" name="availability" value="1" checked>
        </div>
        <div>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image">
            <small>Upload an image for the vehicle (optional).</small>
        </div>
        <button type="submit" name="add_vehicle">Add Vehicle</button>
    </form>
</div>

<?php
include 'admin_layout_footer.php';
?>