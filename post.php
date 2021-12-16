<?php include 'includes/db.php' ?>
<?php include 'includes/header.php' ?>

<!-- Navigation -->
<?php include 'includes/navigation.php' ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Post Content Column -->
        <div class="col-lg-8">
            <?php
            if (isset($_GET['p_id'])) {
                $the_post_id = $_GET['p_id'];

                $query = "SELECT * FROM posts WHERE post_id = {$the_post_id} ";
                $select_post_by_id = mysqli_query($connection, $query);

                if (!$select_post_by_id) {
                    die('Query Failed : ' . mysqli_error($connection));
                }

                while ($row = mysqli_fetch_assoc($select_post_by_id)) {
                    $post_id = $row['post_id'];
                    $post_author = $row['post_author'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_content = $row['post_content'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_date = $row['post_date'];
                }
            }
            ?>

            <!-- Blog Post -->

            <!-- Title -->
            <h1><?php echo $post_title; ?></h1>

            <!-- Author -->
            <p class="lead">
                by <a href="#"><?php echo $post_author; ?></a>
            </p>

            <hr>

            <!-- Date/Time -->
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php $date = date_create($post_date);
                echo date_format($date, "F j, Y"); ?></p>

            <hr>

            <!-- Preview Image -->
            <img class="img-responsive" src="./images/<?php echo $post_image; ?>" alt="">

            <hr>

            <!-- Post Content -->
            <p><?php echo $post_content; ?></p>

            <hr>

            <!-- Blog Comments -->
            <?php
            if (isset($_POST['create_comment'])) {
                $the_post_id = $_GET['p_id'];

                $comment_author = $_POST['comment_author'];
                $comment_email = $_POST['comment_email'];
                $comment_content = $_POST['comment_content'];

                $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                $query .= "VALUES ($the_post_id, '{$comment_author}','{$comment_email}','{$comment_content}', 'unapproved', now()) ";

                $create_comment_query = mysqli_query($connection, $query);
                if (!$create_comment_query) {
                    die('Query Failed' . mysqli_error($connection));
                }
            }
            ?>

            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="" method="post" role="form">
                    <div class="form-group">
                        <label for="comment_author">Name</label>
                        <input type="text" class="form-control" name="comment_author" id="comment_author">
                    </div>
                    <div class="form-group">
                        <label for="comment_email">Email</label>
                        <input type="email" class="form-control" name="comment_email" id="comment_email">
                    </div>
                    <div class="form-group">
                        <label for="comment_content">Comment</label>
                        <textarea class="form-control" rows="3" id="comment_content" name="comment_content"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                </form>
            </div>

            <hr>

            <!-- Posted Comments -->

            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">Start Bootstrap
                        <small>August 25, 2014 at 9:30 PM</small>
                    </h4>
                    comment
                </div>
            </div>

            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">Start Bootstrap
                        <small>August 25, 2014 at 9:30 PM</small>
                    </h4>
                    comment
                    <!-- Nested Comment -->
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="http://placehold.it/64x64" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">Nested Start Bootstrap
                                <small>August 25, 2014 at 9:30 PM</small>
                            </h4>
                            comment
                        </div>
                    </div>
                    <!-- End Nested Comment -->
                </div>
            </div>


        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sidebar.php' ?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include 'includes/footer.php' ?>
