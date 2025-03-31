<?php


include 'connect.php';

$signup_error = "";
$login_error = "";
$signup_success = "";


if (isset($_POST['signup_name']) && isset($_POST['signup_email']) && isset($_POST['signup_password']) && isset($_POST['signup_confirm_password'])) {
    $name = trim($_POST['signup_name']);
    $email = filter_var(trim($_POST['signup_email']), FILTER_VALIDATE_EMAIL);
    $password = $_POST['signup_password'];
    $confirm_password = $_POST['signup_confirm_password'];

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $signup_error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $signup_error = "Passwords do not match.";
    } elseif (!$email) {
        $signup_error = "Invalid email format.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')"; 
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            $stmt->close();
        header("Location: login.php?signup=success"); 
        exit();
        } else {
            $signup_error = "Error: Could not create account. Please try again later.";
        }
        $stmt->close();
    }
}

if (isset($_POST['login_email']) && isset($_POST['login_password'])) {
    $email = filter_var(trim($_POST['login_email']), FILTER_VALIDATE_EMAIL);
    $password = $_POST['login_password'];

    if (empty($email) || empty($password)) {
        $login_error = "Please enter both email and password.";
    } elseif (!$email) {
        $login_error = "Invalid email format.";
    } else {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
        
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_role'] = $row['role']; 
                $_SESSION['user_id'] = $row['id']; 
                $_SESSION['loggedin'] = true;

                if ($_SESSION['user_role'] == 'admin') {
                    header("Location: admin/dashboard.php");
                    exit();
                } else {
                    header("Location: index.php");
                    exit();
                }
            } else {
                $login_error = "Login failed. Invalid password.";
            }
        } else {
            $login_error = "Login failed. Invalid email or password.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <link rel="icon" href="assets/logo-dark.png" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login & Registration Form</title>
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
    <div class="container">
        <input type="checkbox" id="check" <?php if (isset($_GET['signup']) && $_GET['signup'] == 'success') echo 'checked'; ?>>
        <div class="login form">
            <header>Login</header>
            <form action="login.php" method="post">
                <input type="text" name="login_email" placeholder="Enter your email">
                <input type="password" name="login_password" placeholder="Enter your password">
                <input type="submit" class="button" value="Login">
                <?php if (!empty($login_error)) { echo '<p style="color:red;">' . $login_error . '</p>'; } ?>
                <?php if (isset($_GET['signup']) && $_GET['signup'] == 'success') { echo '<p style="color:green;">Signup successful. Please log in.</p>'; } ?>
            </form>
            <div class="signup">
                <span class="signup">Don't have an account?
                    <label for="check">Signup</label>
                </span>
            </div>
        </div>
        <div class="registration form">
            <header>Signup</header>
            <form action="login.php" method="post">
                <input type="text" name="signup_name" placeholder="Enter your name" required>
                <input type="text" name="signup_email" placeholder="Enter your email" required>
                <input type="password" name="signup_password" placeholder="Create a password" required>
                <input type="password" name="signup_confirm_password" placeholder="Confirm your password" required>
                <input type="submit" class="button" value="Signup">
                <?php if (!empty($signup_error)) { echo '<p style="color:red;">' . $signup_error . '</p>'; } ?>
            </form>
            <div class="signup">
                <span class="signup">Already have an account?
                    <label for="check">Login</label>
                </span>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.search.includes('signup=success')) {
                document.getElementById('check').checked = false;
            }
        });
    </script>
</body>
</html>