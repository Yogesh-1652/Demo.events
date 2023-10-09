<?php
require 'config/database.php';

//fetch current user from database
if (isset($_SESSION['user-id'])) {
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM user WHERE id =$id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}

//fetch events from event table
$query = "SELECT * FROM events ORDER BY date_time DESC";
$posts = mysqli_query($connection, $query);
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
            <a href="<?= ROOT_URL ?>user_index.php" class="nav_logo">AllEvents</a>
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

    <section class="contain">
        <form action="" method="GET" class="filter-search">
            <div class="abc">
                <input type="date" name="date" value="">
                <select name="category" id="category">
                    <option value="">Select City</option>
                    <option value="Ahemdabad">Ahemdabad</option>
                    <option value="GandhiNagar">GandhiNagar</option>
                    <option value="Surat">Surat</option>
                    <option value="Vadodara">Vadodara</option>
                    <option value="Delhi">Delhi</option>
                </select>
                <select name="category" id="category">
                    <option value="">Select Category</option>
                    <option value="Music">Music</option>
                    <option value="Business">Business</option>
                    <option value="Exhibition">Exhibition</option>
                    <option value="Comdey">Comedy</option>
                    <option value="Movie-Promotion">Movie Promotion</option>
                </select>
                <button type="submit" name="submit" class="btn sm">Filter</button>
                <a href="user_index.php" class="btn sm danger"> Reset</a>
            </div>
        </form>
    </section>

    <!-- end of navbar -->

    <section class="posts">
        <?php if (isset($_SESSION['add-events-success'])) : //shows if add event was successfully
        ?>
            <div class="alert_message success container">
                <p>
                    <?= $_SESSION['add-events-success'];
                    unset($_SESSION['add-events-success']);
                    ?>
                </p>
            </div>
        <?php endif ?>
        <div class="container posts_container">
            <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                <article class="post">
                    <div class="post_thumbnail">
                        <img src="./images/<?= $post['banner'] ?>" alt="">
                    </div>
                    <div class="post_info">
                        <?php
                        //fetch category from categories table using category_id of post
                        $category_id = $post['category'];
                        $category_query = "SELECT * FROM events";
                        $category_result = mysqli_query($connection, $category_query);
                        $category = mysqli_fetch_assoc($category_result);
                        ?>
                        <a href="<?= ROOT_URL ?>" class="category_button"><?= $post['category'] ?></a>
                        <a href="" class="category_button"><?= $post['location'] ?></a>
                        <h3 class="post_title"><a href="post.php"><?= $post['title'] ?></a></h3>
                        <p class="post_body">
                            <?= substr($post['body'], 0, 150) ?>...
                        </p>
                        <div class="post_author">
                            <small><?= date("d M, Y - h:i A", strtotime($post['startdate'])) ?></small>-
                            <small><?= date("d M, Y - h:i A", strtotime($post['enddate'])) ?></small>
                        </div>
                    </div>
                </article>
            <?php endwhile ?>
        </div>
    </section>

    <section class="category_buttons">
        <div class="container category_button-container">
            <?php
            $all_categories_query = "SELECT category FROM events";
            $all_categories = mysqli_query($connection, $all_categories_query);
            ?>
            <?php while ($category = mysqli_fetch_assoc($all_categories)) : ?>
                <a href="" class="category_button"><?= $category['category'] ?></a>
            <?php endwhile ?>
        </div>
    </section>


    <script src="<?= ROOT_URL ?>/js/main.js"></script>
    <?php include 'partials/footer.php' ?>
</body>
</head>