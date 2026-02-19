<?php
// Hospital Dashboard (Subscription & Triage)
session_start();
if (!isset($_SESSION['user']) || ($_SESSION['user']['org_type'] ?? null) !== 'hospital') {
    header('Location: index.php');
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hospital Dashboard - FLEH</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Hospital Account Dashboard</h2>
        <p>Welcome, <?php echo htmlspecialchars($user['name'] ?? 'Hospital User'); ?>!</p>
        <p>Subscription Status: <strong>Active</strong></p>
        <p>Triage Integration: <strong>Enabled</strong></p>
        <!-- Placeholder for triage integration settings -->
        <ul>
            <li>Integration Endpoint: <code>https://api.fleh.com/triage/your-hospital</code></li>
            <li>Last Sync: 2026-02-20</li>
        </ul>
    </div>
</body>
</html>
