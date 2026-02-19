<?php
// Quick script to show the hash for 'test123' using PASSWORD_DEFAULT
$hash = password_hash('test123', PASSWORD_DEFAULT);
echo $hash;
