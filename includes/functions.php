<?php

function redirect_to($new_location) {
    header("Location: " . $new_location);
    exit();
}

function mysql_escape($string) {
    global $connection;
    $escaped_string = mysqli_real_escape_string($connection, $string);
    return $escaped_string;
}

// Test if there was a query error.
function confirm_query($result_set) {
    if (!$result_set) {
        die("Database query failed.");
    }
}

function form_errors($errors = array()) {
    $output = "";
    if (!empty($errors)) {
        $output .= "<div class='alert alert-danger'>";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach ($errors as $key => $error) {
            $output .= "<li>";
            $output .= htmlentities($error);
            $output .= "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}

function find_user_by_username($username) {
    global $connection;
    // pretend from sql injection
    $safe_username = mysqli_real_escape_string($connection, $username);
    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE username = '{$safe_username}' ";
    $query .= "LIMIT 1";
    $user_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($user_set);
    if ($user = mysqli_fetch_assoc($user_set)) {
        return $user;
    } else {
        return null;
    }
}

function attempt_login($username, $password) {
    $user = find_user_by_username($username);
    if ($user) {
        // found user, new check password
        if ($password == $user ["password"]) {
            // password matches
            return $user;
        } else {
            // password does not match
            return false;
        }
    } else {
        // user not found
        return false;
    }
}

function logged_in() {
    return isset($_SESSION ['user_id']);
}

function admin_logged_in() {
    if (isset($_SESSION ['user_id']) &&
            isset($_SESSION ['role_id'])) {
        if ($_SESSION ['role_id'] == 1) {
            return true;
        }
    }
    return false;
}

function confirm_logged_in() {
    if (!logged_in()) {
        redirect_to("login.php");
    }
}

function confirm_admin_logged_in() {
    if (!admin_logged_in()) {
        redirect_to("login.php");
    }
}

function find_all_projects_by_userId($userId) {
    global $connection;
    $query = "SELECT projects.*,categories.category ";
    $query .= "FROM projects ";
    $query .= "INNER JOIN categories on projects.category_id=categories.id ";
    $query .= "WHERE projects.created_by=$userId";
    $project_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_set);
    return $project_set;
}

function find_all_categories() {
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM categories ";
    $category_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($category_set);
    return $category_set;
}

function find_selected_project() {
    global $current_project;
    if (isset($_GET ["projectId"])) {
        $current_project = find_project_by_id($_GET ["projectId"]);
    } else {
        $current_project = null;
    }
}

function find_project_by_id($projectId) {
    global $connection;
    // pretend from sql injection
    $safe_project_id = mysqli_real_escape_string($connection, $projectId);
    $query = "SELECT * ";
    $query .= "FROM projects ";
    $query .= "WHERE id = {$safe_project_id} ";
    $query .= "LIMIT 1";
    $project_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_set);
    if ($project = mysqli_fetch_assoc($project_set)) {
        return $project;
    } else {
        return null;
    }
}

function find_selected_project_assigned() {
    global $current_project_assigned;
    if (isset($_GET ["projectAssignedId"])) {
        $current_project_assigned = find_project_assigned_by_id($_GET ["projectAssignedId"]);
    } else {
        $current_project_assigned = null;
    }
}

function find_project_assigned_by_id($Id) {
    global $connection;
    // pretend from sql injection
    $safe_id = mysqli_real_escape_string($connection, $Id);
    $query = "SELECT * ";
    $query .= "FROM project_assigned ";
    $query .= "WHERE id = {$safe_id} ";
    $query .= "LIMIT 1";
    $project_assigned_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_assigned_set);
    if ($project_assigned = mysqli_fetch_assoc($project_assigned_set)) {
        return $project_assigned;
    } else {
        return null;
    }
}

function find_all_students() {
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE role_id=2";
    $user_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($user_set);
    return $user_set;
}

function find_selected_user() {
    global $current_user;
    if (isset($_GET ["userId"])) {
        $current_user = find_user_by_id($_GET ["userId"]);
    } else {
        $current_user = null;
    }
}

function find_user_by_id($userId) {
    global $connection;
    // pretend from sql injection
    $safe_user_id = mysqli_real_escape_string($connection, $userId);
    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE id = {$safe_user_id} ";
    $query .= "LIMIT 1";
    $user_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($user_set);
    if ($user = mysqli_fetch_assoc($user_set)) {
        return $user;
    } else {
        return null;
    }
}

