<?php
	include('config_dropoff.php');
	include('dropoff_classes.php');
	if ( count($_POST) > 0 ) {
		$u = new DOUser(0, $_POST['username'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $_POST['email_address'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['postal_code'], $_POST['country'], $_POST['notify'], $_POST['dob'], 'Student','pending');
		//
		if ( $u->insertDOUser() ) {
			$message = "Registration for $u->first_name $u->last_name was successful.";
			sleep(5);
			$u->sendValidationCode();
		}
		else {
			$message = "User not created. Insert failed.";
		}
		unset($u);		
	}
	if ( strlen($_GET['reg_code']) == 32 ) {
		// compare to registration code in database
		DOUser::activateDOUser($_GET['reg_code']);
	}
?>
<html>
<head>
	<title>News Project</title>
	<style type="text/css">
	body {
		font-family: Helvetica, Arial, san-serif;
	}
	</style>
</head>
<body>
<?php
	if (!empty($message)) {
		echo "$message<br />"; 
	}
?>
<h3>Register New User</h3>
<form name="register_dropoff_user" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
<table bgcolor="#aaaaaa" cellspacing="1" cellpadding="3">
<tr bgcolor="#ffffff">
<td>Username:</td>
<td>
<input name="username" type="text" value="<?php echo $u->username; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td>Password:</td>
<td>
<input name="password" type="password" value="" /></td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">First Name:</td>
<td>
<input name="first_name" type="text" value="<?php echo $u->first_name; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">Last Name:</td>
<td>
<input name="last_name" type="text" value="<?php echo $u->last_name; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">Email Address:</td>
<td>
<input name="email_address" type="text" value="<?php echo $u->email_address; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">Address:</td>
<td>
<input name="address" type="text" value="<?php echo $u->address; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">City:</td>
<td>
<input name="city" type="text" value="<?php echo $u->city; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">State:</td>
<td>
<input name="state" type="text" value="<?php echo $u->state; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">Postal:</td>
<td>
<input name="postal_code" type="text" value="<?php echo $u->postal_code; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">Country:</td>
<td>
<input name="country" type="text" value="<?php echo $u->country; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">Notify:</td>
<td>
<?php
	$nvalue[$u->notify] = ' checked="true"';
?>
Yes <input name="notify" type="radio" value="Yes"<?php echo $nvalue['Yes']; ?> />
No <input name="notify" type="radio" value="No"<?php echo $nvalue['No']; ?> />
</td>
</tr>
<tr bgcolor="#ffffff">
<td>Date of Birth:</td>
<td>
<input name="dob" type="text" value="<?php echo $u->dob; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td colspan="2">
<input name="submit" value="Submit" type="submit" /></td>
</tr>
</table>
</form><!-- close dropoff_users form-->
</body>
</html>