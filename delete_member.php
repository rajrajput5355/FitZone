
<?php
require_once "auth.php";
requireAdmin();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)($_POST["id"] ?? 0);

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM members WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

header("Location: index.php#members");
exit;
?>