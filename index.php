<?php
	include('config_dropoff.php');
	include('check_auth.php');
	include('dropoff_classes.php');
	include('dropoff_control.php');
?>
<html>
<head>
	<title>Drop Off Project Submission System</title>
	<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
	<link rel="stylesheet" type="text/css" href="dropoff.css" />
	<script type="text/javascript">
	<!--
	function checkApply(sel,rid) {
	  if (sel.options[sel.selectedIndex].value) {
	    // alert(rid);
	    document.status_form["change_list["+rid+"]"].checked = true;
	  }
	}
	-->
	</script>
	<script type="text/javascript">
	tinymce.init({
	    selector: "textarea",
	    plugins: [
	        "advlist autolink lists link image charmap print preview anchor",
	        "searchreplace visualblocks code fullscreen",
	        "insertdatetime media table contextmenu paste"
	    ],
	    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	});
	</script>
</head>
<body>
<div id="wrapper">
<h1>DropOff Administrative Dashboard</h1>
<?php
	$logout_link = $_SESSION['PHP_SELF']."?task=logout";
?>
<a href="<?php echo $logout_link; ?>">Logout</a><br />
<p>
<?php
	echo "<span style=\"color:red\">$message</span>";
?>
&nbsp;
</p>
<div id="leftcol">
<?php 
	if ( $task == 'get_course_for_update' ) {
		echo "<h3>Update Course</h3>";
	}
	else {
		echo "<h3>Insert Course</h3>";
	}
?>
<form name="insert_dropoff_course" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
<?php
	if ( $task == 'get_course_for_update' ) {
		echo '<input type="hidden" name="task" value="update_dropoff_course" />'."\n";
		echo '<input type="hidden" name="cid" value="'.$c->cid.'" />';		
	}
	else {
		echo '<input type="hidden" name="task" value="insert_dropoff_course" />';
	}
?>
<table bgcolor="#aaaaaa" cellspacing="1" cellpadding="3">
<tr bgcolor="#ffffff">
<td>Course Title:</td>
<td>
<input name="course_title" type="text" value="<?php echo $c->course_title; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">Session Title:</td>
<td>
<input name="session_title" type="text" value="<?php echo $c->session_title; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td colspan="2">Description:<br />
      <textarea name="description" cols="40"><?php echo $c->description; ?></textarea>
    </td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">Syllabus URL:</td>
<td>
<input name="syllabus_url" type="text" value="<?php echo $c->syllabus_url; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">Prerequisites:</td>
<td>
<input name="prerequisites" type="text" value="<?php echo $c->prerequisites; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td>Start Date:</td>
<td>
<input name="start_date" type="text" value="<?php echo $c->start_date; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td>End Date:</td>
<td>
<input name="end_date" type="text" value="<?php echo $c->end_date; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td>Status:</td>
<td>
<?php
	$fselected[$c->status] = ' selected="true"';
?>
<select name="status">
<option value="active"<?php echo $fselected[active]; ?>>Active</option>
<option value="pending"<?php echo $fselected[pending]; ?>>Pending</option>
<option value="archived"<?php echo $fselected[archived]; ?>>Archived</option>
</select>
</td>
</tr>
<tr bgcolor="#ffffff">
<td colspan="2">
<input name="submit" value="Submit" type="submit" /></td>
</tr>
</table>
</form><!-- close dropoff_courses form-->

<!-- dropoff_projects -->
<?php 
	if ( $task == 'get_project_for_update' ) {
		echo "<h3>Update Project</h3>";
	}
	else {
		echo "<h3>Insert Project</h3>";
	}
?>
<form name="insert_dropoff_project" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
<?php
	if ( $task == 'get_project_for_update' ) {
		echo '<input type="hidden" name="task" value="update_dropoff_project" />'."\n";
		echo '<input type="hidden" name="pid" value="'.$p->pid.'" />';		
	}
	else {
		echo '<input type="hidden" name="task" value="insert_dropoff_project" />';
	}
