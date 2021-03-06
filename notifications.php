<?php
$this_page = 'Notifications';
require('includes/dbConnect.php');
require('includes/session.php');
require('includes/functions.php');
confirm_logged_in();

$userId = $_SESSION ['user_id'];
$notification_set = find_all_notifications_by_receivedBy($userId);
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
                                <th>Project Code</th>
                                <th>Comments</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <?php while ($notification = mysqli_fetch_assoc($notification_set)) {
                            ?>
                            <tr>
                                <td><?php echo $notification['code'] ?></td>
                                <td><?php echo $notification['notification_text'] ?></td>
                                <td><?php echo $notification['date'] ?></td>
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