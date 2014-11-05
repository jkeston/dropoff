<?php
  	class DOClass {
   		// DOClasses properties
		public $cid;			
		public $user_id;		
		public $class_title;
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
		public function __construct( $cid, $user_id, $class_title, $session_id, $session_title, $description, $syllabus_url, $prerequisites, $start_date, $end_date, $status ) {
			$this->cid = $cid;					
			$this->user_id = $user_id;			
			$this->class_title = $class_title;		
			$this->session_id = $session_id;		
			$this->session_title = $session_title;		
			$this->description = $description;		
			$this->syllabus_url = $syllabus_url;		
			$this->prerequisites = $prerequisites;		
			$this->start_date = $start_date;			
			$this->end_date = $end_date;			
			$this->status = $status;  		
		}

		public static function getDOClasses($e) {
			global $class_status;
			$query = "SELECT c.*,u.first_name,u.last_name,u.uid FROM dropoff_classes c, dropoff_users u WHERE u.uid = c.user_id ";
			if ( is_numeric($e) && $e > 0 ) {
				$query .= " AND c.user_id = $e";
			}
			else if ( in_array($e, $class_status) ) {
				$query .= " AND c.status = '$e'";				
			}
			$result = mysql_query($query);
			return $result;
		}
		public static function getDOClass($e) {
			$query = "SELECT * FROM dropoff_classes WHERE cid = $e";
			$result = mysql_query($query);
			if ( $row = mysql_fetch_array($result) ) {
				return new DOClass($row['cid'],$row['user_id'],$row['class_title'],$row['session_id'],$row['session_title'],$row['description'],$row['syllabus_url'],$row['prerequisites'],$row['start_date'],$row['end_date'],$row['status']);
			}
			else {
				return false;
			}
		}

		public static function deleteDOClass($e) {
			if ( is_numeric($e) && $e > 0 ) {
				$query = "DELETE FROM dropoff_classes WHERE cid = $e";
				return mysql_query($query);	
			}
			else {
				return false;
			}			
		}

		public function insertDOClass() {
			$query = "INSERT INTO dropoff_classes ( 
				user_id, 
				class_title, 
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
				'$this->class_title', 
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

		public function updateDOClass($e) {
			$query = "UPDATE dropoff_classes SET 
				user_id = $this->user_id, 
				class_title = '$this->class_title', 
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

		public function validateDOClass() {
			global $message;
			$valid = true;
			if ( empty($this->class_title) ) {
				$valid = false;
				$message .= "You must enter a Class Title.<br />\n";
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

			// echo $query; exit;
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

		public static function getDOUsers() {
			$query = "SELECT * FROM dropoff_users ";
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
   	}

   	class DOProject {
		public $pid;		
		public $user_id;			
		public $class_id;		
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

		public function __construct( $pid, $user_id, $class_id, $project_title, $description, $due_date, $submit_start, $submit_end, $points, $project_text_req, $project_url_req, $project_file_req, $enroll_date, $status ) {				
			$this->pid = $pid;		
			$this->user_id = $user_id;			
			$this->class_id = $class_id;		
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
				class_id,
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
				$this->class_id,
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
				class_id = $this->class_id, 
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

		public static function getDOProjects($e) {
			global $class_status;
			$query = "SELECT p.*,u.first_name,u.last_name,c.class_title FROM dropoff_projects p,dropoff_users u,dropoff_classes c WHERE u.uid = p.user_id AND c.cid = p.class_id ";
			if ( is_numeric($e) && $e > 0 ) {
				$query .= " AND p.user_id = $e";
			}
			else if ( in_array($e, $class_status) ) {
				$query .= " AND p.status = '$e'";				
			}
			$result = mysql_query($query);
			//echo $query; exit;
			return $result;
		}

		public static function getDOProject($e) {
			$query = "SELECT * FROM dropoff_projects WHERE pid = $e";
			//echo $query; exit;
			$result = mysql_query($query);
			if ( $row = mysql_fetch_array($result) ) {
				return new DOProject($row['pid'], $row['user_id'], $row['class_id'], $row['project_title'], $row['description'], $row['due_date'], $row['submit_start'], $row['submit_end'], $row['points'], $row['project_text_req'], $row['project_url_req'], $row['project_file_req'], $row['enroll_date'], $row['status']);
			}
			else {
				return false;
			}
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
	}

?>




