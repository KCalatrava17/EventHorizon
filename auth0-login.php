<?php
// Auth0 configuration
$AUTH0_DOMAIN = 'YOUR_AUTH0_DOMAIN';
$AUTH0_CLIENT_ID = 'YOUR_AUTH0_CLIENT_ID';
$AUTH0_REDIRECT_URI = 'http://localhost/LaunchCloudLabs/EventHorizon/auth0-callback.php';
$AUTH0_AUDIENCE = 'YOUR_AUTH0_AUDIENCE'; // Optional, for API access


if ($AUTH0_DOMAIN === 'YOUR_AUTH0_DOMAIN' || $AUTH0_CLIENT_ID === 'YOUR_AUTH0_CLIENT_ID') {
    // Show a mock login form for demo/testing
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        $org_type = $_POST['org_type'] ?? '';
        $name = trim($_POST['name'] ?? 'Demo User');
        $_SESSION['user'] = [
            'name' => $name ?: 'Demo User',
            'org_type' => $org_type
        ];
        if ($org_type === 'ems') {
            header('Location: dashboard-ems.php');
            exit;
        } elseif ($org_type === 'hospital') {
            header('Location: dashboard-hospital.php');
            exit;
        }
    }
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Demo Login</title><link rel="stylesheet" href="css/login.css"></head><body><div class="login-container"><h2>Demo Login</h2><form method="post"><input type="text" name="name" placeholder="Your Name" style="width:100%;margin-bottom:12px;padding:10px;font-size:1em;" required><select name="org_type" style="width:100%;margin-bottom:16px;padding:10px;font-size:1em;" required><option value="">Select Organization Type</option><option value="ems">EMS Agency</option><option value="hospital">Hospital System</option></select><button class="auth0-btn" type="submit">Login (Demo)</button></form></div></body></html>';
    exit;
}

$authorize_url = "https://$AUTH0_DOMAIN/authorize?" . http_build_query([
    'response_type' => 'code',
    'client_id' => $AUTH0_CLIENT_ID,
    'redirect_uri' => $AUTH0_REDIRECT_URI,
    'scope' => 'openid profile email',
    'audience' => $AUTH0_AUDIENCE
]);

header('Location: ' . $authorize_url);
exit;