?>
<table bgcolor="#aaaaaa" cellspacing="1" cellpadding="3">
<tr bgcolor="#ffffff">
<td>Project Title:</td>
<td>
<input name="project_title" type="text" value="<?php echo $p->project_title; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">Project Course:</td>
<td>
<select name="course_id">
<?php
  $ctselected[$p->course_id] = ' selected="true"';
  while( $row = mysql_fetch_array($doc) ) {
  	echo("<option value=\"$row[cid]\"".$ctselected[$row[cid]].">$row[course_title]</option>\n");
  }
  mysql_data_seek($doc,0);
?>
</select>
</td>
</tr>
<tr bgcolor="#ffffff">
<td colspan="2">Description:<br />
      <textarea name="description" cols="40"><?php echo $p->description; ?></textarea>
    </td>
</tr>
<tr bgcolor="#ffffff">
<td>Due Date:</td>
<td>
<input name="due_date" type="text" value="<?php echo $p->due_date; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td>Submit Start:</td>
<td>
<input name="submit_start" type="text" value="<?php echo $p->submit_start; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td>Submit End:</td>
<td>
<input name="submit_end" type="text" value="<?php echo $p->submit_end; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td>Enroll Date</td>
<td>
<input name="enroll_date" type="text" value="<?php echo $p->enroll_date; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td>Points:</td>
<td>
<input name="points" type="text" value="<?php echo $p->points; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td>Text Entry Required:</td>
<td>
<?php
	$treq[$p->project_text_req] = ' checked="true"';
	$ureq[$p->project_url_req] = ' checked="true"';
	$freq[$p->project_file_req] = ' checked="true"';
?>
<input name="project_text_req" type="checkbox" value="true"<?php echo $treq['true']; ?> /></td>
</tr>
<tr bgcolor="#ffffff">
<td>URL Entry Required:</td>
<td>
<input name="project_url_req" type="checkbox" value="true"<?php echo $ureq['true']; ?> /></td>
</tr>
<tr bgcolor="#ffffff">
<td>File Upload Required:</td>
<td>
<input name="project_file_req" type="checkbox" value="true"<?php echo $freq['true']; ?> /></td>
</tr>
<tr bgcolor="#ffffff">
<td>Status:</td>
<td>
<?php
	$fselected[$p->status] = ' selected="true"';
?>
<select name="status">
<option value="active"<?php echo $fselected[active]; ?>>Active</option>
<option value="pending"<?php echo $fselected[pending]; ?>>Pending</option>
<option value="archived"<?php echo $fselected[archived]; ?>>Archived</option>
</select>
</td>
</tr>
<tr bgcolor="#ffffff">
<td colspan="2">
<input name="submit" value="Submit" type="submit" /></td>
</tr>
</table>
</form><!-- close dropoff_projects form-->
</div><!-- close #leftcol -->

<div id="rightcol">
<!-- Begin: Lesson Form -->
<?php 
	if ( $task == 'get_lesson_for_update' ) {
		echo "<h3>Update Lesson</h3>";
	}
	else {
		echo "<h3>Insert Lesson</h3>";
	}
?>
<form name="insert_dropoff_lesson" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
<?php
	if ( $task == 'get_lesson_for_update' ) {
		echo '<input type="hidden" name="task" value="update_dropoff_lesson" />'."\n";
		echo '<input type="hidden" name="cid" value="'.$l->cid.'" />';		
	}
	else {
		echo '<input type="hidden" name="task" value="insert_dropoff_lesson" />';
	}
	echo '<input type="hidden" name="user_id" value="'.$user_id.'" />';		
?>
<table bgcolor="#aaaaaa" cellspacing="1" cellpadding="3">
<tr bgcolor="#ffffff">
<td>Lesson Title:</td>
<td>
<input name="lesson_title" type="text" value="<?php echo $l->lesson_title; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td>Lesson Course:</td>
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
<td colspan="2">Lesson Content:<br />
      <textarea name="content" cols="40"><?php echo $l->content; ?></textarea>
    </td>
