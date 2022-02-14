<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>

<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';
require 'classes/Config.php';

if (!isset($_GET['forgot'])) {
    redirect('/php-cms/index');
}

if (ifItIsMethod('post')) {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));

        if (emailExists($email)) {
            $stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email = ? ");
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            /*
             * CONFIGURE PHPMailer
             * */
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = Config::SMTP_HOST;
                $mail->SMTPAuth = true;
                $mail->Username = Config::SMTP_USER;
                $mail->Password = Config::SMTP_PASSWORD;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = Config::SMTP_PORT;
                $mail->CharSet = 'UTF-8';

                //Recipients
                $mail->setFrom('php@cms.com');
                $mail->addAddress($email);     //Add a recipient

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset';
                $mail->Body = '
                                <p>Forgot Password?</p>
                                <p>Please click to reset your password.</p>
                                <a href="http://localhost/php-cms/reset.php?email=' . $email . '&token=' . $token . ' ">http://localhost/php-cms/reset.php?email=' . $email . '&token=' . $token . '</a>
                                ';

                // $mail->send();
                // echo '<p class="text-center">Message has been sent.</p>';

                if ($mail->send()) {
                    $emailSent = true;
                }

            } catch (Exception $e) {
                echo '<p class="text-center">Message could not be sent.</p>';
            }

        }
    }

}
?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <?php if (!isset($emailSent)) : ?>

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                            <span class="input-group-addon"><i
                                                        class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address"
                                                       class="form-control" type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block"
                                                   value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                            <?php else: ?>
                                <h2>Please check your email.</h2>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <?php include "includes/footer.php"; ?>

</div> <!-- /.container -->
