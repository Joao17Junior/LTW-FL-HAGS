<?php include __DIR__ . '/../../signoutHeader.html';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="/_PROJ/assets/css/editProfile.css">
</head>
<body>
<div class="signup-container">
    <h2 class="form-title">Edit Profile</h2>
    <?php if (!empty($msg)) echo "<div style='color:green;'>$msg</div>"; ?>
    <form method="post">
        <label>Name:<br>
            <input type="text" name="name" value="<?php echo htmlspecialchars($userData['name']); ?>">
        </label><br>
        <label>Username:<br>
            <input type="text" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>">
        </label><br>
        <label>Email:<br>
            <input type="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>">
        </label><br>
        <label>New Password:<br>
            <input type="password" name="password" placeholder="Leave blank to keep current">
        </label><br>
        <button type="submit" name="update_profile">Update Profile</button>
    </form>
</div>

<div class="signup-container" style="margin-top:40px;">
    <h3>My Services</h3>
    <ul>
        <?php foreach ($myServices as $service): ?>
            <li><?php echo htmlspecialchars($service['title']); ?> - <?php echo htmlspecialchars($service['description']); ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.textContent = "Updating...";
});
</script>
</body>
</html>