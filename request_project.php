<?php

require('includes/session.php');
require('includes/dbConnect.php');
require('includes/functions.php');

confirm_logged_in();

$message = '';

if (isset($_GET ["projectId"])) {
    $userId = $_SESSION ['user_id'];
    $projectId = $_GET ['projectId'];

    $user = find_user_by_id($userId);
    $project = find_project_by_id($projectId);

    // add to assign table
    $sql = "INSERT INTO project_assigned (project_id, user_id, assigned_status_id) ";
    $sql .= "VALUES ($projectId, $userId, 1)";
    $resultSet = $connection->query($sql);

    if ($resultSet) {
        insert_in_history($projectId, "User having username: " . $user['username'] . " has requested the project.");
//        insert_in_notification($projectId, $project['created_by'], "Project having code: " . $project['code'] . " is requested by user having username: " . $user['username']);
        $message = "Project has been requested successfully!";
        $_SESSION ["successMessage"] = $message;
    }
}

if (empty($message)) {
    $_SESSION ["message"] = "Unable to request the project. Please try again later";
}

redirect_to("availableProjects.php");
require_once("includes/dbClose.php");
?>