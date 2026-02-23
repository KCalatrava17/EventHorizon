
<?php
// Enhanced OIDC callback handler for FLEH using OpenID-Connect-PHP
require_once __DIR__ . '/../config/load_env.php';
$config = require __DIR__ . '/../config/oidc.php';

// Use Composer autoload or direct require if not using Composer

$oidcLib = __DIR__ . '/vendor/OpenID-Connect-PHP/src/OpenIDConnectClient.php';
if (!file_exists($oidcLib)) {
    die('OIDC library not found. Please install https://github.com/jumbojett/OpenID-Connect-PHP in EventHorizon/vendor/OpenID-Connect-PHP/');
}
require_once $oidcLib;

session_start();

try {
    $oidc = new OpenIDConnectClient(
        $config['OIDC_PROVIDER_URL'],
        $config['OIDC_CLIENT_ID'],
        $config['OIDC_CLIENT_SECRET']
    );
    $oidc->setRedirectURL($config['OIDC_REDIRECT_URI']);
    $oidc->addScope('openid email profile');
    $oidc->authenticate();
    $userInfo = $oidc->requestUserInfo();

    // You may need to map claims depending on your IdP
    $org_type = $userInfo->org_type ?? null;
    $_SESSION['user'] = [
        'name' => $userInfo->name ?? ($userInfo->given_name ?? '') . ' ' . ($userInfo->family_name ?? ''),
        'email' => $userInfo->email ?? '',
        'org_type' => $org_type,
        'raw' => (array)$userInfo
    ];
    if ($org_type === 'ems') {
        header('Location: dashboard-ems.php');
        exit;
    } elseif ($org_type === 'hospital') {
        header('Location: dashboard-hospital.php');
        exit;
    } else {
        echo 'Unknown or missing organization type.';
        exit;
    }
} catch (Exception $e) {
    echo 'OIDC Authentication failed: ' . htmlspecialchars($e->getMessage());
    exit;
}
