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
	if (!empty($_GET['message'])) {
		echo "$_GET[message]<br />"; 
	}
?>
<form action="auth_user.php" method="post">
Username: <input type="text" name="username" /><br />
Password: <input type="password" name="password" /><br />
<input type="submit" value="login" />
</form>
</body>
</html>