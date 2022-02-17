<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php
// Setting Language Variables
if (isset($_GET['lang']) && !empty($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];

    if (isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']) {
        echo "<script type='text/javascript'> location.reload(); </script>";
    }
}

if (isset($_SESSION['lang'])) {
    include "includes/languages/" . $_SESSION['lang'] . ".php";
} else {
    include "includes/languages/en.php";
}
?>

<?php
// PUSHER
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $error = [
        'username' => '',
        'email' => '',
        'password' => ''
    ];

    if (strlen($username) < 4) {
        $error['username'] = 'Username needs to be longer';
    }

    if ($username == '') {
        $error['username'] = 'Username cannot be empty';
    }

    if (usernameExists($username)) {
        $error['username'] = 'Username already exists, pick another username';
    }

    if ($email == '') {
        $error['email'] = 'Email cannot be empty';
    }

    if (emailExists($email)) {
        $error['email'] = 'Email already exists, <a href="index.php">Please login</a>';
    }

    if ($password == '') {
        $error['password'] = 'Password cannot be empty';
    }

    foreach ($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);
        }
    }

    if (empty($error)) {
        registerUser($username, $email, $password);
        loginUser($username, $password);
    }
}
?>

<!-- Navigation -->

<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <form method="get" class="navbar-form navbar-right" action="" id="language_form">
        <div class="form-group">
            <select name="lang" class="form-control" onchange="changeLanguage()">
                <option value="en" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') {
                    echo "selected";
                } ?>>English
                </option>
                <option value="es" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'es') {
                    echo "selected";
                } ?>>Spanish
                </option>
                <option value="hi" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'hi') {
                    echo "selected";
                } ?>>Hindi
                </option>
            </select>
        </div>
    </form>

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <h3><i class="fa fa-user fa-4x"></i></h3>
                            <h2 class="text-center"><?php echo _REGISTER; ?></h2>
                            <div class="panel-body">

                                <form id="register-form" role="form" autocomplete="off" class="form"
                                      action="registration.php" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i
                                                        class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input name="username" type="text" class="form-control"
                                                   placeholder="<?php echo _USERNAME; ?>" autocomplete="on"
                                                   value="<?php echo isset($username) ? $username : ''; ?>">
                                        </div>
                                        <p><?php echo isset($error['username']) ? $error['username'] : ''; ?></p>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i
                                                        class="glyphicon glyphicon-lock color-blue"></i></span>
                                            <input name="email" type="email" class="form-control"
                                                   placeholder="<?php echo _EMAIL; ?>" autocomplete="on"
                                                   value="<?php echo isset($email) ? $email : ''; ?>">
                                        </div>
                                        <p><?php echo isset($error['email']) ? $error['email'] : ''; ?></p>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i
                                                        class="glyphicon glyphicon-lock color-blue"></i></span>
                                            <input name="password" type="password" class="form-control"
                                                   placeholder="<?php echo _PASSWORD; ?>">
                                        </div>
                                        <p><?php echo isset($error['password']) ? $error['password'] : ''; ?></p>
                                    </div>

                                    <div class="form-group">
                                        <input name="register" class="btn btn-lg btn-primary btn-block"
                                               value="<?php echo _REGISTER; ?>"
                                               type="submit">
                                    </div>

                                    <div style="color: #919191; padding: 10px 20px;">
                                        <p>already registered? <a href="./login.php">click here</a></p>
                                    </div>

                                </form>
                            </div><!-- Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <script>
        function changeLanguage() {
            document.getElementById('language_form').submit();
        }
    </script>

    <?php include "includes/footer.php"; ?>

</div> <!-- /.container -->