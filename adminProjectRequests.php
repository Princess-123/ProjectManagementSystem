<?php
$this_page = 'Project Requests';
require_once("includes/session.php");
require_once("includes/dbConnect.php");
require_once("includes/functions.php");
require_once("includes/validationFunctions.php");
confirm_admin_logged_in();

$userId = $_SESSION ['user_id'];
$project_set = find_all_project_requests_by_receivedBy($userId);
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
                                <th>Project Requested</th>
                                <th>Requested Username</th>
                                <th align="center"><i class="glyphicon glyphicon-cog"></i></th>
                            </tr>
                        </thead>
                        <?php while ($project = mysqli_fetch_assoc($project_set)) { ?>
                            <tr>
                                <td><?php echo $project['code'] ?></td>
                                <td><?php echo $project['username'] ?></td>
                                <td>
                                    <a href="accept_reject.php?projectAssignedId=<?php echo $project["id"] ?>&action=accept" 
                                       class="btn btn-success" data-toggle="tooltip" title="Accept">
                                        <i class="glyphicon glyphicon-ok"></i>
                                    </a>
                                    <a href="accept_reject.php?projectAssignedId=<?php echo $project["id"] ?>&action=reject" 
                                       class="btn btn-danger" data-toggle="tooltip" title="Reject">
                                        <i class="glyphicon glyphicon-remove"></i>
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