```php
<?php
session_start();
require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, username, password
         FROM admins
         WHERE username = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && password_verify($password, $admin["password"])) {

        session_regenerate_id(true);

        $_SESSION["admin_id"] = $admin["id"];
        $_SESSION["admin_username"] = $admin["username"];

        header("Location: index.php#members");
        exit;

    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitZone Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<section class="section">
    <h2>FitZone Admin Login</h2>

    <form method="POST" action="login.php" class="member-form">

        <input
            type="text"
            name="username"
            placeholder="Admin Username"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Admin Password"
            required
        >

        <button type="submit" class="btn">Login</button>

    </form>

    <?php if (!empty($error)) { ?>
        <p style="color: #ff795c;">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php } ?>

    <p><a href="index.php">Back to Home</a></p>
</section>

</body>
</html>
```
