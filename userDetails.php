<?php
$this_page = 'User Details';
require_once ("includes/session.php");
require_once ("includes/dbConnect.php");
require_once ("includes/functions.php");
require_once ("includes/validationFunctions.php");

confirm_logged_in();

$userId = $_SESSION ['user_id'];
$current_user = find_user_by_id($userId);

$username = $current_user['username'];
$firstname = $current_user['first_name'];
$lastname = $current_user['last_name'];
$email = $current_user['email'];
if (isset($_POST ["submit"])) {
    // validations
    $required_fields = array(
        "firstname",
        "lastname"
    );
    validate_presences($required_fields);

    $fields_with_max_lengths = array(
        "firstname" => 25,
        "lastname" => 25
    );
    validate_max_lengths($fields_with_max_lengths);

    $id = $current_user["id"];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    if (empty($errors)) {

        $query = "UPDATE users SET ";
        $query .= "first_name = '{$firstname}', ";
        $query .= "last_name = '{$lastname}' ";
        $query .= "WHERE id = {$id} ";
        $query .= "LIMIT 1";
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_affected_rows($connection) >= 0) {
            $_SESSION ["successMessage"] = "User Detail has been updated successfully!";
        } else {
            $_SESSION ["message"] = "User Detail update failed.";
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
                        action="userDetails.php"
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
                                        <label for="code" class="control-label col-md-3">Username</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static"><?php echo $username ?></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="firstname" class="control-label col-md-3">First Name</label>
                                        <div class="col-md-6">
                                            <input type="text" name="firstname" class="form-control"
                                                   value="<?php echo $firstname ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="lastname" class="control-label col-md-3">Last Name</label>
                                        <div class="col-md-6">
                                            <input type="text" name="lastname" class="form-control"
                                                   value="<?php echo $lastname ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="code" class="control-label col-md-3">Email</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static"><?php echo $email ?></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-3 col-md-10">
                                            <input type="submit" name="submit" value="Update"
                                                   class="btn btn-primary" />
                                        </div>
                                    </div>

                                    <div>
                                        <a href="changePassword.php">Change Password</a>
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