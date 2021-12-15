<?php include 'includes/db.php' ?>
<?php include 'includes/header.php' ?>

    <!-- Navigation -->
<?php include 'includes/navigation.php' ?>

    <!-- Page Content -->
    <div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php
            if (isset($_GET['category'])) {
                $the_category_id = $_GET['category'];

                $query = "SELECT * FROM posts WHERE post_category_id = {$the_category_id} ";
                $select_all_posts_query = mysqli_query($connection, $query);

                if (!$select_all_posts_query) {
                    die('Query Failed : ' . mysqli_error($connection));
                }

                if (mysqli_num_rows($select_all_posts_query) == 0) {
                    echo "<h1>No Post Found 😒</h1>";
                }

                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
                    ?>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $post_author; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php $date = date_create($post_date);
                        echo date_format($date, "F j, Y"); ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>"
                         alt="<?php echo $post_title; ?>">
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span
                                class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>

                    <?php
                }
            }
            ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sidebar.php' ?>

    </div>
    <!-- /.row -->

    <hr>

<?php include 'includes/footer.php' ?>