</tr>
<tr bgcolor="#ffffff">
<td height="27">Sequence:</td>
<td>
<input name="sequence" type="text" value="<?php echo $l->sequence; ?>" /></td>
</tr>
<tr bgcolor="#ffffff">
<td>Status:</td>
<td>
<?php
	$lselected[$l->status] = ' selected="true"';
?>
<select name="status">
<option value="active"<?php echo $lselected[active]; ?>>Active</option>
<option value="pending"<?php echo $lselected[pending]; ?>>Pending</option>
<option value="archived"<?php echo $lselected[archived]; ?>>Archived</option>
</select>
</td>
</tr>
<tr bgcolor="#ffffff">
<td colspan="2">
<input name="submit" value="Submit" type="submit" /></td>
</tr>
</table>
</form>
<!-- End: Lesson Form -->
<?php 
	if ( $task == 'get_user_for_update' ) {
		echo "<h3>Update User</h3>";
	}
	else {
		echo "<h3>Insert User</h3>";
	}
?>
<form name="insert_dropoff_user" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
<?php
	if ( $task == 'get_user_for_update' ) {
		echo '<input type="hidden" name="task" value="update_dropoff_user" />'."\n";
		echo '<input type="hidden" name="uid" value="'.$u->uid.'" />';		
	}
	else {
		echo '<input type="hidden" name="task" value="insert_dropoff_user" />';
	}
?>
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
<td>User Type:</td>
<td>
<?php
  $utselected[$u->user_type] = ' selected="true"';
?>
<select name="user_type">
<option value="Admin"<?php echo $utselected['Admin']; ?>>Admin</option>
<option value="Instructor"<?php echo $utselected['Instructor']; ?>>Instructor</option>
<option value="Student"<?php echo $utselected['Student']; ?>>Student</option>
</select>
</td>
</tr>
<tr bgcolor="#ffffff">
<td>Status:</td>
<td>
<?php
  $sselected[$u->status] = ' selected="true"';
?>
<select name="status">
<option value="active"<?php echo $sselected[active]; ?>>Active</option>
<option value="disabled"<?php echo $sselected[disabled]; ?>>Disabled</option>
</select>
</td>
</tr>
<tr bgcolor="#ffffff">
<td colspan="2">
<input name="submit" value="Submit" type="submit" /></td>
</tr>
</table>
</form><!-- close dropoff_users form-->

<!-- start enrollment form -->
<h3>Create Enrollment</h3>
<form name="insert_dropoff_enrollment" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="task" value="insert_dropoff_enrollment" />
<table bgcolor="#aaaaaa" cellspacing="1" cellpadding="3">
<tr bgcolor="#ffffff">
<td>Student:</td>
<td>
	<select name="user_id">
<?php
	while( $row = mysql_fetch_array($dou) ) {	
		echo('<option value="'.$row['uid'].'">'.$row['first_name'].' '.$row['last_name'].' ('.$row['username'].')</option>');
	}
	mysql_data_seek($dou,0);
?>
	</select>
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
<!-- end of enrollment form -->

</div>
<div id="bottom">
<!-- Display dropoff_courses for update and delete -->
<?php
	$active_link = "$_SERVER[PHP_SELF]?task=get_courses&p=active";
	$pending_link = "$_SERVER[PHP_SELF]?task=get_courses&p=pending";
	$archived_link = "$_SERVER[PHP_SELF]?task=get_courses&p=archived";
	$mycourses_link = "$_SERVER[PHP_SELF]?task=get_courses&p=".$user_id;
