```php
<?php
require_once "auth.php";
require_once "db.php";

$isAdmin = !empty($_SESSION["admin_id"]);

$result = mysqli_query(
    $conn,
    "SELECT * FROM members ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitZone - Gym & Fitness</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h2>Fit<span>Zone</span></h2>

    <nav>
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#amenities">Amenities</a>
        <a href="#plans">Plans</a>

        <?php if ($isAdmin) { ?>
            <a href="#members">Manage Members</a>
            <a href="logout.php">Logout</a>
        <?php } else { ?>
            <a href="login.php">Admin Login</a>
        <?php } ?>
    </nav>
</header>

<section class="hero" id="home">
    <div>
        <h1>BUILD YOUR<br>BEST VERSION</h1>
        <p>Your fitness journey starts here.</p>
        <a href="#members" class="btn">Join FitZone</a>
    </div>
</section>

<section id="about" class="section">
    <h2>Welcome to FitZone</h2>
    <p>
        FitZone helps you stay healthy, strong and active.
        We provide modern equipment and a friendly fitness environment.
    </p>
</section>

<section id="amenities" class="section">
    <h2>Our Amenities</h2>

    <div class="cards">
        <div class="card">
            <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=600" alt="Gym equipment">
            <h3>Modern Gym</h3>
            <p>Quality equipment for your workouts.</p>
        </div>

        <div class="card">
            <img src="https://images.unsplash.com/photo-1579758629938-03607ccdbaba?w=600" alt="Weight training">
            <h3>Weight Training</h3>
            <p>Build strength with regular training.</p>
        </div>

        <div class="card">
            <img src="https://images.unsplash.com/photo-1538805060514-97d9cc17730c?w=600" alt="Cardio workout">
            <h3>Cardio Zone</h3>
            <p>Improve stamina and fitness.</p>
        </div>
    </div>
</section>

<section id="plans" class="section">
    <h2>Membership Plans</h2>

    <div class="cards">
        <div class="card plan">
            <h3>Monthly</h3>
            <h2>₹999</h2>
            <p>One month membership</p>
        </div>

        <div class="card plan">
            <h3>Quarterly</h3>
            <h2>₹2499</h2>
            <p>Three month membership</p>
        </div>

        <div class="card plan">
            <h3>Yearly</h3>
            <h2>₹7999</h2>
            <p>Twelve month membership</p>
        </div>
    </div>
</section>

<section id="members" class="section">
    <h2>Member Management</h2>
    <p>Add and manage membership records below.</p>

    <?php if ($isAdmin) { ?>
        <h3>Add New Member</h3>

        <form action="add_member.php" method="POST" class="member-form">
            <input type="text" name="name" placeholder="Member Name" required>

            <input type="number" name="age" placeholder="Age"
                   min="1" max="120" required>

            <input type="tel" name="phone" placeholder="Phone Number" required>

            <select name="plan" required>
                <option value="">Select Plan</option>
                <option value="Monthly">Monthly</option>
                <option value="Quarterly">Quarterly</option>
                <option value="Yearly">Yearly</option>
            </select>

            <button type="submit" class="btn">Add Member</button>
        </form>
    <?php } ?>

    <div class="table-wrap">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Phone</th>
                <th>Plan</th>

                <?php if ($isAdmin) { ?>
                    <th>Actions</th>
                <?php } ?>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['plan']); ?></td>

                    <?php if ($isAdmin) { ?>
                        <td>
                            <a href="edit_member.php?id=<?php echo $row['id']; ?>">
                                Edit
                            </a>

                            <form action="delete_member.php" method="POST"
                                  onsubmit="return confirm('Delete this member?')"
                                  style="display:inline">

                                <input type="hidden" name="id"
                                       value="<?php echo $row['id']; ?>">

                                <button type="submit" class="delete-btn">
                                    Delete
                                </button>
                            </form>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
    </div>
</section>

<footer>
    <p>© 2026 FitZone Gym & Fitness Management</p>
</footer>

<script src="script.js"></script>
</body>
</html>
```
