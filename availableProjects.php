<?php
$this_page = 'Available Projects';
require('includes/dbConnect.php');
require('includes/session.php');
require('includes/functions.php');
confirm_logged_in();

$userId = $_SESSION ['user_id'];
$project_set = find_all_available_projects_by_userId($userId);
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
                    <?php echo successMessage(); ?>
                    <?php echo message(); ?>
                    <table
                        class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Category</th>
                                <th align="center"><i class="glyphicon glyphicon-cog"></i></th>
                            </tr>
                        </thead>
                        <?php while ($project = mysqli_fetch_assoc($project_set)) {
                            ?>
                            <tr>
                                <td><?php echo $project['code'] ?></td>
                                <td><?php echo $project['name'] ?></td>
                                <td><?php echo $project['description'] ?></td>
                                <td><?php echo $project['start_date'] ?></td>
                                <td><?php echo $project['end_date'] ?></td>
                                <td><?php echo $project['category'] ?></td>
                                <td>
                                    <a href = "request_project.php?projectId=<?php echo urlencode($project["id"]) ?>"
                                       class = "btn btn-default" data-toggle = "tooltip" title = "Request">
                                        <i class = "glyphicon glyphicon-tasks"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
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