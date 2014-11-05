<?php
	$course_tr = '';
	$std_id_get = '';
	if ( ( $_SESSION['dropofftype'] == 'Admin' || 
			   $_SESSION['dropofftype'] == 'Instructor' ) && 
			   is_numeric($_GET['uid']) ) {
		$e_results = DOCourse::getEnrolledCoursesByUID($_GET['uid']);
		$std_id_get = "&uid=".$_GET['uid'];
	}
	else {
		$e_results = DOCourse::getEnrolledCoursesByUID($user_id);
	}	
	while( $row = mysql_fetch_array($e_results) ) {
		$course_tr .= "<tr><td>$row[course_title]</td><td>$row[first_name] $row[last_name]</td><td>$row[session_title]</td><td>$row[description]</td><td>$row[syllabus_url]</td><td>$row[prerequisites]</td><td>$row[start_date]</td><td>$row[end_date]</td><td>$row[status]</td><td><a href=\"$_SERVER[PHP_SELF]?task=disenroll&eid=$row[eid]$std_id_get\">Disenroll</a></tr>\n";
		$p_results = DOProject::getDOProjectsByCID($row['cid']);
		if ( mysql_num_rows($p_results) > 0 ) {
			$course_tr .= '<tr><td>&nbsp;</td><td colspan="9" bgcolor="#eee">
	<table>
		<tr><th>Project Title</th><th>Description</th><th>Due Date</th><th>Submit Start</th><th>Submit End</th><th>Points</th><th>Status</th></tr>';
			while( $p_row = mysql_fetch_array($p_results)) {
				$course_tr .= "<tr><td>$p_row[project_title]</td><td>$p_row[description]</td><td>$p_row[due_date]</td><td>$p_row[submit_start]</td><td>$p_row[submit_end]</td><td>$p_row[points]</td><td>$p_row[status]</td></tr>\n";
				$reqs = $p_row['project_text_req'].','.$p_row['project_url_req'].','.$p_row['project_file_req'];
				$poption = '<option value="'.$p_row['pid'].','.$reqs.','."'".$p_row['project_title']."'".'">'.$row['course_title'].' &raquo; '.$p_row['project_title']."</option>\n";
				$project_options[$p_row['pid']] = array($poption,$reqs);
			}
			$course_tr .= '	</table>
</td></tr>';
		}
	}
?>