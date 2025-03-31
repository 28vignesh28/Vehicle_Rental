<?php


include 'admin_layout.php';

$error = '';
$success = '';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        echo "User not found.";
        exit;
    }
} else {
    echo "User ID not provided.";
    exit;
}

if (isset($_POST['edit_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    if (empty($name) || empty($email) || empty($role)) {
        $error = "All fields are required.";
    } else {
        $sql = "UPDATE users SET name=?, email=?, role=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $email, $role, $user_id);

        if ($stmt->execute()) {
            $success = "User updated successfully!";
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
        } else {
            $error = "Error updating user: " . $conn->error;
        }
    }
}

?>

<div class="manage-users-content">
    <h2>Edit User</h2>
    <p><a href="manage_users.php">Back to Manage Users</a></p>

    <?php if ($error): ?>
        <div style="color:red;"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div style="color:green;"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div>
            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>
        <button type="submit" name="edit_user">Update User</button>
    </form>
</div>

<?php
include 'admin_layout_footer.php';
?>