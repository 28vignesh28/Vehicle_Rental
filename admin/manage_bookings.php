<?php

include 'admin_layout.php';

$sql = "SELECT
            rentals.id,
            users.name AS user_name,
            users.email AS user_email,
            vehicles.make AS vehicle_make,
            vehicles.model AS vehicle_model,
            rentals.rental_date,
            rentals.return_date
        FROM rentals
        INNER JOIN users ON rentals.user_id = users.id
        INNER JOIN vehicles ON rentals.vehicle_id = vehicles.id";
$result = $conn->query($sql);

?>

<div class="manage-bookings-content">
    <h2>Manage Bookings</h2>
    <p>This section will allow you to manage car bookings.</p>

    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>User Name</th><th>User Email</th><th>Vehicle</th><th>Rental Date</th><th>Return Date</th><th>Actions</th></tr>";
        $count = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($count) . "</td>";
            echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['user_email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['vehicle_make']) . " " . htmlspecialchars($row['vehicle_model']) . "</td>";
            echo "<td>" . htmlspecialchars($row['rental_date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['return_date']) . "</td>";
            echo "<td><a href='edit_bookings.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete_bookings.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this booking?\")'>Delete</a></td>";
            echo "</tr>";
            $count++;
        }
        echo "</table>";
    } else {
        echo "No bookings found.";
    }
    ?>
</div>

<?php
include 'admin_layout_footer.php';
?>