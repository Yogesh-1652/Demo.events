<?php
// include 'partials/header.php';
include 'config/database.php';

//fetch current user from database
if (isset($_SESSION['user-id'])) {
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM user WHERE id =$id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}

// get back form data if form was invalid
$title = $_SESSION['add-events-data']['title'] ?? null;
$body = $_SESSION['add-events-data']['body'] ?? null;

// //delete form data session
unset($_SESSION['add-events-data']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Website</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>/css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;1,300&family=Montserrat:wght@300;400;500;600;700;800;900&family=Pacifico&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
        <div class="container nav_container">
            <a href="<?= ROOT_URL ?>user_index.php" class="nav_logo"> Bring the code</a>
            <ul class="nav_items">
                <li><a href="<?= ROOT_URL ?>user_index.php">Home</a></li>
                <li><a href="<?= ROOT_URL ?>add-events.php">Add Events</a></li>
                <?php if (isset($_SESSION['user-id'])) : ?>
                    <li class="nav_profile">
                        <div class="avatar">
                            <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>">
                        </div>
                        <ul>
                            <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php endif ?>
            </ul>
            <button id="open_nav-btn"><i class="uil uil-bars"></i></button>
            <button id="close_nav-btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>
    <!-- end of navbar -->

    <section class="form_section">
        <?php if (isset($_SESSION['add-events-success'])) : //shows if add event was successfully
        ?>
            <div class="alert_message success container">
                <p>
                    <?= $_SESSION['add-events-success'];
                    unset($_SESSION['add-events-success']);
                    ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['add-events'])) : ?>
            <div class="alert_message error">
                <p>
                    <?= $_SESSION['add-events'];
                    unset($_SESSION['add-events']);
                    ?>
                </p>
            </div>
        <?php endif ?>
        <div class="container form_section-container">
            <h2>Add Post</h2>
            <form action="<?= ROOT_URL ?>add-events-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="title" placeholder="Enter Event Name">
                <label for="datetime">Event Start Date & Time</label>
                <input type="datetime-local" name="startdate" placeholder="Select Event start Date">
                <label for="datetime">Event End Date & Time</label>
                <input type="datetime-local" name="enddate" placeholder="Select Event start Date">
                <select name="location">
                    <option value="none" selected disabled hidden>Select Location</option>
                    <option value="">Select City</option>
                    <option value="Ahemdabad">Ahemdabad</option>
                    <option value="GandhiNagar">GandhiNagar</option>
                    <option value="Surat">Surat</option>
                    <option value="Vadodara">Vadodara</option>
                    <option value="Delhi">Delhi</option>
                </select>
                <select name="category">
                    <option value="none" selected disabled hidden>Select category</option>
                    <option value="Music">Music</option>
                    <option value="Business">Business</option>
                    <option value="comedy">Comedy</option>
                    <option value="Movie_Promotion">Movie Promotion</option>
                    <option value="Exhibition">Exhibition</option>
                </select>
                <textarea name="body" rows="3" placeholder="Description"></textarea>
                <div class="form_control">
                    <label for="banner">Banner Image</label>
                    <input type="file" name="banner" id="banner" placeholder="Choose Banner">
                </div>
                <button type="submit" name="submit" class="btn">Add Events</button>
            </form>
        </div>
    </section>

    <script src="<?= ROOT_URL ?>/js/main.js"></script>
</body>
</head>