<?php
if (isset($_GET['uid'])) {
    $the_user_id = $_GET['uid'];

    $query = "SELECT * FROM users WHERE user_id = $the_user_id ";
    $select_user_by_id = mysqli_query($connection, $query);
    confirmQuery($select_user_by_id);

    while ($row = mysqli_fetch_assoc($select_user_by_id)) {
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }

    if (isset($_POST['update_user'])) {
        $username = $_POST['username'];
        $user_password = $_POST['user_password'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];

        $user_image = $_FILES['user_image']['name'];
        $user_image_temp = $_FILES['user_image']['tmp_name'];

        $user_role = $_POST['user_role'];

        move_uploaded_file($user_image_temp, "../images/$user_image");

        if (empty($user_image)) {
            $query = "SELECT * FROM users WHERE user_id = $the_user_id ";
            $select_image = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_image)) {
                $user_image = $row['user_image'];
            }
        }

        $query = "UPDATE users SET ";
        $query .= "username = '$username', ";
        $query .= "user_password = '$user_password', ";
        $query .= "user_firstname = '$user_firstname', ";
        $query .= "user_lastname = '$user_lastname', ";
        $query .= "user_email = '$user_email', ";
        $query .= "user_image = '$user_image', ";
        $query .= "user_role = '$user_role' ";
        $query .= "WHERE user_id = $the_user_id ";

        $update_user = mysqli_query($connection, $query);

        confirmQuery($update_user);

        header("Location: users.php");
    }
}


?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" class="form-control" name="username" value="<?php echo $username; ?>">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" id="user_password" class="form-control" name="user_password"
               value="<?php echo $user_password; ?>">
    </div>

    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" id="user_firstname" class="form-control" name="user_firstname"
               value="<?php echo $user_firstname; ?>">
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" id="user_lastname" class="form-control" name="user_lastname"
               value="<?php echo $user_lastname; ?>">
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" id="user_email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
    </div>

    <div class="form-group">
        <label for="user_image">Image</label>
        <br>
        <img width="40" src="../images/<?php echo $user_image ?>" class="img-thumbnail img-rounded">
        <p></p>
        <input type="file" id="user_image" name="user_image">
    </div>


    <div class="form-group">
        <label for="user_role">Role</label>
        <select name="user_role" id="user_role" class="form-control">
            <option value="<?php echo $user_role ?>"><?php echo ucfirst($user_role); ?></option>
            <?php
            if ($user_role == 'admin') {
                echo "<option value='subscriber'>Subscriber</option>";
            } else {
                echo "<option value='admin'>Admin</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
    </div>
</form>