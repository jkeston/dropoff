<?php
	include('config_dropoff.php');
	include('check_student_auth.php');
	include('dropoff_classes.php');
	include('dropoff_control.php');
	include('display_courses.php');	
	include('display_submissions.php');
?>
<html>
<head>
	<title>Drop Off Project Submission System</title>
	<link rel="stylesheet" type="text/css" href="dropoff.css" />
	<script src="jquery-1.11.0.min.js"></script>
	<script type="text/javascript">
	<!--
	function checkApply(sel,rid) {
	  if (sel.options[sel.selectedIndex].value) {
	    // alert(rid);
	    document.status_form["change_list["+rid+"]"].checked = true;
	  }
	}
	function show_reqs() {
		var str = document.submission.project_id.value;
		var parts = str.split(',');
		if ( parts[1] == 'true' ) {
			// show text req
			$("#text_req").show();
		}
		else {
			$("#text_req").hide();
		}
		if ( parts[2] == 'true' ) {
			// show url req
			$("#url_req").show();
		}
		else {
			$("#url_req").hide();
		}
		if ( parts[3] == 'true' ) {
			// show file req
			$("#file_req").show();
		}
		else {
			$("#file_req").hide();
		}
	}
	-->
	</script>
	<style>
	#text_req {
		display: none;
	}
	#url_req {
		display: none;
	}
	#file_req {
		display: none;
	}
	</style>
</head>
<body>
	<h1>DropOff Student Dashboard</h1>
<p>
<?php
	echo "<span style=\"color:red\">$message</span>";
?>
&nbsp;
</p>

<!-- start enrollment form -->
<div id="leftcol">
<h3>Enroll in a Class</h3>
<form name="insert_dropoff_enrollment" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="task" value="insert_dropoff_enrollment" />
<table bgcolor="#aaaaaa" cellspacing="1" cellpadding="3">
<tr bgcolor="#ffffff">
<td>Student:</td>
<td>
	<?php echo $_SESSION['dropoff_fn'].' '.$_SESSION['dropoff_ln']; ?>
	<input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
</td>
</tr>
<tr bgcolor="#ffffff">
<td>Course to Enroll:</td>
<td>
	<select name="course_id">
<?php
	while( $row = mysql_fetch_array($doc) ) {	
		echo('<option value="'.$row['cid'].'">'.$row['course_title'].'</option>');
	}
	mysql_data_seek($doc,0);
?>
	</select>
</td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">Session of Enrollment:</td>
<input type="hidden" name="session_id" value="1" />
<td>
1</td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">Enrollment Status:</td>
<td>
<select name="status">
<option value="active">Active</option>
<option value="disabled">Disabled</option>
</select>
</td>
</tr>
<tr bgcolor="#ffffff">
<td colspan="2">
<input name="submit" value="Submit" type="submit" /></td>
</tr>
</table>
</form>
</div>
<!-- end of enrollment form -->

<!-- start submission form -->
<div id="rightcol">
<h3>Submit Project</h3>
<form name="submission" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
<input type="hidden" name="task" value="insert_dropoff_submission" />
<table bgcolor="#aaaaaa" cellspacing="1" cellpadding="3">
<tr bgcolor="#ffffff">
<td>Student:</td>
<td>
	<?php echo $_SESSION['dropoff_fn'].' '.$_SESSION['dropoff_ln']; ?>
	<input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
</td>
</tr>
<tr bgcolor="#ffffff">
<td>Project to submit:</td>
<td>
	<select name="project_id" onchange="show_reqs()">
		<option value="">--Choose Project--</option>
<?php
	while( list($k,$v) = each($project_options) ) {
		echo( $v[0] );
	}
?>
	</select>
</td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">Session of Enrollment:</td>
<input type="hidden" name="session_id" value="1" />
<td>
1</td>
</tr>
<tr bgcolor="#ffffff" id="text_req">
<td height="27">Submit Text:</td>
<td>
<textarea name="project_text"></textarea>
</td>
</tr>

<tr bgcolor="#ffffff" id="url_req">
<td height="27">Submit URL:</td>
<td>
<input type="text" placeholder="http://" name="project_url" />
</td>
</tr>

<tr bgcolor="#ffffff" id="file_req">
<td height="27">Submit File:</td>
<td>
<input type="file" name="project_file" />
</td>
</tr>

<tr bgcolor="#ffffff">
<td colspan="2">
<input name="submit" value="Submit" type="submit" /></td>
</tr>
</table>
</form>
</div>
<!-- end of submission form -->
<table border="1">
<tr>
<th>Project Title</th><th>Description</th><th>Submission Text</th><th>Submission Url</th><th>Submission File</th><th>Feedback</th><th>Grade</th><th>Points Earned</th><th>Submit Date</th>
</tr>
<?php echo $sub_tr; ?>
</table>
<p>&nbsp;</p>
<table>
<tr>
<th>Course Title</th><th>Author</th><th>Session Title</th><th>Description</th><th>Syllabus</th><th>Prerequisites</th><th>Start Date</th><th>End Date</th><th>Status</th>
</tr>
<?php echo $course_tr; ?>
</table>
</body>
</html>