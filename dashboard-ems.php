<?php
// EMS Dashboard (Fleet Management)
session_start();
if (!isset($_SESSION['user']) || ($_SESSION['user']['org_type'] ?? null) !== 'ems') {
    header('Location: index.php');
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EMS Dashboard - FLEH</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>EMS Fleet Dashboard</h2>
        <p>Welcome, <?php echo htmlspecialchars($user['name'] ?? 'EMS User'); ?>!</p>
        <p>Account Status: <strong>Active</strong></p>
        <p>Manage your ambulance units below:</p>
        <!-- Placeholder for fleet management UI -->
        <ul>
            <li>Unit 4: <span style="color: red;">Offline</span></li>
            <li>Unit 7: <span style="color: green;">Live</span></li>
        </ul>
    </div>
</body>
</html>
