<?php
require_once("includes/session.php");
require_once("includes/dbConnect.php");
require_once("includes/functions.php");
require_once("includes/validationFunctions.php");

$username = "";
if (isset($_POST["submit"])) {
    //validations
    $required_fields = array("username", "password");
    validate_presences($required_fields);

    if (empty($errors)) {

        $username = mysql_escape($_POST["username"]);
        $password = mysql_escape($_POST["password"]);
        //Attempt Login
        $found_user = attempt_login($username, $password);

        if ($found_user) {
            //Mark user as logged in
            $_SESSION["user_id"] = $found_user["id"];
            $_SESSION["username"] = $found_user["username"];
            $_SESSION["role_id"] = $found_user["role_id"];
            if ($found_user["role_id"] == 1) {
                redirect_to("admin.php");
            } else {
                redirect_to("index.php");
            }
        } else {
            $_SESSION["message"] = "Username/password not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <?php require_once ("includes/layout/head.php"); ?>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 main">
                    <form action="login.php" method="post">
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Login</h3>
                                </div>
                                <div class="panel-body">
                                    <?php echo successMessage(); ?>
                                    <?php echo message(); ?>
                                    <?php echo form_errors($errors); ?>

                                    <div class="form-group">
                                        <label for="username" class="control-label col-md-3">Username</label>
                                        <div class="col-md-6">
                                            <input type="text" name="username" class="form-control"
                                                   value="<?php echo $username ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="control-label col-md-3">Password</label>
                                        <div class="col-md-6">
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-3 col-md-10">
                                            <button class="btn btn-primary" type="submit" name="submit">
                                                <i class="glyphicon glyphicon-log-out"></i> Login
                                            </button>
                                            <a href="register.php" class="btn btn-default">
                                                <i class="glyphicon glyphicon-user"></i> Register
                                            </a>
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