?>
<a href="<?php echo $mycourses_link; ?>">Show My Courses</a> | <a href="<?php echo $_SERVER[PHP_SELF]; ?>">Show All Courses</a> | <a href="<?php echo $active_link; ?>">Show Active Courses</a> | <a href="<?php echo $pending_link; ?>">Show Pending Courses</a> | <a href="<?php echo $archived_link; ?>">Show Archived Courses</a> 
<table>
<tr>
<th>Course Title</th><th>Author</th><th>Session Title</th><th>Description</th><th>Syllabus</th><th>Prerequisites</th><th>Start Date</th><th>End Date</th><th>Status</th><th>Delete Course</th><th>Enrolled</th>
</tr>
<?php
  while( $row = mysql_fetch_array($doc) ) {
  	$enroll_count = DOEnrollment::getDOEnrolledCount($row[cid]);
  	$enroll_ids = DOEnrollment::getDOEnrolledIds($row[cid]);
  	// print_r($enroll_ids);
  	$enroll_user = DOUser::getDOUsers($enroll_ids);
  	$names = '';
  	while ( $urow = mysql_fetch_array($enroll_user) ) {
  		$names .= $urow['first_name'] . ' ' . $urow['last_name'] . "\n";
  	}
  	$names = rtrim($names);
  	$deletecourse_link = "<a href=\"$_SERVER[PHP_SELF]?task=delete_course&cid=$row[cid]\">Delete</a>";
 	$updatecourse_link = "<a title=\"Update\" href=\"$_SERVER[PHP_SELF]?task=get_course_for_update&cid=$row[cid]\">$row[course_title]</a>";
    echo ( "<tr><td>$updatecourse_link</td><td>$row[first_name] $row[last_name]</td><td>$row[session_title]</td><td>$row[description]</td><td>$row[syllabus_url]</td><td>$row[prerequisites]</td><td>$row[start_date]</td><td>$row[end_date]</td><td>$row[status]</td><td>$deletecourse_link</td><td><a href='#' title='$names'>$enroll_count</a></td></tr>\n" );
  }
  // echo DOCourse::hasProjects;
?>
</table>

<!-- Display dropoff_users for update and delete -->
<?php
	// $active_link = "$_SERVER[PHP_SELF]?task=get_courses&p=active";
	// $pending_link = "$_SERVER[PHP_SELF]?task=get_courses&p=pending";
	// $archived_link = "$_SERVER[PHP_SELF]?task=get_courses&p=archived";
	$mycourses_link = "$_SERVER[PHP_SELF]?task=get_courses&p=".$user_id;
?>
<!-- <a href="<?php echo $mycourses_link; ?>">Show My Courses</a> | <a href="<?php echo $_SERVER[PHP_SELF]; ?>">Show All Courses</a> | <a href="<?php echo $active_link; ?>">Show Active Courses</a> | <a href="<?php echo $pending_link; ?>">Show Pending Courses</a> | <a href="<?php echo $archived_link; ?>">Show Archived Courses</a>  -->
<h3>Users (Faculty and Students)</h3>
<table>
<tr>
<th>Name</th><th>Username</th><th>Email Address</th><th>Notify</th><th>User Type</th><th>Status</th><th>Edit User</th><th>Delete User</th>
</tr>
<?php
  while( $row = mysql_fetch_array($dou) ) {
  	$deleteuser_link = "<a onclick=\"return confirm('Are you sure that you want to permanently delete this user from the databse?');\" href=\"$_SERVER[PHP_SELF]?task=delete_user&uid=$row[uid]\">Delete</a>";
 	$viewuser_link = "<a title=\"View Student Profile\" href=\"student_profile.php?uid=$row[uid]\">$row[first_name] $row[last_name]</a>";
 	$updateuser_link = "<a title=\"Update\" href=\"$_SERVER[PHP_SELF]?task=get_user_for_update&uid=$row[uid]\">Edit</a>";
    echo ( "<tr><td>$viewuser_link</td><td>$row[username]</td><td>$row[email_address]</td><td>$row[notify]</td><td>$row[user_type]</td><td>$row[status]</td><td>$updateuser_link</td><td>$deleteuser_link</td></tr>\n" );
  }
  // echo DOCourse::hasProjects;
