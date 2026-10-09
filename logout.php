```php
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear all session data
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the home page
header("Location: index.php");
exit;
?>
```
