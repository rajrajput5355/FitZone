
<?php
require_once "auth.php";
requireAdmin();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $phone = $_POST["phone"];
    $plan = $_POST["plan"];

    $sql = "INSERT INTO members (name, age, phone, plan)
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "siss", $name, $age, $phone, $plan);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php#members");
        exit;
    } else {
        echo "Error adding member.";
    }
}
?>