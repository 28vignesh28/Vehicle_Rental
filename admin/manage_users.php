<?php

include 'admin_layout.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

?>

<div class="manage-users-content">
    <h2>Manage Users</h2>
    <p>This section will allow you to manage user accounts.</p>

    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th></tr>";
        $count = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($count) . "</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['role']) . "</td>";
            echo "<td><a href='edit_users.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete_users.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a></td>";
            echo "</tr>";
            $count++;
        }
        echo "</table>";
    } else {
        echo "No users found.";
    }
    ?>
</div>

<?php
include 'admin_layout_footer.php';
?>