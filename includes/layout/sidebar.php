<?php

function active($current_page) {
    global $this_page;
    if (isset($this_page) && $this_page == $current_page) {
        echo 'class="active"';
    }
}
?>

<?php if ($_SESSION ['role_id'] == 1) { ?>
    <ul class="nav nav-sidebar">
        <li <?php active('Dashboard') ?>><a href="admin.php">Dashboard</a></li>
        <li <?php active('Projects') ?>><a href="adminProjects.php">Projects</a></li>
        <li <?php active('Assign Project') ?>><a href="assignProject.php">Assign Project</a></li>
        <li <?php active('Assigned Projects') ?>><a href="assignProjects.php">View Assign Project</a></li>
        <li <?php active('Students') ?>><a href="adminUsers.php">Students</a></li>
        <li <?php active('Project Requests') ?>><a href="adminProjectRequests.php">Project Requests</a></li>
        <li <?php active('Show Uploads') ?>><a href="showUploads.php">Show Uploads</a></li>
        <li <?php active('Project Report') ?>><a href="report.php">Project Report</a></li>
        <li <?php active('Notifications') ?>><a href="notifications.php">Notifications</a></li>
    </ul>
<?php } else { ?>
    <ul class="nav nav-sidebar">
        <li <?php active('Dashboard') ?>><a href="index.php">Dashboard</a></li>
        <li <?php active('Available Projects') ?>><a href="availableProjects.php">Available Projects</a></li>
        <li <?php active('Assigned Projects') ?>><a href="assignedProjects.php">Assigned Projects</a></li>
        <li <?php active('Upload File') ?>><a href="studentUpload.php">Upload File</a></li>
        <li <?php active('Show Uploads') ?>><a href="uploads.php">Show Uploads</a></li>
        <li <?php active('Notifications') ?>><a href="notifications.php">Notifications</a></li>
    </ul>
<?php } ?>
