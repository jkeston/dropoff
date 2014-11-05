<?
	session_start();
	setcookie(session_name(),session_id(),time()+3600);
	//echo "|$_SESSION[dropoffuser]|$_SESSION[dropoffpass]|"; exit;
	if ( !empty($_SESSION['dropoffuser']) && !empty($_SESSION['dropoffpass']) ) {
		// Build the database query
		$query = "SELECT * FROM dropoff_users WHERE ";
		$query .= "username = '".$_SESSION['dropoffuser']."' AND ";
		$query .= "password = '".$_SESSION['dropoffpass']."' AND ";
		$query .= "status = 'active'";

		// Execute the query and fetch the results
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		// check for a match
		if ( !is_numeric($row['uid']) ) {
			$_SESSION = array();
			setcookie(session_name(), '', time()-3600, session_id());
			@session_destroy();
			exit();
		}
		// set a variable to store the user id
		$user_id = $row['uid'];
  }
	else {
		$_SESSION = array();
		setcookie(session_name(), '', time()-3600, session_id());
		@session_destroy();
		header("Location: login.php?message=You must login to do that");
		exit();
	}
?>