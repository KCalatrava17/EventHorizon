<?php
// Auth0 callback handler for FLEH
$AUTH0_DOMAIN = 'YOUR_AUTH0_DOMAIN';
$AUTH0_CLIENT_ID = 'YOUR_AUTH0_CLIENT_ID';
$AUTH0_CLIENT_SECRET = 'YOUR_AUTH0_CLIENT_SECRET';
$AUTH0_REDIRECT_URI = 'http://localhost/LaunchCloudLabs/EventHorizon/auth0-callback.php';

if (!isset($_GET['code'])) {
    die('Authorization code not found.');
}

$code = $_GET['code'];

// Exchange code for tokens
$token_url = "https://$AUTH0_DOMAIN/oauth/token";
$data = [
    'grant_type' => 'authorization_code',
    'client_id' => $AUTH0_CLIENT_ID,
    'client_secret' => $AUTH0_CLIENT_SECRET,
    'code' => $code,
    'redirect_uri' => $AUTH0_REDIRECT_URI
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ],
];
$context  = stream_context_create($options);
$result = file_get_contents($token_url, false, $context);
if ($result === FALSE) {
    die('Error fetching token.');
}
$tokens = json_decode($result, true);

// Decode ID token to get user info
$id_token = $tokens['id_token'];
$jwt_parts = explode('.', $id_token);
$payload = json_decode(base64_decode(strtr($jwt_parts[1], '-_', '+/')), true);

// Determine user type (assume 'org_type' custom claim)
$user_type = $payload['org_type'] ?? null;

session_start();
$_SESSION['user'] = $payload;

if ($user_type === 'ems') {
    header('Location: dashboard-ems.php');
} elseif ($user_type === 'hospital') {
    header('Location: dashboard-hospital.php');
} else {
    echo 'Unknown user type.';
}
exit;
