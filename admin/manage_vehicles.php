<?php

include 'admin_layout.php';


$sql = "SELECT * FROM vehicles";
$result = $conn->query($sql);

?>

<div class="manage-vehicles-content">
    <h2>Manage Vehicles</h2>
    <p><a href="add_vehicle.php">Add New Vehicle</a></p>

    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Model</th><th>Year</th><th>Price Per Day</th><th>Actions</th></tr>";
        $count = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($count) . "</td>";
            echo "<td>" . htmlspecialchars($row['make']) . "</td>";
            echo "<td>" . htmlspecialchars($row['model']) . "</td>";
            echo "<td>" . htmlspecialchars($row['year']) . "</td>";
            echo "<td>" . htmlspecialchars($row['price_per_day']) . "</td>";
            echo "<td><a href='edit_vehicle.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete_vehicle.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this vehicle?\")'>Delete</a></td>";
            echo "</tr>";
            $count++;
        }
        echo "</table>";
    } else {
        echo "No vehicles found.";
    }
    ?>
</div>

<?php
include 'admin_layout_footer.php';
?>