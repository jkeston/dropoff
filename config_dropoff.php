<?php
    // connect to database
    $dbh = mysql_connect("localhost", "db_username", "db_password") or die("Connection failed");
    mysql_select_db("unearthe_dropoff");

    // Set timezine
    date_default_timezone_set('America/Chicago');

    $user_date = date('Y-m-d');
    $course_status = array('active','pending','archived');
?>
