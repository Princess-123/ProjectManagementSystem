<?php

//1. Create a database connection
define("DB_SERVER", localhost);
define("DB_USER", root);
define("DB_PASS", mysql);
define("DB_NAME", project_system_db);
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
//Test if connection succeeded
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
}
?>