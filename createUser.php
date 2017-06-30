<?php
$this_page = 'Students';
require_once ("includes/session.php");
require_once ("includes/dbConnect.php");
require_once ("includes/functions.php");
require_once ("includes/validationFunctions.php");
confirm_admin_logged_in();

$username = "";
$firstname = "";
$lastname = "";
$email = "";
if (isset($_POST["submit"])) {
    // validations
    $required_fields = array(
        "username",
        "firstname",
        "lastname",
        "email",
        "password",
        "confirmPassword"
    );
    validate_presences($required_fields);

    $fields_with_max_lengths = array(
        "username" => 25,
        "firstname" => 25,
        "lastname" => 25,
        "email" => 25,
        "password" => 25,
        "confirmPassword" => 25
    );
    validate_max_lengths($fields_with_max_lengths);

    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    
    if (empty($errors)) {
        if ($password == $confirmPassword) {
            $user = find_user_by_username($username);
            if ($user) {
                $_SESSION["message"] = "Username already taken";
            } else {
                $sql = "INSERT INTO users (first_name, last_name, username, email, password, role_id) ";
                $sql .= "VALUES ('$firstname','$lastname','$username','$email','$password',2)";
                $resultSet = $connection->query($sql);
                if ($resultSet) {
                    $_SESSION["successMessage"] = "Student account created successfully...";
                    redirect_to("adminUsers.php");
                } else {
                    $_SESSION["message"] = "Unable to create user account (username/email should be unique). Please try again later";
                }
            }
        } else {
            $_SESSION["message"] = "Password and Confirm Password aren't matched";
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
                    <form action="createUser.php" method="post">
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Create User</h3>
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
                                        <label for="email" class="control-label col-md-3">Email</label>
                                        <div class="col-md-6">
                                            <input type="email" name="email" class="form-control"
                                                   value="<?php echo $email ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="control-label col-md-3">Password</label>
                                        <div class="col-md-6">
                                            <input type="password" name="password" class="form-control">
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
                                            <input type="submit" name="submit" value="Create"
                                                   class="btn btn-primary" />
                                        </div>
                                    </div>

                                    <div>
                                        <a href="adminUsers.php">Back to Users</a>
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