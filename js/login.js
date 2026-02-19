// Auth0 login logic for FLEH
window.addEventListener('DOMContentLoaded', function() {
    const loginBtn = document.getElementById('auth0-login-btn');
    if (loginBtn) {
        loginBtn.addEventListener('click', function() {
            window.location.href = 'auth0-login.php';
        });
    }
});
