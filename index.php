<?php
include 'partials/header.php';

// require 'config/database.php';

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

<section class="contain">
    <form action="" method="GET" class="filter-search">
        <div class="abc">
                <input type="date" name="date" value="">
                <select name="category" id="category">
                    <option value="">Select Category</option>
                    <option value="Ahemdabad">Ahemdabad</option>
                    <option value="GandhiNagar">GandhiNagar</option>
                    <option value="Surat">Surat</option>
                    <option value="Vadodara">Vadodara</option>
                    <option value="Delhi">Delhi</option>
                </select>
                <button type="submit" name="submit" class="btn sm">Filter</button>
                <a href="index.php" class="btn sm danger"> Reset</a>
                </div>
            </form>
    </section>

<section class="posts">
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
                    $category_query = "SELECT * FROM events ORDER BY date_time DESC";
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

<?php include 'partials/footer.php'; ?>