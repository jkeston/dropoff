<?php
	$show = true;
	$user_updated = false;
	$message = '';
	if ( !empty($_POST['task']) ) {
		$task = $_POST['task'];
	}
	else if (!empty($_GET['task']) ) {
		$task = $_GET['task'];
	}
	switch( $task ) {
		// DOCourse tasks
		case 'insert_dropoff_course':
			$c = new DOCourse(0,$user_id,$_POST['course_title'],1,$_POST['session_title'],$_POST['description'],$_POST['syllabus_url'],$_POST['prerequisites'],$_POST['start_date'],$_POST['end_date'],$_POST['status']);
			// Server side validation goes here
			if ( $c->validateDOCourse() ) {
				if ( $c->insertDOCourse() ) {
					$message = "Course $c->course_title created with cid: $c->cid.";
				}
				else {
					$message = "Course not created. Insert failed.";
				}
				unset($c);
			}
			break;
		case 'get_courses':
			$show = false;
			$doc = DOCourse::getDOCourses($_GET['p']);
			$dou = DOUser::getDOUsers();
			$dop = DOProject::getDOProjects();
			break;
		case 'delete_course':
			$b = DOCourse::deleteDOCourse($_GET['cid']);
			if ( $b ) {
				$message = "Course deleted.";
			}
			else {
				$message = "Delete failed.";
			}
			break;
		case 'get_course_for_update':
			$c = DOCourse::getDOCourse($_GET['cid']);
			break;	
		case 'update_dropoff_course':
			$c = new DOCourse($_POST['cid'],$user_id,$_POST['course_title'],1,$_POST['session_title'],$_POST['description'],$_POST['syllabus_url'],$_POST['prerequisites'],$_POST['start_date'],$_POST['end_date'],$_POST['status']);
			// Server side validation here
			if ( $c->validateDOCourse() ) {
				if ( $c->updateDOCourse($_POST['cid']) ) {
					$message = "Course $c->course_title updated with cid: $c->cid.";
				}
				else {
					$message = "Course not updated. Update failed.";
				}
				unset($c);
			}
			break;
		// DOUser tasks
		case 'insert_dropoff_user':
			$u = new DOUser(0, $_POST['username'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $_POST['email_address'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['postal_code'], $_POST['country'], $_POST['notify'], $_POST['dob'], $_POST['user_type'],$_POST['status']);
			// validate this business
			if ( $u->validateDOUser() ) {
				if ( $u->insertDOUser() ) {
					$message = "User $u->first_name $u->last_name created with uid: $u->uid.";
				}
				else {
					$message = "User not created. Insert failed.";
				}
				unset($u);
			}
			break;
		case 'delete_user':
			$b = DOUser::deleteDOUser($_GET['uid']);
			if ( $b ) {
				$message = "User deleted.";
			}
			else {
				$message = "Delete failed.";
			}
			break;
		case 'get_user_for_update':
			$u = DOUser::getDOUser($_GET['uid']);
			break;
		case 'update_dropoff_user':
			$u = new DOUser($_POST['uid'],$_POST['username'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $_POST['email_address'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['postal_code'], $_POST['country'], $_POST['notify'], $_POST['dob'], $_POST['user_type'],$_POST['status']);
			if ( $u->validateDOUser() ) {
				if ( $u->updateDOUser($_POST['uid']) ) {
					$user_updated = true;
					$message = "User $u->username updated with uid: $u->uid.";
				}
				else {
					$message = "User not updated. Update failed.";
				}
				unset($u);
			}
			break;
		case 'logout':
			$_SESSION = array();
			setcookie(session_name(), '', time()-3600, session_id());
			@session_destroy();
			header("Location: login.php?message=You are now logged out");
			exit();
		// DOProject tasks
		case 'insert_dropoff_project':
			if ( !is_numeric($_POST['points']) ) {
				$_POST['points'] = 0;
			}
			$p = new DOProject(0, $user_id, $_POST['course_id'], $_POST['project_title'], $_POST['description'], $_POST['due_date'], $_POST['submit_start'], $_POST['submit_end'], $_POST['points'], $_POST['project_text_req'], $_POST['project_url_req'], $_POST['project_file_req'], $_POST['enroll_date'], $_POST['status']);
			if ( $p->insertDOProject() ) {
				$message = "Project $p->project_title created with pid: $p->uid.";
			}
			else {
				$message = "Project not created. Insert failed.";
			}
			unset($u);
			break;
		case 'get_projects':
			$show = false;
			$doc = DOCourse::getDOCourses();
			$dou = DOUser::getDOUsers();
			$dop = DOProject::getDOProjects($_GET['p']);
			break;
		case 'delete_project':
			$b = DOProject::deleteDOProject($_GET['pid']);
			if ( $b ) {
				$message = "Project deleted.";
			}
			else {
				$message = "Delete failed.";
			}
			break;
		case 'get_project_for_update':
			$p = DOProject::getDOProject($_GET['pid']);
			break;
		case 'update_dropoff_project':
			if ( !is_numeric($_POST['points']) ) {
				$_POST['points'] = 0;
			}
			$p = new DOProject($_POST['pid'], $user_id, $_POST['course_id'], $_POST['project_title'], $_POST['description'], $_POST['due_date'], $_POST['submit_start'], $_POST['submit_end'], $_POST['points'], $_POST['project_text_req'], $_POST['project_url_req'], $_POST['project_file_req'], $_POST['enroll_date'], $_POST['status']);
			if ( $p->updateDOProject($_POST['pid']) ) {
				$message = "Project $p->project_title updated with pid: $p->pid.";
			}
			else {
				$message = "Project not updated. Update failed.";
			}
			unset($p);
			break;
		case 'insert_dropoff_submission':
			//echo "dfgdfgdfg";exit;
			list($pid,$req_text,$req_url,$req_file,$ptitle) = explode(',',$_POST['project_id']);
			$s = new DOSubmission(0,$pid,$user_id,$_POST['project_text'],$_POST['project_url'],$_POST['project_file'],'','',0,'','new');
			if ( $s->validateDOSubmission($req_text,$req_url,$req_file) ) {
				if ( $s->insertDOSubmission() ) {
					$message = "Submission for project $ptitle created.";
				}
				else {
					$message = "Submission not created. Insert failed.";
				}
				unset($s);
			}
			break;
		case 'submit_feedback':
			DOSubmission::submitFeedback();
			break;
		case 'insert_dropoff_enrollment':
			$e = new DOEnrollment(0,$_POST['user_id'],$_POST['course_id'],$_POST['session_id'],$_POST['enroll_date'],$_POST['status']);
			// Server side validation goes here
			if ( $e->validateDOEnrollment() ) {
				if ( $e->insertDOEnrollment() ) {
					$message = "Enrollment for user $e->user_id created with eid: $e->eid.";
				}
				else {
					$message = "Enrollment not created. Insert failed.";
				}
				unset($e);
			}
			break;
		case 'disenroll':
			if ( is_numeric($_GET['eid']) ) {
				$message = DOEnrollment::deleteDOEnrollment($_GET['eid']);
			}
			break;
		case 'logout':
			$_SESSION = array();
			setcookie(session_name(), '', time()-3600, session_id());
			@session_destroy();
			header("Location: login.php?message=You are now logged out");
			exit();
		// Default task
		default:
			if ( !empty($_POST['task']) ) {
				$message = 'No such task: ' . $_POST['task'];
			}
			break;
	}
	if ( $show ) {
		$doc = DOCourse::getDOCourses();
		$dou = DOUser::getDOUsers();
		$dop = DOProject::getDOProjects();
	}
	if ( !empty($_SESSION['message']) ) {
		$message = $_SESSION['message'];
		$_SESSION['message'] = '';
	}
?>