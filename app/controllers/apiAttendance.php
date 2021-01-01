<?php 

	class apiAttendance extends Controller{
		public function __construct() {
			parent::__construct();
		}

		// classroom search
		public function classroom_search(){
			$post = json_decode(file_get_contents("php://input"));

			$id = $post->id;
			if(empty($id) && strlen($id) ===0){
				$id = NULL;
			}
			$grade = $post->grade;
			if($grade === NULL || $grade === "all"){
				$grade = NULL;
			}
			$classroom = $post->classroom;
			if($classroom === NULL || $classroom === "all"){
				$classroom = NULL;
			}

			$start = 0;
			if(isset($post->per_page)){
				$per_page = $post->per_page;
			}else{
				$per_page = PER_PAGE;
			}
			if(isset($post->page)){
				$page = $post->page;
				$start = ($page-1) * $per_page;
			}else{
				$page = 1;
			}
			$this->load->model("classrooms");
			$result_set = $this->load->classrooms->get_classroom_list($start,$per_page,$id,$grade,$classroom);
			$data['count'] = $this->load->classrooms->get_count()->fetch()['count'];

			if($result_set && !empty($result_set)){
				$body = "";
				$grade = 0;
				foreach ($result_set as $result) {
					if($grade !== 0 && $grade != $result['grade']){
	        			$body .= "<tr><td colspan=8 class='text-center bg-gray'></td></tr>";
	        		}
					$body .="<tr>";
					$body .= "<td>".$result['id']."</td>";
					$body .= "<td>".$result['grade']."</td>";
					$body .= "<td>".$result['class']."</td>";
					$body .= "<td>".$result['class_teacher_id']."</td>";
					$body .= "<td class='text-center'>
								<div>
	                				<a class='btn btn-blue' href='". set_url('attendance/classroom/view/'.$result['id'])."'>View</a>
			    				</div>
							</td>";
					$body .= "</tr>";
					$grade = $result['grade'];
				}
				$data['body'] = $body;
				echo json_encode($data);
			}else{
				$body =  "<tr><td colspan=7 class='text-center bg-red'>Classrooms not found...</td></tr>";
				$data['body'] = $body;
				$data['count'] = 0;
				echo json_encode($data);
			}
		}

		// attendance search
		public function search(){
			
			$student_id = addslashes(trim($_POST['student-id']));
			$date = $_POST['date'];
			$classroom_id = $_POST['classroom_id'];

			if(empty($student_id)){
				$student_id = NULL;
			}

			if(empty($date)){
				$date =  date("Y-m-d");
			}

			$this->load->model("attendance");
			$result_set = $this->load->attendance->search($classroom_id,$student_id,$date);
			if($result_set && $result_set->rowCount() !== 0){
				$result_set = $result_set->fetchAll();
				$body = "";
				foreach ($result_set as $result) {
					$body .= "<tr>";
					$body .= "<td>{$result['id']}</td>";
					$body .= "<td>{$result['name_with_initials']}</td>";
					$body .= "<td>{$result['date']}</td>";
					$body .= "<td class='d-flex flex-col'>
                                <label for='present-".$result['id']."'>
                                    <input type='radio' id='present-".$result['id']."' name='attendance-".$result['id']."' value='1'";
                                    if(isset($result['attendance']) && $result['attendance'] === 1){
                                    	$body .= "checked='checked'";
                                    }
                                    $body .= "> Present
                                </label>
                                <label for='absent-".$result['id']."'>
                                    <input type='radio' id='absent-".$result['id']."' name='attendance-".$result['id']."' value='0'";
                                    if(isset($result['attendance']) && $result['attendance'] === 0){
                                    	$body .= "checked='checked'";
                                    }
                                    $body .= "> Absent
                                </label>
                            </td>";
					$body .= "<td><input type='text' name='note-".$result['id']."' value='".$result['note']."'></td>";
                    $body .= "<td> <a href='".set_url('student/attendance/'.$result['id'])."' class='btn btn-blue'>View Report</a></td>";
					$body .= "</tr>";
				}
				echo $body;
			}else{
				echo "<tr><td colspan=8 class='text-center bg-red'>Attendance not found...</td></tr>";
			}
		}

		public function mark_attendance(){
			if(!$this->checkPermission->check_permission("attendance","view")){
				echo "Permission denied...";
				return;
			}

			if(!isset($_POST['date_hidden'])){
				echo "form error";
				exit();
			}
			$std_list = [];
			$classroom_id = $_POST['classroom_id_hidden'];
			$date = $_POST['date_hidden'];
			if( empty($date) ){
				$date = date("Y-m-d");
			}
			foreach ($_POST as $key => $value) {
				if( strpos($key, "attendance") === 0 ){
					$exp = explode("-", $key);
					$std_list[] = ["id"=>$exp[1], "attendance"=>$value,"note"=>$_POST["note-".$exp[1]]];
				}
			}
			$this->load->model("attendance");
			$result = $this->load->attendance->mark_classroom_attendance($classroom_id,$std_list,$date);
			if($result){
				echo "TRUE";
			}else{
				"Attendance mark failed.";
			}
			unset($this->load->attendance);
		}

		// search student attendance by year,month,week
		public function student_attendance_filter(){
			date_default_timezone_set("Asia/Colombo");
			if(!$this->checkPermission->check_permission("attendance","view")){
				echo "Permission denied...";
				return;
			}

			if(!isset($_POST['year'])){
				echo "form error";
				exit();
			}

			$student_id = $_POST['student_id'];
			$year = $_POST['year'];
			$month = $_POST['month'];
			$week = $_POST['week'];

			if($year === "this"){
				$year = date('Y');
			}
			if($month === "this"){
				$month = date("m");
			}
			if($week === "this"){
				if( date('W', mktime(0,0,0,1,1,$year)) != 1 ){
					$week = (date('W')+1)%53;
				}else{
					$week = (date('W'));
				}
			}else{
				if( date('W', mktime(0,0,0,1,1,$year)) != 1 ){
					$week = (date('W', mktime(0,0,0,$month,($week-1)*7+1,$year))+1)%53;
				}else{
					$week = date('W', mktime(0,0,0,$month,($week-1)*7+1,$year));
				}
			}

			// echo $year."-" . $month ."-" . $week;
			$this->load->model("attendance");
			$result_set = $this->load->attendance->student_attendance_filter($student_id,$year,$month,$week);
			if($result_set && $result_set->rowCount() !== 0 ){
				echo json_encode($result_set->fetchAll());
			}else{
				echo "FALSE";
			}
		}
	}

 ?>