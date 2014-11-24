<?
    // Script Name: auth_user.php
    // Connect to a MySQL database args(host,user,password)
    include('config_dropoff.php');

    // Build the database query
    $query = "SELECT * FROM dropoff_users WHERE ";
    $query .= "username = '".$_POST['username']."' AND ";
    $query .= "password = MD5('".$_POST['password']."') AND ";
    $query .= "status = 'active'";

    // echo "<pre>$query</pre>"; exit;

    // Execute the query and fetch the results
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);
    // check for a match
    if ( is_numeric($row['uid']) ) {
        // start PHP session
        session_set_cookie_params('3600',session_id());
        session_start();
        // Set session variables and display the add news form
        $_SESSION['dropoffuser'] = $row['username'];
        $_SESSION['dropoffpass'] = $row['password'];
        $_SESSION['dropoff_fn'] =  $row['first_name'];
        $_SESSION['dropoff_ln'] =  $row['last_name'];
        $_SESSION['dropofftype'] = $row['user_type'];
        // set a variable to store the user id
        // $user_id = $row[uid];
        if ( $row['user_type'] == 'Admin' || $row['user_type'] ==  'Instructor' ) {
            header( "Location: index.php?message=Login successful" );
            exit();
        }
        else if ( $row['user_type'] == 'Student' ) {
            header( "Location: student_index.php?message=Login successful" );
            exit();
        }
    }
    // Authentication failed. Destroy all humans.
    session_start();
    $_SESSION = array();
    setcookie(session_name(), '', time()-3600, session_id());
    @session_destroy();
    // Return to login.php and displays auth failed message
    header( "Location: login.php?message=Authorization failed. Please try again!" );
    exit();
?>