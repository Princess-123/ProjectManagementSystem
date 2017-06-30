<?php
$this_page = 'Students';
require_once ("includes/session.php");
require_once ("includes/dbConnect.php");
require_once ("includes/functions.php");
confirm_admin_logged_in();

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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="panel-title"><?php echo $this_page ?></h3>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="createUser.php" class="btn btn-primary">Create New</a>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php echo successMessage(); ?>
                            <table
                                class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th align="center"><i class="glyphicon glyphicon-cog"></i></th>
                                    </tr>
                                </thead>
                                <?php while ($user = mysqli_fetch_assoc($user_set)) { ?>
                                    <tr>
                                        <td><?php echo $user['username'] ?></td>
                                        <td><?php echo $user['first_name'] ?></td>
                                        <td><?php echo $user['last_name'] ?></td>
                                        <td><?php echo $user['email'] ?></td>
                                        <td>
                                            <a href="editUser.php?userId=<?php echo urlencode($user["id"]) ?>" class="btn btn-default" data-toggle="tooltip" title="Edit">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </a>
                                            <a href="assignProject.php?userId=<?php echo urlencode($user["id"]) ?>" class="btn btn-warning" data-toggle="tooltip" title="Assign">
                                                <i class="glyphicon glyphicon-tasks"></i>
                                            </a>
                                        </td>
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