function check_already_assign($projectId, $userId) {
    global $connection;
    // pretend from sql injection
    $safe_project_id = mysqli_real_escape_string($connection, $projectId);
    $safe_user_id = mysqli_real_escape_string($connection, $userId);
    $query = "SELECT * ";
    $query .= "FROM project_assigned ";
    $query .= "WHERE project_id = {$safe_project_id} ";
    $query .= "AND user_id = {$safe_user_id} ";
    $query .= "LIMIT 1";
    $project_assign_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_assign_set);
    if ($project_assign = mysqli_fetch_assoc($project_assign_set)) {
        return $project_assign;
    } else {
        return null;
    }
}

function find_all_assign_projects_by_userId($userId) {
    global $connection;
    $query = "SELECT p.*,c.category,u.username ";
    $query .= "FROM projects p ";
    $query .= "INNER JOIN categories c on p.category_id=c.id ";
    $query .= "INNER JOIN project_assigned pa on pa.project_id=p.id ";
    $query .= "INNER JOIN users u on pa.user_id=u.id ";
    $query .= "WHERE p.created_by=$userId AND pa.assigned_status_id>1";

    $project_assign_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_assign_set);
    return $project_assign_set;
}

function insert_in_history($project_id, $description) {
    global $connection;
    $safe_description = mysql_escape($description);
    $safe_project_id = mysql_escape($project_id);
    $query = "INSERT INTO project_history (description, project_id, date) ";
    $query .= "VALUES ('$safe_description',$safe_project_id, NOW())";
    $resultSet = $connection->query($query);
}

function insert_in_notification($project_id, $received_by, $text) {
    global $connection;
    $safe_project_id = mysql_escape($project_id);
    $sent_by = $_SESSION ['user_id'];
    $safe_received_by = mysql_escape($received_by);
    $safe_text = mysql_escape($text);
    $query = "INSERT INTO notifications (notification_text, project_id, sent_by, received_by, date) ";
    $query .= "VALUES ('$safe_text',$safe_project_id, $sent_by, $safe_received_by, NOW())";
    $resultSet = $connection->query($query);
}

function broadcast_notification($project_id, $text) {
    global $connection;
    $safe_project_id = mysql_escape($project_id);
    $sent_by = $_SESSION ['user_id'];
    $safe_text = mysql_escape($text);

    $user_set = find_all_students();

    while ($student = mysqli_fetch_assoc($user_set)) {
        $student_id = $student['id'];
        $query = "INSERT INTO notifications (notification_text, project_id, sent_by, received_by, date) ";
        $query .= "VALUES ('$safe_text',$safe_project_id, $sent_by, $student_id, NOW())";
        $resultSet = $connection->query($query);
    }
}

function find_all_notifications_by_receivedBy($userId) {
    global $connection;
    $query = "SELECT n.*, p.code ";
    $query .= "FROM notifications n ";
    $query .= "INNER JOIN projects p on n.project_id=p.id ";
    $query .= "WHERE received_by=$userId ";
    $query .= "ORDER BY date desc";
    $notification_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($notification_set);
    return $notification_set;
}

function find_all_project_requests_by_receivedBy($userId) {
    global $connection;
    $query = "SELECT pa.*, p.code, u.username ";
    $query .= "FROM project_assigned pa ";
    $query .= "INNER JOIN projects p on pa.project_id=p.id ";
    $query .= "INNER JOIN users u on pa.user_id=u.id ";
    $query .= "WHERE p.created_by=$userId AND pa.assigned_status_id=1";

    $project_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_set);
    return $project_set;
}

function find_notification_by_id($notificationId) {
    global $connection;
    // pretend from sql injection
    $safe_notification_id = mysqli_real_escape_string($connection, $notificationId);
    $query = "SELECT * ";
    $query .= "FROM notifications ";
    $query .= "WHERE id = {$safe_notification_id} ";
    $query .= "LIMIT 1";
    $notification_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($notification_set);
    if ($notification = mysqli_fetch_assoc($notification_set)) {
        return $notification;
    } else {
        return null;
    }
}

function find_all_available_projects_by_userId($userId) {
    global $connection;
    $query = "SELECT p.*, c.category ";
    $query .= "FROM projects p ";
    $query .= "INNER JOIN categories c on p.category_id=c.id ";
    $query .= "WHERE p.id NOT IN (SELECT project_id FROM project_assigned WHERE user_id = {$userId}) ";
    $project_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_set);
    return $project_set;
}

function find_all_assigned_projects_by_userId($userId) {
    global $connection;
    $query = "SELECT p.*, c.category, pa.id as project_assigned_id ";
    $query .= "FROM projects p ";
    $query .= "INNER JOIN categories c on p.category_id=c.id ";
    $query .= "INNER JOIN project_assigned pa on p.id=pa.project_id ";
    $query .= "WHERE pa.assigned_status_id > 1 AND pa.user_id = {$userId}";
    $project_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_set);
    return $project_set;
}

