<?php
$this_page = 'Show Uploads';
require_once ("includes/session.php");
require_once ("includes/dbConnect.php");
require_once ("includes/functions.php");
require_once ("includes/validationFunctions.php");

confirm_admin_logged_in();

find_selected_project();

$userId = $_SESSION ['user_id'];
$projectId = 0;
if ($current_project) {
    $projectId = $current_project['id'];
    $upload_set = find_all_uploads_by_projectId($projectId);
}

if (isset($_POST["submit"])) {
    // validations
    $required_fields = array(
        "projectId"
    );
    validate_presences($required_fields);

    $projectId = $_POST['projectId'];

    if (empty($errors)) {
        $upload_set = find_all_uploads_by_projectId($projectId);
    }
}

$project_set = find_all_projects_by_userId($userId);
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
                    <h1 class="page-header"><?php echo $this_page ?></h1>

                    <form action="showUploads.php" method="post">

                        <?php echo message(); ?>
                        <?php echo form_errors($errors); ?>

                        <div class="form-group">
                            <label for="projectId" class="control-label col-md-2">Project</label>
                            <div class="col-md-4">
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
                            <div class="col-md-3">
                                <input type="submit" name="submit" value="Show" class="btn btn-primary" />
                            </div>
                        </div>

                    </form>

                    <br />
                    <br />
                    <br />

                    <div class="col-md-12">
                        <table
                            class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>File Size</th>
                                    <th align="center"><i class="glyphicon glyphicon-cog"></i></th>
                                </tr>
                            </thead>
                            <?php
                            if (isset($upload_set)) {
                                while ($upload = mysqli_fetch_assoc($upload_set)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $upload['file'] ?></td>
                                        <td><?php echo $upload['size'] ?></td>
                                        <td>
                                            <a href = "uploads/<?php echo $upload["file"] ?>"
                                               class = "btn btn-default" data-toggle = "tooltip" title = "Download File">
                                                <i class = "glyphicon glyphicon-file"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>
                    </div>

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