<?php
$this_page = 'Projects';
require_once ("includes/session.php");
require_once ("includes/dbConnect.php");
require_once ("includes/functions.php");
require_once ("includes/validationFunctions.php");
confirm_admin_logged_in();

find_selected_project();

if (!$current_project) {
    // project Id was missing or invalid or
    // project couldn't be found in database
    redirect_to("adminProjects.php");
}

$code = $current_project ["code"];
$name = $current_project ["name"];
$description = $current_project ["description"];
$start_date = $current_project ["start_date"];
$end_date = $current_project ["end_date"];
$category_id = $current_project ["category_id"];
if (isset($_POST ["submit"])) {
    // validations
    $required_fields = array(
        "name",
        "description",
        "categoryId",
        "startDate",
        "endDate"
    );
    validate_presences($required_fields);

    $fields_with_max_lengths = array(
        "name" => 50
    );
    validate_max_lengths($fields_with_max_lengths);

    $id = $current_project ["id"];
//    $code = $_POST ['code'];
    $name = $_POST ['name'];
    $description = $_POST ['description'];
    $category_id = $_POST ['categoryId'];
    $start_date = $_POST ['startDate'];
    $end_date = $_POST ['endDate'];

    if (empty($errors)) {

        if (new datetime($end_date) < new datetime($start_date)) {
            $_SESSION ["message"] = "End date must be greater than Start date.";
        } else {
            $query = "UPDATE projects SET ";
//            $query .= "code = '{$code}', ";
            $query .= "name = '{$name}', ";
            $query .= "description = '{$description}', ";
            $query .= "start_date = '{$start_date}', ";
            $query .= "end_date = '{$end_date}' ";
            $query .= "WHERE id = {$id} ";
            $query .= "LIMIT 1";
            $result = mysqli_query($connection, $query);

            if ($result && mysqli_affected_rows($connection) >= 0) {
                $_SESSION ["successMessage"] = "Project updated successfully!";
                insert_in_history($id, "You edited the project");
                broadcast_notification($id, "Project having code: {$code} is updated.");
                redirect_to("adminProjects.php");
            } else {
                $_SESSION ["message"] = "Project update failed. (Project code must be unique)";
            }
        }
    }
}

$category_set = find_all_categories();
?>

<!DOCTYPE html>
<html lang="en">
    <?php require_once ("includes/layout/head.php"); ?>
    <body>
        <?php require_once ("includes/layout/nav.php"); ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <?php require_once ("includes/layout/sidebar.php"); ?>
                </div>
                <div class="col-md-10 col-md-offset-2 main">
                    <form
                        action="editProject.php?projectId=<?php echo urlencode($current_project["id"]); ?>"
                        method="post">
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Edit Project</h3>
                                </div>
                                <div class="panel-body">

                                    <?php echo message(); ?>
                                    <?php echo form_errors($errors); ?>

                                    <div class="form-group">
                                        <label for="code" class="control-label col-md-3">Project Code</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static"><?php echo $code ?></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label col-md-3">Project Name</label>
                                        <div class="col-md-6">
                                            <input type="text" name="name" class="form-control"
                                                   value="<?php echo $name ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="description" class="control-label col-md-3">Description</label>
                                        <div class="col-md-6">
                                            <textarea name="description" class="form-control">
                                                <?php echo htmlspecialchars($description); ?>
                                            </textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="categoryId" class="control-label col-md-3">Category</label>
                                        <div class="col-md-6">
                                            <select name="categoryId" class="form-control">
                                                <?php
                                                while ($category = mysqli_fetch_assoc($category_set)) {
                                                    echo "<option value=\"{$category['id']}\"";
                                                    if ($category ['id'] == $category_id) {
                                                        echo " selected='selected'";
                                                    }
                                                    echo ">{$category['category']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="startDate" class="control-label col-md-3">Project
                                            Start Date</label>
                                        <div class="col-md-6">
                                            <input type="date" name="startDate" class="form-control"
                                                   value="<?php echo $start_date ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="endDate" class="control-label col-md-3">Project End
                                            Date</label>
                                        <div class="col-md-6">
                                            <input type="date" name="endDate" class="form-control"
                                                   value="<?php echo $end_date ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-3 col-md-10">
                                            <input type="submit" name="submit" value="Update"
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