?>
</table>
<p>&nbsp;</p>
<!-- Display dropoff_projects for update and delete -->
<?php
	$active_link = "$_SERVER[PHP_SELF]?task=get_projects&p=active";
	$pending_link = "$_SERVER[PHP_SELF]?task=get_projects&p=pending";
	$archived_link = "$_SERVER[PHP_SELF]?task=get_projects&p=archived";
	$myprojects_link = "$_SERVER[PHP_SELF]?task=get_projects&p=".$user_id;
?>
<a href="<?php echo $myprojects_link; ?>">Show My projects</a> | <a href="<?php echo $_SERVER[PHP_SELF]; ?>">Show All projects</a> | <a href="<?php echo $active_link; ?>">Show Active projects</a> | <a href="<?php echo $pending_link; ?>">Show Pending projects</a> | <a href="<?php echo $archived_link; ?>">Show Archived projects</a> 
<table>
<tr>
<th>Project Title</th><th>Description</th><th>Course</th><th>Author</th><th>Due Date</th><th>Submit Start</th><th>Submit End</th><th>Points</th><th>Status</th><th>Delete Project</th>
</tr>
<?php
  while( $row = mysql_fetch_array($dop) ) {
  	$deleteproject_link = "<a href=\"$_SERVER[PHP_SELF]?task=delete_project&pid=$row[pid]\">Delete</a>";
 	$updateproject_link = "<a title=\"Update\" href=\"$_SERVER[PHP_SELF]?task=get_project_for_update&pid=$row[pid]\">$row[project_title]</a>";
    echo ( "<tr><td>$updateproject_link</td><td>$row[description]</td><td>$row[course_title]</td><td>$row[first_name] $row[last_name]</td><td>$row[due_date]</td><td>$row[submit_start]</td><td>$row[submit_end]</td><td>$row[points]</td><td>$row[status]</td><td>$deleteproject_link</td></tr>\n" );
  }
?>
</table>

<p>&nbsp;</p>
<!-- Display dropoff_projects for update and delete -->
<?php
	$active_link = "$_SERVER[PHP_SELF]?task=get_lessons&p=active";
	$pending_link = "$_SERVER[PHP_SELF]?task=get_lessons&p=pending";
	$archived_link = "$_SERVER[PHP_SELF]?task=get_lessons&p=archived";
	$mylessons_link = "$_SERVER[PHP_SELF]?task=get_lessons&p=".$user_id;
?>
<a href="<?php echo $mylessons_link; ?>">Show My Lessons</a> | <a href="<?php echo $_SERVER[PHP_SELF]; ?>">Show All Lessons</a> | <a href="<?php echo $active_link; ?>">Show Active Lessons</a> | <a href="<?php echo $pending_link; ?>">Show Pending Lessons</a> | <a href="<?php echo $archived_link; ?>">Show Archived Lessons</a> 
<table>
<tr>
<th>Lesson Title</th><th>Lesson Content</th><th>Sequence</th><th>Course</th><th>Author</th><th>Status</th><th>Delete Lesson</th>
</tr>
<?php
  while( $row = mysql_fetch_array($dol) ) {
  	$deletelesson_link = "<a href=\"$_SERVER[PHP_SELF]?task=delete_lesson&pid=$row[pid]\">Delete</a>";
 	$updatelesson_link = "<a title=\"Update\" href=\"$_SERVER[PHP_SELF]?task=get_lesson_for_update&pid=$row[lid]\">$row[lesson_title]</a>";
    echo ( "<tr><td>$updatelesson_link</td><td>$row[content]</td><td>$row[sequence]</td><td>$row[course_title]</td><td>$row[first_name] $row[last_name]</td><td>$row[status]</td><td>$deletelesson_link</td></tr>\n" );
  }
?>
</table>


</div><!--close #bottom-->

</div><!--close #wrapper-->
</body>
</html>