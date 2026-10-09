
<?php
require_once "auth.php";
requireAdmin();
require_once "db.php";

$id = (int)($_GET["id"] ?? 0);

$stmt = mysqli_prepare($conn, "SELECT * FROM members WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$member = mysqli_fetch_assoc($result);

if (!$member) {
    exit("Member not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $phone = $_POST["phone"];
    $plan = $_POST["plan"];

    $stmt = mysqli_prepare($conn,
        "UPDATE members SET name=?, age=?, phone=?, plan=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sissi", $name, $age, $phone, $plan, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php#members");
        exit;
    }

    echo "Error updating member.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Member - FitZone</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section class="section">
    <h2>Edit Member</h2>

    <form method="POST" class="member-form">
        <input name="name" value="<?= htmlspecialchars($member['name']) ?>" required>
        <input type="number" name="age" min="1" max="120"
               value="<?= (int)$member['age'] ?>" required>
        <input name="phone" value="<?= htmlspecialchars($member['phone']) ?>" required>

        <select name="plan" required>
            <option value="Monthly" <?= $member['plan']=="Monthly" ? "selected" : "" ?>>Monthly</option>
            <option value="Quarterly" <?= $member['plan']=="Quarterly" ? "selected" : "" ?>>Quarterly</option>
            <option value="Yearly" <?= $member['plan']=="Yearly" ? "selected" : "" ?>>Yearly</option>
        </select>

        <button class="btn" type="submit">Update Member</button>
    </form>

    <a href="index.php#members">Back to Home</a>
</section>
</body>
</html>