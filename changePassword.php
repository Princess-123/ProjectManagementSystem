<?php
$this_page = 'Change Password';
require_once ("includes/session.php");
require_once ("includes/dbConnect.php");
require_once ("includes/functions.php");
require_once ("includes/validationFunctions.php");

confirm_logged_in();

$userId = $_SESSION ['user_id'];
$current_user = find_user_by_id($userId);

if (isset($_POST ["submit"])) {
    // validations
    $required_fields = array(
        "oldPassword",
        "newPassword",
        "confirmPassword"
    );
    validate_presences($required_fields);

    $fields_with_max_lengths = array(
        "oldPassword" => 25,
        "newPassword" => 25,
        "confirmPassword" => 25
    );
    validate_max_lengths($fields_with_max_lengths);

    $id = $current_user["id"];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if (empty($errors)) {

        if ($current_user['password'] == $oldPassword) {
            if ($newPassword == $confirmPassword) {
                $query = "UPDATE users SET ";
                $query .= "password = '{$newPassword}' ";
                $query .= "WHERE id = {$id} ";
                $query .= "LIMIT 1";
                $result = mysqli_query($connection, $query);

                if ($result && mysqli_affected_rows($connection) >= 0) {
                    $_SESSION ["successMessage"] = "Password has been updated successfully!";
                } else {
                    $_SESSION ["message"] = "Unable to update password.";
                }
            } else {
                $_SESSION["message"] = "New Password and Confirm Password aren't matched";
            }
        } else {
            $_SESSION ["message"] = "Old password doesn't match.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <?php require_once ("includes/layout/head.php"); ?>
    <body>
        <?php require_once ("includes/layout/nav.php"); ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 sidebar">
                    <?php require_once ("includes/layout/sidebar.php"); ?>
                </div>
                <div class="col-md-10 col-md-offset-2 main">
                    <form
                        action="changePassword.php"
                        method="post">
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo $this_page; ?></h3>
                                </div>
                                <div class="panel-body">

                                    <?php echo successMessage(); ?>
                                    <?php echo message(); ?>
                                    <?php echo form_errors($errors); ?>

                                    <div class="form-group">
                                        <label for="oldPassword" class="control-label col-md-3">Old Password</label>
                                        <div class="col-md-6">
                                            <input type="password" name="oldPassword" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="newPassword" class="control-label col-md-3">New Password</label>
                                        <div class="col-md-6">
                                            <input type="password" name="newPassword" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirmPassword" class="control-label col-md-3">Confirm Password</label>
                                        <div class="col-md-6">
                                            <input type="password" name="confirmPassword" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-3 col-md-10">
                                            <input type="submit" name="submit" value="Change" class="btn btn-primary" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- jQuery-->
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <!-- bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>

<?php require_once("includes/dbClose.php"); ?>