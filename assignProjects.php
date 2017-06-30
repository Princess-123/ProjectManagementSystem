<?php
$this_page = 'Assigned Projects';
require_once ("includes/session.php");
require_once ("includes/dbConnect.php");
require_once ("includes/functions.php");
confirm_admin_logged_in();

$userId = $_SESSION ['user_id'];
$project_set = find_all_assign_projects_by_userId($userId);
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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="panel-title"><?php echo $this_page ?></h3>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="assignProject.php" class="btn btn-primary">Create New</a>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php echo successMessage(); ?>
                            <table
                                class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Category</th>
                                        <th>Assigned To</th>
                                    </tr>
                                </thead>
                                <?php while ($project = mysqli_fetch_assoc($project_set)) { ?>
                                    <tr>
                                        <td><?php echo $project['code'] ?></td>
                                        <td><?php echo $project['name'] ?></td>
                                        <td><?php echo $project['start_date'] ?></td>
                                        <td><?php echo $project['end_date'] ?></td>
                                        <td><?php echo $project['category'] ?></td>
                                        <td><?php echo $project['username'] ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
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