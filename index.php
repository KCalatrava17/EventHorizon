
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>FirstLight Event Horizon Login</title>
	<link rel="stylesheet" href="css/login.css">
</head>
<?php
$AUTH0_DOMAIN = 'YOUR_AUTH0_DOMAIN';
$AUTH0_CLIENT_ID = 'YOUR_AUTH0_CLIENT_ID';
$AUTH0_REDIRECT_URI = 'http://localhost/LaunchCloudLabs/EventHorizon/auth0-callback.php';
$AUTH0_AUDIENCE = 'YOUR_AUTH0_AUDIENCE'; // Optional, for API access

if ($AUTH0_DOMAIN === 'YOUR_AUTH0_DOMAIN' || $AUTH0_CLIENT_ID === 'YOUR_AUTH0_CLIENT_ID') {
	// Show a mock login form for demo/testing
	require_once __DIR__ . '/template/connect.php';
	session_start();
	$login_error = '';
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$org_type = $_POST['org_type'] ?? '';
		$username = trim($_POST['username'] ?? '');
		$password = $_POST['password'] ?? '';
		if ($username && $password && $org_type) {
			$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? AND account_status = "Active"');
			$stmt->execute([$username]);
			$user = $stmt->fetch();
			if ($user && password_verify($password, $user['password'])) {
				$_SESSION['user'] = [
					'name' => $user['first_name'] . ' ' . $user['last_name'],
					'org_type' => $org_type,
					'email' => $user['email'],
					'account_status' => $user['account_status']
				];
				if ($org_type === 'ems') {
					header('Location: dashboard-ems.php');
					exit;
				} elseif ($org_type === 'hospital') {
					header('Location: dashboard-hospital.php');
					exit;
				}
			} else {
				$login_error = 'Invalid username, password, or account status.';
			}
		} else {
			$login_error = 'Please fill in all fields.';
		}
	}
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>FirstLight Event Horizon Login</title>
		<link rel="stylesheet" href="css/login.css">
	</head>
	<body>
		   <div class="login-container">
			   <h2>Welcome to FirstLight Event Horizon</h2>
			   <?php if ($login_error): ?>
				   <div style="color: #e74c3c; margin-bottom: 16px; font-weight: bold;">
					   <?= htmlspecialchars($login_error) ?>
				   </div>
			   <?php endif; ?>
			   <div id="login-selection">
				   <select id="login-type-select" class="input-field" style="width:100%;">
					   <option value="">Select Login Type</option>
					   <option value="local">Local Login</option>
					   <option value="hospital">Hospital Account</option>
				   </select>
			   </div>
			   <form method="post" id="local-login-form" style="display:none;">
				   <input type="text" name="username" placeholder="Username" class="input-field input-field-top" required>
				   <input type="password" name="password" placeholder="Password" class="input-field" required>
				   <select name="org_type" id="org-type-select" class="input-field" required>
					   <option value="">Select Organization</option>
					   <option value="ems">EMS Agency</option>
					   <option value="hospital">Hospital System</option>
				   </select>
				   <button class="auth0-btn" type="submit">Login</button>
			   </form>
			   <div id="hospital-login-form" style="display:none;">
				   <form method="post" action="auth0-login.php">
					   <input type="hidden" name="org_type" value="hospital">
					   <button class="auth0-btn" type="submit">Login with Hospital Account</button>
				   </form>
			   </div>
		   </div>
		   <script src="js/login.js"></script>
		   <script>
		   document.addEventListener('DOMContentLoaded', function() {
			   const loginType = document.getElementById('login-type-select');
			   const localForm = document.getElementById('local-login-form');
			   const hospitalForm = document.getElementById('hospital-login-form');
			   loginType.addEventListener('change', function() {
				   if (loginType.value === 'local') {
					   localForm.style.display = 'block';
					   hospitalForm.style.display = 'none';
				   } else if (loginType.value === 'hospital') {
					   localForm.style.display = 'none';
					   hospitalForm.style.display = 'block';
				   } else {
					   localForm.style.display = 'none';
					   hospitalForm.style.display = 'none';
				   }
			   });
		   });
		   </script>
	</body>
	</html>
	<?php
} else {
	$authorize_url = "https://$AUTH0_DOMAIN/authorize?" . http_build_query([
		'response_type' => 'code',
		'client_id' => $AUTH0_CLIENT_ID,
		'redirect_uri' => $AUTH0_REDIRECT_URI,
		'scope' => 'openid profile email',
		'audience' => $AUTH0_AUDIENCE
	]);
	header('Location: ' . $authorize_url);
	exit;
}
