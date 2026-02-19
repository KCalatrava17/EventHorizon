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
    <link rel="stylesheet" href="css/dashboard-ems.css">
</head>
<body>
    <div class="ems-dashboard">
        <div class="ems-header">
            <div class="logo">🚑 EMS Dashboard</div>
            <div class="user-info">
                Welcome, <?php echo htmlspecialchars($user['name'] ?? 'EMS User'); ?>
                <span style="margin-left:18px; color:#1bbf4c; font-weight:bold;">
                    <?php echo htmlspecialchars($user['account_status'] ?? 'Active'); ?>
                </span>
                <a href="logout.php" style="margin-left:28px; color:#fff; background:#e74c3c; padding:7px 18px; border-radius:6px; text-decoration:none; font-weight:500; transition:background 0.2s;">Logout</a>
            </div>
        </div>
        <div class="ems-main">
            <nav class="ems-sidebar">
                <a href="#" class="active">Fleet Overview</a>
                <a href="#">Dispatch</a>
                <a href="#">Reports</a>
                <a href="#">Settings</a>
            </nav>
            <main class="ems-content">
                <h2>Ambulance Fleet Status</h2>
                <table class="units-table">
                    <thead>
                        <tr>
                            <th>Unit</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Unit 4</td>
                            <td class="status-offline">Offline</td>
                            <td>Station 2</td>
                            <td>2026-02-20 08:12</td>
                        </tr>
                        <tr>
                            <td>Unit 7</td>
                            <td class="status-live">Live</td>
                            <td>On Route</td>
                            <td>2026-02-20 08:15</td>
                        </tr>
                        <tr>
                            <td>Unit 12</td>
                            <td class="status-live">Live</td>
                            <td>Hospital A</td>
                            <td>2026-02-20 08:10</td>
                        </tr>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
</body>
</html>
