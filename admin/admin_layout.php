<?php
include 'connect.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location: ../login.php");
    exit;
}

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("location: ../index.php"); 
    exit;
}
if (isset($_GET['logout'])) {

    echo '<script type="text/javascript">setTimeout(function(){ window.location.href = "../index.php"; }, 0);</script>';
    session_destroy();
    exit; 
}


$sql_bookings = "SELECT COUNT(*) AS total_bookings FROM rentals";
$result_bookings = $conn->query($sql_bookings);
$total_bookings = $result_bookings->fetch_assoc()['total_bookings'];



$sql_vehicles = "SELECT COUNT(*) AS total_vehicles FROM vehicles";
$result_vehicles = $conn->query($sql_vehicles);
$total_vehicles = $result_vehicles->fetch_assoc()['total_vehicles'];


$sql_users = "SELECT COUNT(*) AS total_users FROM users";
$result_users = $conn->query($sql_users);
$total_users = $result_users->fetch_assoc()['total_users'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="icon" href="logo-dark.png" >
    <link rel="stylesheet" href="dashboard_styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="nav__logo">
                <a href="dashboard.php" class="logo">
                    <img src="logo-white.png" alt="logo" class="logo-white">
                    
                    <span>UDrive</span>
                </a>
            </div>
            
            <ul class="sidebar-nav">
                <li>
                    <a href="Dashboard.php" class="active">
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="manage_vehicles.php">
                        <span>Vehicles</span>
                    </a>
                </li>
                <li>
                    <a href="manage_users.php">
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="manage_bookings.php">
                        <span>Bookings</span>
                    </a>
                </li>
                <li>
                    <a href="../index.php">
                        <span>Main</span>
                    </a>
                </li>
                <li class="logout">
                    <a href="?logout=true">
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </aside>

        <div class="main-content">
            <header>
               
                <div class="user-wrapper">
                    <div>
                        <h4>Welcome, <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Admin'; ?></h4>
                        <small>Admin</small>
                    </div>
                </div>
            </header>

            <main>
                <div class="dashboard-cards">
        <div class="card">
            <div class="card-header">
                <h2>Total Bookings</h2>
            </div>
            <div class="card-body">
                <p><?php echo $total_bookings; ?></p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Total Vehicles</h2>
            </div>
            <div class="card-body">
                <p><?php echo $total_vehicles; ?></p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Number of Users</h2>
            </div>
            <div class="card-body">
                <p><?php echo $total_users; ?></p>
            </div>
        </div>
    </div>
                <div class="content-area">
                  
                    
                    