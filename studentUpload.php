<?php
$this_page = 'Upload File';
require_once ("includes/session.php");
require_once ("includes/dbConnect.php");
require_once ("includes/functions.php");
require_once ("includes/validationFunctions.php");

confirm_logged_in();

$userId = $_SESSION['user_id'];

find_selected_project_assigned();

$projectId = 0;
$project_assigned_id = 0;
if ($current_project_assigned) {
    $project_assigned_id = $current_project_assigned['id'];
    $projectId = $current_project_assigned['project_id'];
}

if (isset($_POST["submit"])) {
    // validations
    $required_fields = array(
        "projectId"
    );
    validate_presences($required_fields);

    if (empty($errors)) {

        $projectId = $_POST['projectId'];

        $project_assigned_set = check_already_assign($projectId, $userId);
        $project_assigned_id = $project_assigned_set['id'];

        if (!$_FILES['file']['error']) {

            $file = $_FILES['file']['name'];
            $file_loc = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $folder = "uploads/";

            $new_file_name = 'file_' . date('Y-m-d-H-i-s') . '_' . uniqid() . '_' . $file;

            move_uploaded_file($file_loc, $folder . $new_file_name);

            $sql = "INSERT INTO uploads (project_assigned_id, file, size) ";
            $sql .= "VALUES ($project_assigned_id, '$new_file_name', $file_size)";

            $resultSet = $connection->query($sql);
            if ($resultSet) {
                $_SESSION["successMessage"] = "File has been uploaded for the project successfully...";
                $assigned_user = find_user_by_id($userId);
                $assigned_project = find_project_by_id($projectId);
                insert_in_history($projectId, $assigned_user['username'] . ' has upload the file for the project having code: ' . $assigned_project['code']);
                insert_in_notification($projectId, $assigned_project['created_by'], $assigned_user['username'] . ' has upload the file');
                redirect_to("uploads.php");
            } else {
                $_SESSION["message"] = "Unable to upload file to project. Please try again later";
            }
        } else {
            $_SESSION["message"] = 'Ooops!  Your upload triggered the following error:  ' . $_FILES['photo']['error'];
        }
    }
}

$project_set = find_all_assigned_projects_by_userId($userId);
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
                    <form action="studentUpload.php?projectAssignedId=<?php echo $project_assigned_id ?>"
                          method="post"
                          enctype="multipart/form-data">
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
                                        <label for="file" class="control-label col-md-3">File</label>
                                        <div class="col-md-6">
                                            <input type="file" name="file" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-3 col-md-10">
                                            <input type="submit" name="submit" value="Upload"
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

<?php require_once("includes/dbClose.php"); ?>