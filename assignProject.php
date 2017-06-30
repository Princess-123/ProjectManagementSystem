<?php
$this_page = 'Assign Project';
require_once ("includes/session.php");
require_once ("includes/dbConnect.php");
require_once ("includes/functions.php");
require_once ("includes/validationFunctions.php");
confirm_admin_logged_in();

find_selected_project();
find_selected_user();

$projectId = 0;
$userId = 0;
if ($current_project) {
    $projectId = $current_project['id'];
}

if ($current_user) {
    $userId = $current_user['id'];
}

if (isset($_POST["submit"])) {
    // validations
    $required_fields = array(
        "projectId",
        "userId"
    );
    validate_presences($required_fields);

    $projectId = $_POST['projectId'];
    $userId = $_POST['userId'];

    if (empty($errors)) {
        $project_assign = check_already_assign($projectId, $userId);
        if ($project_assign) {
            $_SESSION["message"] = "User is already assign to that project";
        } else {
            $sql = "INSERT INTO project_assigned (project_id, user_id, assigned_status_id) ";
            $sql .= "VALUES ($projectId, $userId, 2)";
            $resultSet = $connection->query($sql);
            if ($resultSet) {
                $_SESSION["successMessage"] = "Student has been assigned to the project successfully...";
                $assigned_user = find_user_by_id($userId);
                $assigned_project = find_project_by_id($projectId);
                insert_in_history($projectId, "You assigned the project to user with username: " . $assigned_user['username']);
                insert_in_notification($projectId, $userId, "You has been assigned to the project having code: " . $assigned_project['code']);
                redirect_to("assignProjects.php");
            } else {
                $_SESSION["message"] = "Unable to assign user to project. Please try again later";
            }
        }
    }
}

$project_set = find_all_projects_by_userId($_SESSION ['user_id']);
$user_set = find_all_students();
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
                    <form action="assignProject.php?projectId=<?php echo $projectId ?>"
                          method="post">
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo $this_page ?></h3>
                                </div>
                                <div class="panel-body">

                                    <?php echo message(); ?>
                                    <?php echo form_errors($errors); ?>


                                    <div class="form-group">
                                        <label for="projectId" class="control-label col-md-3">Project</label>
                                        <div class="col-md-6">
                                            <select name="projectId" class="form-control">
                                                <?php
                                                while ($project = mysqli_fetch_assoc($project_set)) {
                                                    echo "<option value=\"{$project['id']}\"";
                                                    if ($project ['id'] == $projectId) {
                                                        echo " selected='selected'";
                                                    }
                                                    echo ">{$project['code']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="userId" class="control-label col-md-3">User</label>
                                        <div class="col-md-6">
                                            <select name="userId" class="form-control">
                                                <?php
                                                while ($user = mysqli_fetch_assoc($user_set)) {
                                                    echo "<option value=\"{$user['id']}\"";
                                                    if ($user ['id'] == $userId) {
                                                        echo " selected='selected'";
                                                    }
                                                    echo ">{$user['username']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-3 col-md-10">
                                            <input type="submit" name="submit" value="Assign"
                                                   class="btn btn-primary" />
                                        </div>
                                    </div>

                                    <div>
                                        <a href="adminProjects.php">Back to Projects</a>
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