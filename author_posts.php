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
            if (isset($_GET['author'])) {
                $the_post_author = $_GET['author'];

                $query = "SELECT * FROM posts WHERE post_user = '$the_post_author' AND post_status = 'published' ";
                $select_all_posts_query = mysqli_query($connection, $query);

                if (!$select_all_posts_query) {
                    die('Query Failed : ' . mysqli_error($connection));
                }

                if (mysqli_num_rows($select_all_posts_query) == 0) {
                    echo "<h1 class='text-center'>No Post Found 😒</h1>";
                }
                ?>

                <h1 class="page-header">
                    By Author :
                    <small><?php echo ucwords($the_post_author); ?></small>
                </h1>

                <?php
                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'], 0, 200);
                    ?>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                    </h2>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php $date = date_create($post_date);
                        echo date_format($date, "F j, Y"); ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>"
                         alt="<?php echo $post_title; ?>">
                    <hr>
                    <p><?php echo $post_content; ?></p>

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