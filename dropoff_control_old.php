<?php
	$show = true;
	$message = '';
	if ( !empty($_POST['task']) ) {
		$task = $_POST['task'];
	}
	else if (!empty($_GET['task']) ) {
		$task = $_GET['task'];
	}
	switch( $task ) {
		// DOClass tasks
		case 'insert_dropoff_class':
			$c = new DOClass(0,$user_id,$_POST['class_title'],1,$_POST['session_title'],$_POST['description'],$_POST['syllabus_url'],$_POST['prerequisites'],$_POST['start_date'],$_POST['end_date'],$_POST['status']);
			// Server side validation goes here
			if ( $c->validateDOClass() ) {
				if ( $c->insertDOClass() ) {
					$message = "Class $c->class_title created with cid: $c->cid.";
				}
				else {
					$message = "Class not created. Insert failed.";
				}
				unset($c);
			}
			break;
		case 'get_classes':
			$show = false;
			$doc = DOClass::getDOClasses($_GET[p]);
			$dou = DOUser::getDOUsers();
			$dop = DOProject::getDOProjects();
			break;
		case 'delete_class':
			$b = DOClass::deleteDOClass($_GET[cid]);
			if ( $b ) {
				$message = "Class deleted.";
			}
			else {
				$message = "Delete failed.";
			}
			break;
		case 'get_class_for_update':
			$c = DOClass::getDOClass($_GET[cid]);
			break;	
		case 'update_dropoff_class':
			$c = new DOClass($_POST[cid],$user_id,$_POST['class_title'],1,$_POST['session_title'],$_POST['description'],$_POST['syllabus_url'],$_POST['prerequisites'],$_POST['start_date'],$_POST['end_date'],$_POST['status']);
			// Server side validation here
			if ( $c->updateDOClass($_POST[cid]) ) {
				$message = "Class $c->class_title updated with cid: $c->cid.";
			}
			else {
				$message = "Class not updated. Update failed.";
			}
			unset($c);
			break;
		// DOUser tasks
		case 'insert_dropoff_user':
			$u = new DOUser(0, $_POST['username'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $_POST['email_address'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['postal_code'], $_POST['country'], $_POST['notify'], $_POST['dob'], $_POST['user_type'],$_POST[status]);
			//
			if ( $u->insertDOUser() ) {
				$message = "User $u->first_name $u->last_name created with uid: $u->uid.";
			}
			else {
				$message = "User not created. Insert failed.";
			}
			unset($u);
			break;
		case 'delete_user':
			$b = DOUser::deleteDOUser($_GET[uid]);
			if ( $b ) {
				$message = "User deleted.";
			}
			else {
				$message = "Delete failed.";
			}
			break;
		case 'get_user_for_update':
			$u = DOUser::getDOUser($_GET[uid]);
			break;
		case 'update_dropoff_user':
			$u = new DOUser($_POST['uid'],$_POST['username'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $_POST['email_address'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['postal_code'], $_POST['country'], $_POST['notify'], $_POST['dob'], $_POST['user_type'],$_POST['status']);
			if ( $u->updateDOUser($_POST['uid']) ) {
				$message = "User $u->username updated with uid: $u->uid.";
			}
			else {
				$message = "User not updated. Update failed.";
			}
			unset($u);
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
			$p = new DOProject(0, $user_id, $_POST['class_id'], $_POST['project_title'], $_POST['description'], $_POST['due_date'], $_POST['submit_start'], $_POST['submit_end'], $_POST['points'], $_POST['project_text_req'], $_POST['project_url_req'], $_POST['project_file_req'], $_POST['enroll_date'], $_POST['status']);
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
			$doc = DOClass::getDOClasses();
			$dou = DOUser::getDOUsers();
			$dop = DOProject::getDOProjects($_GET[p]);
			break;
		case 'delete_project':
			$b = DOProject::deleteDOProject($_GET[pid]);
			if ( $b ) {
				$message = "Project deleted.";
			}
			else {
				$message = "Delete failed.";
			}
			break;
		case 'get_project_for_update':
			$p = DOProject::getDOProject($_GET[pid]);
			break;
		case 'update_dropoff_project':
			if ( !is_numeric($_POST['points']) ) {
				$_POST['points'] = 0;
			}
			$p = new DOProject($_POST['pid'], $user_id, $_POST['class_id'], $_POST['project_title'], $_POST['description'], $_POST['due_date'], $_POST['submit_start'], $_POST['submit_end'], $_POST['points'], $_POST['project_text_req'], $_POST['project_url_req'], $_POST['project_file_req'], $_POST['enroll_date'], $_POST['status']);
			if ( $p->updateDOProject($_POST['pid']) ) {
				$message = "Project $p->project_title updated with pid: $p->pid.";
			}
			else {
				$message = "Project not updated. Update failed.";
			}
			unset($p);
			break;
		case 'logout':
			$_SESSION = array();
			setcookie(session_name(), '', time()-3600, session_id());
			@session_destroy();
			header("Location: login.php?message=You are now logged out");
			exit();
		// Default task
		default:
			if ( !empty($_POST[task]) ) {
				$message = 'No such task: ' . $_POST[task];
			}
			break;
	}
	if ( $show ) {
		$doc = DOClass::getDOClasses();
		$dou = DOUser::getDOUsers();
		$dop = DOProject::getDOProjects();
	}
?>