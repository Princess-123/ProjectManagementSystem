<?php
$this_page = 'Projects';
require_once ("includes/session.php");
require_once ("includes/dbConnect.php");
require_once ("includes/functions.php");
require_once ("includes/validationFunctions.php");
confirm_admin_logged_in();

$code = "";
$name = "";
$description = "";
$start_date = "";
$end_date = "";
$category_id = "";
if (isset($_POST ["submit"])) {
    // validations
    $required_fields = array(
        "code",
        "name",
        "description",
        "categoryId",
        "startDate",
        "endDate"
    );
    validate_presences($required_fields);

    $fields_with_max_lengths = array(
        "code" => 10,
        "name" => 50
    );
    validate_max_lengths($fields_with_max_lengths);

    $code = $_POST ['code'];
    $name = $_POST ['name'];
    $description = $_POST ['description'];
    $category_id = $_POST ['categoryId'];
    $start_date = $_POST ['startDate'];
    $end_date = $_POST ['endDate'];
    $created_by = $_SESSION ['user_id'];

    if (empty($errors)) {

        if (new datetime($end_date) < new datetime($start_date)) {
            $_SESSION ["message"] = "End date must be greater than Start date.";
        } else {
            $sql = "INSERT INTO projects (code, name, description, start_date, end_date, category_id, created_by) ";
            $sql .= "VALUES ('$code','$name','$description','$start_date','$end_date','$category_id','$created_by')";
            $resultSet = $connection->query($sql);
            if ($resultSet) {
                $_SESSION ["successMessage"] = "Project created successfully!";
                $inserted_project_id = $connection->insert_id;
                insert_in_history($inserted_project_id, "You created the project");
                broadcast_notification($inserted_project_id, "New project with code: {$code} is created.");
                redirect_to("adminProjects.php");
            } else {
                $_SESSION ["message"] = "Unable to create project (Project code must be unique). Please try again later";
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
                <div class="col-md-2 sidebar">
                    <?php require_once ("includes/layout/sidebar.php"); ?>
                </div>
                <div class="col-md-10 col-md-offset-2 main">
                    <form action="createProject.php" method="post">
                        <div class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Create Project</h3>
                                </div>
                                <div class="panel-body">

                                    <?php echo successMessage(); ?>
                                    <?php echo message(); ?>
                                    <?php echo form_errors($errors); ?>

                                    <div class="form-group">
                                        <label for="code" class="control-label col-md-3">Project Code</label>
                                        <div class="col-md-6">
                                            <input type="text" name="code" class="form-control"
                                                   value="<?php echo $code ?>">
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
                                            <input type="submit" name="submit" value="Create"
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