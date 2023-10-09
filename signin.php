<?php
include 'config/constant.php';

$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Website</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;1,300&family=Montserrat:wght@300;400;500;600;700;800;900&family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>
<section class="form_section">
    <div class="container form_section-container">
        <h2>Sign In</h2>
        <?php if(isset($_SESSION['signup-success'])) : ?>
            <div class="alert_message success">
            <p>
                <?= $_SESSION['signup-success'];
                unset($_SESSION['signup-success'])
                ?>
            </p>
            </div>
        <?php elseif(isset($_SESSION['signin'])) : ?>
        <div class="alert_message error">
            <p>
                <?= $_SESSION['signin'];
                unset($_SESSION['signin']);
                ?>
            </p>
        </div>
        <?php endif ?>
            <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
                <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="username or email">
                <input type="password" name="password" value="<?= $password ?>" placeholder="password">
                <button type="submit" name="submit" class="btn">Sign In</button>
                <small>Don't Have an Account? <a href="signup.php">Sign Up</a></small>
            </form>
    </div>
</section>
<script src="<?= ROOT_URL ?>js/main.js"></script>
</body>
</html>