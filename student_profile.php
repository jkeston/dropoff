<?php
	include('config_dropoff.php');
	include('check_student_auth.php');
	include('dropoff_classes.php');
	include('dropoff_control.php');
	include('display_courses.php');
	include('display_submissions.php');
	$std = DOuser::getDOUser($_GET['uid']);
?>
<html>
<head>
	<title>Drop Off Project Submission System</title>
	<link rel="stylesheet" type="text/css" href="dropoff.css" />
	<script src="jquery-1.11.0.min.js"></script>
</head>
<body>
	<h1>DropOff Student Profile for <?php echo $std->first_name." ".$std->last_name; ?></h1>
<p>
<?php
	echo "<span style=\"color:red\">$message</span>";
?>
&nbsp;
</p>
<table border="1">
<tr>
<th>Project Title</th><th>Description</th><th>Submission Text</th><th>Submission Url</th><th>Submission File</th><th>Feedback</th><th>Grade</th><th>Points Earned</th><th>Submit Date</th><th>Update</th>
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