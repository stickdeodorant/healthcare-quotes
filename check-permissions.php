<?php
// Permission check diagnostic
header('Content-Type: text/plain');

echo "=== Permission Diagnostic ===\n\n";

// Check if .htaccess exists and is readable
$htaccess = __DIR__ . '/.htaccess';
echo ".htaccess exists: " . (file_exists($htaccess) ? 'YES' : 'NO') . "\n";
echo ".htaccess readable: " . (is_readable($htaccess) ? 'YES' : 'NO') . "\n";

if (file_exists($htaccess)) {
    $perms = fileperms($htaccess);
    echo ".htaccess permissions: " . substr(sprintf('%o', $perms), -4) . "\n";
    echo ".htaccess owner: " . fileowner($htaccess) . "\n";
}

// Current directory info
echo "\nCurrent directory: " . __DIR__ . "\n";
echo "Web server user: " . get_current_user() . "\n";
echo "PHP running as: " . (function_exists('posix_getuid') ? posix_getuid() : 'unknown') . "\n";

// Check confirmations/.htaccess
$confirmHtaccess = __DIR__ . '/confirmations/.htaccess';
echo "\nconfirmations/.htaccess exists: " . (file_exists($confirmHtaccess) ? 'YES' : 'NO') . "\n";
if (file_exists($confirmHtaccess)) {
    echo "confirmations/.htaccess readable: " . (is_readable($confirmHtaccess) ? 'YES' : 'NO') . "\n";
    $perms = fileperms($confirmHtaccess);
    echo "confirmations/.htaccess permissions: " . substr(sprintf('%o', $perms), -4) . "\n";
}

echo "\n=== Apache Modules (if available) ===\n";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    echo "mod_rewrite: " . (in_array('mod_rewrite', $modules) ? 'ENABLED' : 'DISABLED') . "\n";
} else {
    echo "apache_get_modules() not available\n";
}
?>