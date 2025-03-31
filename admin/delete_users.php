<?php


include 'admin_layout.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

  
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $success = "User deleted successfully!";
    } else {
        $error = "Error deleting user: " . $conn->error;
    }
    $stmt->close();
} else {
    echo "User ID not provided.";
    exit;
}

?>

<div class="manage-users-content">
    <h2>Delete User</h2>
    <p><a href="manage_users.php">Back to Manage Users</a></p>

    <?php if (isset($error)): ?>
        <div style="color:red;"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div style="color:green;"><?php echo $success; ?></div>
    <?php endif; ?>

    <p>User with ID <?php echo htmlspecialchars($user_id); ?> has been deleted.</p>
</div>

<?php
include 'admin_layout_footer.php';
?>