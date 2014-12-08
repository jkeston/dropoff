<?php
  class DOCourse {
   		// DOCourses properties
		public $cid;			
		public $user_id;		
		public $course_title;
		public $session_id;
		public $session_title;
		public $description;
		public $syllabus_url;
		public $prerequisites;
		public $start_date;	
		public $end_date;	
		public $status;
		const hasProjects = true;
 		
 		// define the constructor for the class
		public function __construct( $cid, $user_id, $course_title, $session_id, $session_title, $description, $syllabus_url, $prerequisites, $start_date, $end_date, $status ) {
			$this->cid = $cid;					
			$this->user_id = $user_id;			
			$this->course_title = $course_title;		
			$this->session_id = $session_id;		
			$this->session_title = $session_title;		
			$this->description = $description;		
			$this->syllabus_url = $syllabus_url;		
			$this->prerequisites = $prerequisites;		
			$this->start_date = $start_date;			
			$this->end_date = $end_date;			
			$this->status = $status;  		
		}

		public static function getDOCourses($e = '') {
			global $course_status;
			$query = "SELECT c.*,u.first_name,u.last_name,u.uid FROM dropoff_courses c, dropoff_users u WHERE u.uid = c.user_id ";
			if ( is_numeric($e) && $e > 0 ) {
				$query .= " AND c.user_id = $e";
			}
			else if ( in_array($e, $course_status) ) {
				$query .= " AND c.status = '$e'";				
			}
			$result = mysql_query($query);
			return $result;
		}

		public static function getEnrolledCoursesByUID($e) {
			$query = "SELECT 	c.*,
												e.eid,
												u.first_name,
												u.last_name 
								FROM 		dropoff_courses c, 
												dropoff_enrollment e,
												dropoff_users u
								WHERE 	e.user_id = $e 
								AND 		c.cid = e.course_id 
								AND			u.uid = c.user_id
								ORDER BY c.course_title";
			$result = mysql_query($query);
			return $result;
		}
		
		public static function getDOCourse($e) {
			$query = "SELECT * FROM dropoff_courses WHERE cid = $e";
			$result = mysql_query($query);
			if ( $row = mysql_fetch_array($result) ) {
				return new DOCourse($row['cid'],$row['user_id'],$row['course_title'],$row['session_id'],$row['session_title'],$row['description'],$row['syllabus_url'],$row['prerequisites'],$row['start_date'],$row['end_date'],$row['status']);
			}
			else {
				return false;
			}
		}

		public static function deleteDOCourse($e) {
			if ( is_numeric($e) && $e > 0 ) {
				$query = "DELETE FROM dropoff_courses WHERE cid = $e";
				return mysql_query($query);	
			}
			else {
				return false;
			}			
		}

		public function insertDOCourse() {
			$query = "INSERT INTO dropoff_courses ( 
				user_id, 
				course_title, 
				session_id, 
				session_title, 
				description, 
				syllabus_url, 
				prerequisites, 
				start_date, 
				end_date, 
				status ) 
			VALUES ( 
				$this->user_id, 
				'$this->course_title', 
				1, 
				'$this->session_title', 
				'$this->description', 
				'$this->syllabus_url', 
				'$this->prerequisites', 
				'$this->start_date', 
				'$this->end_date', 
				'$this->status' )";

			// echo $query;
			$valid = mysql_query( $query );
			$this->cid = mysql_insert_id();
			return $valid;
		}

		public function updateDOCourse($e) {
			$query = "UPDATE dropoff_courses SET 
				user_id = $this->user_id, 
				course_title = '$this->course_title', 
				session_id = $this->session_id, 
				session_title = '$this->session_title', 
				description = '$this->description', 
				syllabus_url = '$this->syllabus_url', 
				prerequisites = '$this->prerequisites', 
				start_date = '$this->start_date', 
				end_date = '$this->end_date', 
				status = '$this->status' WHERE cid = $this->cid";

			//echo $query;exit;
			$valid = mysql_query( $query );
			return $valid;
		}

		public function validateDOCourse() {
			global $message;
			$valid = true;
			if ( empty($this->course_title) ) {
				$valid = false;
				$message .= "You must enter a Course Title.<br />\n";
			}
			if ( empty($this->session_title) ) {
				$valid = false;
				$message .= "You must enter a Session Title.<br />\n";
			}
			if ( empty($this->description) ) {
				$valid = false;
				$message .= "You must enter a Description.<br />\n";
			}
			return $valid;
		}  
  }

  class DOUser {
		public $uid;
		public $username;
		public $password;
		public $first_name;
		public $last_name;
		public $email_address;
		public $address;	
		public $city;
		public $state;
		public $postal_code;
		public $country;
		public $notify;
		public $dob;
		public $user_type;
		public $status;

		public function __construct( $uid, $username, $password, $first_name, $last_name, $email_address, $address, $city, $state, $postal_code, $country, $notify, $dob, $user_type, $status ) {
			$this->uid = $uid;					
			$this->username = $username;
			$this->password = $password;
			$this->first_name = $first_name;
			$this->last_name = $last_name;
			$this->email_address = $email_address;
			$this->address = $address;	
			$this->city = $city;
			$this->state = $state;
			$this->postal_code = $postal_code;
			$this->country = $country;
			$this->notify = $notify;
			$this->dob = $dob;
			$this->user_type = $user_type;
			$this->status = $status;
		}

		public static function deleteDOUser($e) {
			if ( is_numeric($e) && $e > 0 ) {
				$query = "DELETE FROM dropoff_users WHERE uid = $e";
				return mysql_query($query);	
			}
			else {
				return false;
			}			
		}

		public function insertDOUser() {
			$query = "INSERT INTO dropoff_users ( 
				username,
				password,
				first_name,
				last_name,
				email_address,
				address,	
				city,
				state,
				postal_code,
				country,
				notify,
				dob,
				user_type,
				status )
			VALUES ( 
				'$this->username',
				MD5('$this->password'),
				'$this->first_name',
				'$this->last_name',
				'$this->email_address',
				'$this->address',	
				'$this->city',
				'$this->state',
				'$this->postal_code',
				'$this->country',
				'$this->notify',
				'$this->dob',
				'$this->user_type',
				'$this->status' )";

			//echo $query; exit;
			$valid = mysql_query( $query );
			$this->uid = mysql_insert_id();
			return $valid;
		}

		public function updateDOUser($e) {
			$query = "UPDATE dropoff_users SET 
				username = '$this->username', 
				password = MD5('$this->password'), 
				first_name = '$this->first_name', 
				last_name = '$this->last_name', 
				email_address = '$this->email_address', 
				address = '$this->address', 
				city = '$this->city', 
				state = '$this->state', 
				postal_code = '$this->postal_code', 
				country = '$this->country', 
				notify = '$this->notify', 
				dob = '$this->dob', 
				user_type = '$this->user_type', 
				status = '$this->status' WHERE uid = $this->uid";

			//echo $query;exit;
			$valid = mysql_query( $query );
			return $valid;
		}

		public function validateDOUser() {
			global $message;
			$valid = true;
			if ( empty($this->username) ) {
				$valid = false;
				$message .= "You must enter a unique username.<br />\n";
			}
			if ( empty($this->password) ) {
				$valid = false;
				$message .= "You must enter a password.<br />\n";
			}
			if ( empty($this->email_address) ) {
				$valid = false;
				$message .= "You must enter an email address.<br />\n";
			}
			return $valid;
		}

		public static function getDOUsers($e = '') {
			$query = "SELECT * FROM dropoff_users ";
			if ( is_array($e) ) {
				$uids = implode(',',$e);
				$query .= "WHERE uid IN ($uids)";
			}
			//echo $query; exit;
			$result = mysql_query($query);
			return $result;
		}

		public static function getDOUser($e) {
			$query = "SELECT * FROM dropoff_users WHERE uid = $e";
			$result = mysql_query($query);
			if ( $row = mysql_fetch_array($result) ) {
				return new DOUser($row['uid'],$row['username'],$row['password'],$row['first_name'],$row['last_name'],$row['email_address'],$row['address'],$row['city'],$row['state'],$row['postal_code'],$row['country'],$row['notify'],$row['dob'],$row['user_type'],$row['status']);
			}
			else {
				return false;
			}
		}

		public static function activateDOUser($e) {
			global $message,$local_path;
			$query = "SELECT * FROM dropoff_validation WHERE validation_code = '$e' AND status = 'pending' ";
			$result = mysql_query($query);
			$row = mysql_fetch_array($result);
			if ( is_numeric($row['user_id']) ) {
				$query = "UPDATE dropoff_users SET status='active' WHERE uid=".$row['user_id'];
				if ( mysql_query($query) ) {
					$message = "Your account has been activated. Please login below.";
					header("Location: ".$_SERVER['HTTP_ORIGIN'].$local_path.'login.php?message='.$message);

				}
			}
		}

		public function sendValidationCode() {
			global $message;
		   $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		   $randomString = '';
		   for ($i = 0; $i < 32; $i++) {
		      $randomString .= $characters[rand(0, strlen($characters) - 1)];
		   }
		   // TO DO: Make sure random code is not already there.
		   $query = "INSERT INTO dropoff_validation (user_id,validation_code,status) ";
		   $query .= "VALUES (".$this->uid.",'$randomString','pending')";
		   // echo $query; exit;
		   if ( mysql_query($query) ) {
		   	$email = "Please click the link below to activate you account:\n";
		   	$email .= $_SERVER["HTTP_REFERER"].'?reg_code='.$randomString;
		   	mail($this->email_address, 'DropOff Activation Link', $email, "From: keston@unearthedmusic.com\r\nReturn-Path: keston@unearthedmusic.com\r\n" ); 
		   	$message .= ' Please click the validation link in your email.';
		   }
		   else {
		   	$message .= ' Failed to create registration code.';
		   }
		}
  }

  class DOProject {
		public $pid;		
		public $user_id;			
		public $course_id;		
		public $project_title;	
		public $description;		
		public $due_date;		
		public $submit_start;	
		public $submit_end;		
		public $points;			
		public $project_text_req;
		public $project_url_req;	
		public $project_file_req;
		public $enroll_date;		
		public $status;  

		public function __construct( $pid, $user_id, $course_id, $project_title, $description, $due_date, $submit_start, $submit_end, $points, $project_text_req, $project_url_req, $project_file_req, $enroll_date, $status ) {				
			$this->pid = $pid;		
			$this->user_id = $user_id;			
			$this->course_id = $course_id;		
			$this->project_title = $project_title;	
			$this->description = $description;		
			$this->due_date = $due_date;		
			$this->submit_start = $submit_start;	
			$this->submit_end = $submit_end;		
			$this->points = $points;			
			$this->project_text_req = $project_text_req;
			$this->project_url_req = $project_url_req;	
			$this->project_file_req = $project_file_req;
			$this->enroll_date = $enroll_date;		
			$this->status = $status;
		}
		public function insertDOProject() {
			$query = "INSERT INTO dropoff_projects ( 	
				pid,	
				user_id,
				course_id,
				project_title,
				description,
				due_date,
				submit_start,
				submit_end,
				points,
				project_text_req,
				project_url_req, 
				project_file_req,
				enroll_date,
				status )
			VALUES ( 
				$this->pid,
				$this->user_id,
				$this->course_id,
				'$this->project_title',
				'$this->description',	
				'$this->due_date',
				'$this->submit_start',
				'$this->submit_end',
				$this->points,
				'$this->project_text_req',
				'$this->project_url_req',
				'$this->project_file_req',
				'$this->enroll_date',
				'$this->status' )";

			//echo $query; exit;
			$valid = mysql_query( $query );
			$this->uid = mysql_insert_id();
			return $valid;
		}
		public function updateDOProject($e) {
			$query = "UPDATE dropoff_projects SET 
				user_id = $this->user_id, 
				course_id = $this->course_id, 
				project_title = '$this->project_title', 
				description = '$this->description', 
				due_date = '$this->due_date', 
				submit_start = '$this->submit_start', 
				submit_end = '$this->submit_end', 
				points = $this->points, 
				project_text_req = '$this->project_text_req', 
				project_url_req = '$this->project_url_req', 
				project_file_req = '$this->project_file_req', 
				enroll_date = '$this->enroll_date', 
				status = '$this->status' WHERE pid = $this->pid";

			//echo $query;exit;
			$valid = mysql_query( $query );
			return $valid;
		}

		public static function deleteDOProject($e) {
			if ( is_numeric($e) && $e > 0 ) {
				$query = "DELETE FROM dropoff_projects WHERE pid = $e";
				return mysql_query($query);	
			}
			else {
				return false;
			}			
		}

		public static function getDOProjects($e = '') {
			global $course_status;
			$query = "SELECT p.*,u.first_name,u.last_name,c.course_title FROM dropoff_projects p,dropoff_users u,dropoff_courses c WHERE u.uid = p.user_id AND c.cid = p.course_id ";
			if ( is_numeric($e) && $e > 0 ) {
				$query .= " AND p.user_id = $e";
			}
			else if ( in_array($e, $course_status) ) {
				$query .= " AND p.status = '$e'";				
			}
			$result = mysql_query($query);
			//echo $query; exit;
			return $result;
		}

		public static function getDOProjectsByCID($e) {
			global $course_status;
			$query = "SELECT * FROM dropoff_projects WHERE course_id = $e ";
			$result = mysql_query($query);
			//echo $query; exit;
			return $result;
		}

		public static function getDOProject($e) {
			$query = "SELECT * FROM dropoff_projects WHERE pid = $e";
			//echo $query; exit;
			$result = mysql_query($query);
			if ( $row = mysql_fetch_array($result) ) {
				return new DOProject($row['pid'], $row['user_id'], $row['course_id'], $row['project_title'], $row['description'], $row['due_date'], $row['submit_start'], $row['submit_end'], $row['points'], $row['project_text_req'], $row['project_url_req'], $row['project_file_req'], $row['enroll_date'], $row['status']);
			}
			else {
				return false;
			}
		}
	}

	class DOEnrollment {
		public $eid;
		public $user_id;
		public $course_id; 
		public $session_id;
		public $enroll_date;
		public $status;

		public function __construct( $eid, $user_id, $course_id, $session_id, $enroll_date, $status ) {
			$this->eid = $eid;
			$this->user_id = $user_id;
			$this->course_id = $course_id; 
			$this->session_id = $session_id;
			$this->enroll_date = $enroll_date;
			$this->status = $status;	
		}
		public function validateDOEnrollment() {
			global $message;
			$valid = true;
			if ( empty($this->user_id) ) {
				$valid = false;
				$message .= "You must choose a student to enroll.<br />\n";
			}
			if ( empty($this->course_id) ) {
				$valid = false;
				$message .= "You must choose a course.<br />\n";
			}
			if ( empty($this->session_id) ) {
				$valid = false;
				$message .= "You must choose a session.<br />\n";
			}
			if ( DOEnrollment::checkDOEnrollment($this) ) {
				$valid = false;
				$message .= "Student id $this->user_id is already enrolled.<br />\n";
			}
			return $valid;
		}  
		public function insertDOEnrollment() {
			$query = "INSERT INTO dropoff_enrollment ( 
				eid,
				user_id,
				course_id, 
				session_id,
				enroll_date,
				status ) 
			VALUES ( 
				$this->eid,
				$this->user_id,
				$this->course_id,
				$this->session_id,
				NOW(),
				'$this->status' )";

			// echo $query;
			$valid = mysql_query( $query );
			$this->eid = mysql_insert_id();
			return $valid;
		}

		public static function checkDOEnrollment($e) {
			$query = "SELECT * FROM dropoff_enrollment WHERE user_id = $e->user_id AND course_id = $e->course_id AND session_id = $e->session_id";
			//echo $query; exit;
			$result = mysql_query($query);
			if ( $row = mysql_fetch_array($result) ) {
				return true;
			}
			else {
				return false;
			}
		}

		public static function getDOEnrolledIds($cid) {
			$query = "SELECT user_id FROM dropoff_enrollment WHERE course_id = $cid";
			$result = mysql_query($query);
			while ( $row = mysql_fetch_array($result) ) {
				$uids[] = $row[0];
			}
			return $uids;
		}

		public static function deleteDOEnrollment($eid) {
			$query = "DELETE FROM dropoff_enrollment WHERE eid = $eid";
			$result = mysql_query($query);
			if ( $result == true ) {
				$m = 'Class disenrolled';
			}
			else {
				$m = 'Disenrollment failed';
			}
			return $m;
		}
		
		public static function getDOEnrolledCount($cid) {
			$query = "SELECT COUNT(*) FROM dropoff_enrollment WHERE course_id = $cid";
			$result = mysql_query($query);
			$row = mysql_fetch_array($result);
			return $row[0];
		}
	}

	class DOSubmission {
		public $sid;		
		public $project_id;	
		public $user_id;		
		public $project_text;
		public $project_url;	
		public $project_file;
		public $feedback;	
		public $letter_grade;
		public $points_earned;
		public $submit_date;	
		public $status;

		public function __construct( $sid, $project_id, $user_id, $project_text, $project_url, $project_file, $feedback, $submit_end, $letter_grade, $points_earned, $submit_date, $status ) {
			$this->sid = $sid;					
			$this->project_id = $project_id;	
			$this->user_id = $user_id;		
			$this->project_text = $project_text;
			$this->project_url = $project_url;	
			$this->project_file = $project_file;
			$this->feedback = $feedback;	
			$this->letter_grade = $letter_grade;
			$this->points_earned = $points_earned;
			$this->submit_date = $submit_date;	
			$this->status = $status;
		}

		public function validateDOSubmission($req_text,$req_url,$req_file) {
			global $message;
			$valid = true;
			if ( !is_numeric($this->project_id) ) {
				$message .= 'You must select a project for your submission<br />';
				$valid = false;
			}
			if ( $req_text == 'true' && empty($this->project_text) ) {
				$message .= 'This project requires a text response<br />';
				$valid = false;		
			}
			if ( $req_url == 'true' && empty($this->project_url) ) {
				$message .= 'This project requires a valid url<br />';
				$valid = false;		
			}
			// if ( $req_file == 'true' && empty($this->project_file) ) {
			// 	$message .= 'This project requires an uploaded file<br />';
			// 	$valid = false;		
			// }
			return $valid;
		}

		public function insertDOSubmission() {
			$query = "INSERT INTO dropoff_submissions ( 	
				project_id,	
				user_id,		
				project_text,
				project_url,
				project_file,
				feedback,	
				letter_grade,
				points_earned,
				submit_date,
				status )
			VALUES ( 	
				$this->project_id,	
				$this->user_id,		
				'$this->project_text',
				'$this->project_url',
				'$this->project_file',
				'$this->feedback',	
				'$this->letter_grade',
				'$this->points_earned',
				NOW(),
				'$this->status' )";

			//echo $query;
			$valid = mysql_query( $query );
			$this->sid = mysql_insert_id();
			return $valid;
		}

		public function submitFeedback() {
			global $message;
			$query = "UPDATE dropoff_submissions SET feedback = '$_POST[feedback]', letter_grade = '$_POST[letter_grade]', points_earned = '$_POST[points_earned]' WHERE sid = $_POST[sid]";	
			// echo $query;
			$valid = mysql_query( $query );
			if ( !$valid ) {
				$message = 'Submit feedback failed';
			}
			else {
				$message = 'Feedback submitted';
			}
			return $valid;
		}

		public static function getDOSubmissions($e = '') {
			global $course_status;
			$query = "SELECT s.*, p.project_title, p.description FROM dropoff_submissions s, dropoff_projects p WHERE s.project_id = p.pid ";
			if ( is_numeric($e) && $e > 0 ) {
				$query .= " AND s.user_id = $e";
			}
			$result = mysql_query($query);
			//echo $query; exit;
			return $result;
		}
	}
  class DOLesson {
   		// DOCourses properties
		public $lid;
		public $user_id;		
		public $course_id;		
		public $lesson_title;
		public $sequence;
		public $content;
		public $status;
 		
 		// define the constructor for the class
		public function __construct( $lid, $user_id, $course_id, $lesson_title, $sequence, $content, $status ) {
			$this->lid = $lid;
			$this->user_id = $user_id;				
			$this->course_id = $course_id;			
			$this->lesson_title = $lesson_title;		
			$this->sequence = $sequence;		
			$this->content = $content;					
			$this->status = $status;  		
		}

		public static function getDOLessons($e) {
			// global $course_status;
			$query = "SELECT * FROM dropoff_lessons";
			$query = "SELECT l.*,u.first_name,u.last_name,c.course_title FROM dropoff_lessons l, dropoff_users u,dropoff_courses c WHERE u.uid = l.user_id AND c.cid = l.course_id ";
			if ( is_numeric($e) && $e > 0 ) {
				$query .= " AND l.user_id = $e";
			}
			else if ( in_array($e, $course_status) ) {
				$query .= " AND l.status = '$e'";				
			}
			$result = mysql_query($query);
			//echo $query; exit;
			return $result;
		}

		
		public static function getDOLesson($e) {
			$query = "SELECT * FROM dropoff_lessons WHERE lid = $e";

			$result = mysql_query($query);
			if ( $row = mysql_fetch_array($result) ) {
				return new DOCourse($row['lid'],$row['user_id'],$row['course_id'],$row['lesson_title'],$row['sequence'],$row['content'],$row['status']);
			}
			else {
				return false;
			}
		}

		public static function deleteDOLesson($e) {
			if ( is_numeric($e) && $e > 0 ) {
				$query = "DELETE FROM dropoff_lessons WHERE lid = $e";
				return mysql_query($query);	
			}
			else {
				return false;
			}			
		}

		public function insertDOLesson() {
			$query = "INSERT INTO dropoff_lessons ( 
				course_id,
				user_id,
				lesson_title, 
				sequence, 
				content, 
				status ) 
			VALUES ( 
				$this->course_id, 
				$this->user_id,
				'$this->lesson_title', 
				$this->sequence, 
				'$this->content', 
				'$this->status' )";

			// echo $query; exit;
			$valid = mysql_query( $query );
			$this->lid = mysql_insert_id();
			return $valid;
		}

		public function updateDOLesson($e) {
			$query = "UPDATE dropoff_lessons SET 
				course_id = $this->course_id, 
				lesson_title = '$this->lesson_title', 
				sequence = $this->sequence, 
				content = '$this->content', 
				status = '$this->status' WHERE lid = $this->lid";

			//echo $query;exit;
			$valid = mysql_query( $query );
			return $valid;
		}

		public function validateDOLesson() {
			global $message;
			$valid = true;
			if ( empty($this->lesson_title) ) {
				$valid = false;
				$message .= "You must enter a Lesson Title.<br />\n";
			}
			if ( empty($this->content) ) {
				$valid = false;
				$message .= "You must enter some content.<br />\n";
			}
			return $valid;
		}  
  }
?>