function find_assigned_project_by_id($projectAssignedId) {
    global $connection;
    // pretend from sql injection
    $safe_project_assigned_id = mysqli_real_escape_string($connection, $projectAssignedId);
    $query = "SELECT * ";
    $query .= "FROM project_assigned ";
    $query .= "WHERE id = {$safe_project_assigned_id} ";
    $query .= "LIMIT 1";
    $project_assigned_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_assigned_set);
    if ($project_assigned = mysqli_fetch_assoc($project_assigned_set)) {
        return $project_assigned;
    } else {
        return null;
    }
}

function find_all_uploads_by_userId($userId) {
    global $connection;
    $query = "SELECT p.code, p.name, p.description, u.file ";
    $query .= "FROM project_assigned pa ";
    $query .= "INNER JOIN uploads u on pa.id=u.project_assigned_id ";
    $query .= "INNER JOIN projects p on pa.project_id=p.id ";
    $query .= "WHERE pa.user_id=$userId AND pa.assigned_status_id>1";

    $project_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_set);
    return $project_set;
}

function find_all_uploads_by_projectId($projectId) {
    global $connection;
    $query = "SELECT u.* ";
    $query .= "FROM project_assigned pa ";
    $query .= "INNER JOIN uploads u on pa.id=u.project_assigned_id ";
    $query .= "INNER JOIN projects p on pa.project_id=p.id ";
    $query .= "WHERE pa.project_id=$projectId AND pa.assigned_status_id>1 ";

    $upload_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($upload_set);
    return $upload_set;
}

function find_all_project_history_by_projectId($projectId) {
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM project_history ";
    $query .= "WHERE project_id=$projectId ";
    $query .= "ORDER BY date ";

    $project_history_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_history_set);
    return $project_history_set;
}

function count_all_available_projects_by_userId($userId) {
    global $connection;
    $query = "SELECT count(*) AS Total ";
    $query .= "FROM projects ";
    $query .= "WHERE id NOT IN (SELECT project_id FROM project_assigned WHERE user_id = {$userId}) ";
    $project_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_set);
    if ($project = mysqli_fetch_assoc($project_set)) {
        return $project['Total'];
    } else {
        return 0;
    }
}

function count_all_assigned_projects_by_userId($userId) {
    global $connection;
    $query = "SELECT COUNT(*) AS Total ";
    $query .= "FROM project_assigned ";
    $query .= "WHERE user_id = {$userId} AND assigned_status_id > 1 ";
    $project_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_set);
    if ($project = mysqli_fetch_assoc($project_set)) {
        return $project['Total'];
    } else {
        return 0;
    }
}

function count_all_notifications_by_receivedBy($userId) {
    global $connection;
    $query = "SELECT COUNT(*) AS Total ";
    $query .= "FROM notifications ";
    $query .= "WHERE received_by=$userId ";
    $notification_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($notification_set);
    if ($notification = mysqli_fetch_assoc($notification_set)) {
        return $notification['Total'];
    } else {
        return 0;
    }
}

function count_all_projects_by_userId($userId) {
    global $connection;
    $query = "SELECT COUNT(*) AS Total ";
    $query .= "FROM projects ";
    $query .= "WHERE created_by=$userId";
    $project_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_set);
    if ($project = mysqli_fetch_assoc($project_set)) {
        return $project['Total'];
    } else {
        return 0;
    }
}

function count_all_assign_projects_by_userId($userId) {
    global $connection;
    $query = "SELECT COUNT(*) AS Total ";
    $query .= "FROM projects p ";
    $query .= "INNER JOIN project_assigned pa on pa.project_id=p.id ";
    $query .= "WHERE p.created_by=$userId AND pa.assigned_status_id>1";

    $project_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_set);
    if ($project = mysqli_fetch_assoc($project_set)) {
        return $project['Total'];
    } else {
        return 0;
    }
}

function count_all_project_requests_by_receivedBy($userId) {
    global $connection;
    $query = "SELECT COUNT(*) AS Total ";
    $query .= "FROM project_assigned pa ";
    $query .= "INNER JOIN projects p on pa.project_id=p.id ";
    $query .= "WHERE p.created_by=$userId AND pa.assigned_status_id=1";

    $project_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($project_set);
    if ($project = mysqli_fetch_assoc($project_set)) {
        return $project['Total'];
    } else {
        return 0;
    }
}

function count_all_students() {
    global $connection;
    $query = "SELECT COUNT(*) AS Total ";
    $query .= "FROM users ";
    $query .= "WHERE role_id=2";
    $user_set = mysqli_query($connection, $query);
    // Test if there was a query error.
    confirm_query($user_set);
    if ($user = mysqli_fetch_assoc($user_set)) {
        return $user['Total'];
    } else {
        return 0;
    }
}

?>