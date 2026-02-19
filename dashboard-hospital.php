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
    <link rel="stylesheet" href="css/dashboard-hospital.css">
</head>
<body>
    <div class="hospital-dashboard">
        <div class="hospital-header">
            <div class="logo">🏥 Hospital Dashboard</div>
            <div class="user-info">
                Welcome, <?php echo htmlspecialchars($user['name'] ?? 'Hospital User'); ?>
                <span style="margin-left:18px; color:#1bbf4c; font-weight:bold;">
                    <?php echo htmlspecialchars($user['account_status'] ?? 'Active'); ?>
                </span>
                <a href="logout.php" style="margin-left:28px; color:#fff; background:#e74c3c; padding:7px 18px; border-radius:6px; text-decoration:none; font-weight:500; transition:background 0.2s;">Logout</a>
            </div>
        </div>
        <div class="hospital-main">
            <nav class="hospital-sidebar">
                <a href="#" class="active">Overview</a>
                <a href="#">Triage</a>
                <a href="#">Reports</a>
                <a href="#">Settings</a>
            </nav>
            <main class="hospital-content">
                <h2>Integration & Subscription</h2>
                <table class="integration-table">
                    <thead>
                        <tr>
                            <th>Integration Endpoint</th>
                            <th>Last Sync</th>
                            <th>Subscription Status</th>
                            <th>Triage Integration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>https://api.fleh.com/triage/your-hospital</code></td>
                            <td>2026-02-20</td>
                            <td class="status-enabled">Active</td>
                            <td class="status-enabled">Enabled</td>
                        </tr>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
</body>
</html>
