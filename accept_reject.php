<?php

require('includes/dbConnect.php');
require('includes/session.php');
require('includes/functions.php');

confirm_admin_logged_in();

$message = '';

if (isset($_GET ["projectAssignedId"]) && isset($_GET ["action"])) {
    $project_assign = find_assigned_project_by_id($_GET ["projectAssignedId"]);

    if ($project_assign) {
        if ($_GET ["action"] == 'accept') {
            $query = "UPDATE project_assigned SET ";
            $query .= "assigned_status_id = 2 ";
            $query .= "WHERE id = {$project_assign['id']} ";
            $query .= "LIMIT 1";
            $result = mysqli_query($connection, $query);
            if ($result) {
                $project = find_project_by_id($project_assign['project_id']);
                $user = find_user_by_id($project_assign['user_id']);
                insert_in_history($project_assign['project_id'], "You accepted the project request for user having username: " . $user['username']);
                insert_in_notification($project_assign['project_id'], $project_assign['user_id'], "Project having code: " . $project['code'] . " has been assigned to you.");
                $message = "Project has been accepted successfully!";
            }
        } else if ($_GET ["action"] == 'reject') {
            $query = "DELETE FROM project_assigned ";
            $query .= "WHERE id = {$project_assign['id']} ";
            $result = mysqli_query($connection, $query);
            if ($result) {
                $project = find_project_by_id($project_assign['project_id']);
                $user = find_user_by_id($project_assign['user_id']);
                insert_in_history($project_assign['project_id'], "You rejected the project request for user having username: " . $user['username']);
                insert_in_notification($project_assign['project_id'], $project_assign['user_id'], "Project having code: " . $project['code'] . " has been deleted for you.");
                $message = "Project has been rejected successfully!";
            }
        }

        if (!empty($message)) {
            $_SESSION ["successMessage"] = $message;
        }
    }
}

if (empty($message)) {
    $_SESSION ["message"] = "Unable to request the project. Please try again later";
}

redirect_to("adminProjectRequests.php");

require_once("includes/dbClose.php");
?>