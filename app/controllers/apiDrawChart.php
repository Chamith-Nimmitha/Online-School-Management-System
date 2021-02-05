<?php 
	
	class ApiDrawChart extends Controller{
		public function __construct() {
			parent::__construct();
		}

		// for overview particular student attendance
		public function student_attendance_overview_bar(){

			if(!isset($_POST)){
				echo 'FALSE';
				return;
			}

			$student_id = $_POST['student_id_bar'];
			$year = $_POST['year_bar'];
			$month = $_POST['month_bar'];

			if(empty($student_id)){
				echo 'FALSE';
				return;
			}

			if($year === "this"){
				$year = date('Y');
			}
			if($month === "this"){
				$month = date('m');
			}else if($month == 0){
				$month = NULL;
			}

			// get student count in classroom
			$this->load->model('student');
			$result = $this->load->student->set_by_id($student_id);
			if(!$result){
				return;
			}
			$classroom = $this->load->student->get_classroom_object();
			if(!$result){
				return;
			}
			$result = $classroom ->get_student_count();
			$student_count = $result->fetch()['count'];
			unset($classroom);

			// get classroom attendance
			$this->load->model('attendance');
			$present_result_set = $this->load->attendance->student_attendance_overview_bar($student_id,$year,$month,1);
			$absent_result_set = $this->load->attendance->student_attendance_overview_bar($student_id,$year,$month,0);
			$overrole_present = $this->load->attendance->classroom_attendance_count($student_id,$year,$month,1);
			$overrole_absent = $this->load->attendance->classroom_attendance_count($student_id,$year,$month,0);
			// $overrole_absent = $this->load->attendance->classroom_attendance_count();
			$formatted_data = ["present"=>[],"absent"=>[]];
			$labels = [];
			if($present_result_set && $absent_result_set){
				$present_result_set = $present_result_set->fetchAll();
				$absent_result_set = $absent_result_set->fetchAll();
				$overrole_present = $overrole_present->fetchAll();
				$overrole_absent = $overrole_absent->fetchAll();
				if($month == NULL){
					$formatted_data['present'] = [0,0,0,0,0,0,0,0,0,0,0,0];
					$formatted_data['absent'] = [0,0,0,0,0,0,0,0,0,0,0,0];
					$formatted_data['present_presentage'] = [0,0,0,0,0,0,0,0,0,0,0,0];
					$formatted_data['absent_presentage'] = [0,0,0,0,0,0,0,0,0,0,0,0];
					$labels = [1,2,3,4,5,6,7,8,9,10,11,12];
					for ($i=0; $i < count($labels); $i++) {
						$labels[$i] = date("F", mktime(0,0,0,$labels[$i],1,$year));
					}
					foreach ($present_result_set as $result) {
						$formatted_data["present"][$result['month']-1] = $result['count'];
					}
					foreach ($absent_result_set as $result) {
						$formatted_data["absent"][$result['month']-1] = $result['count'];
					}

					foreach ($overrole_present as $result) {
						if($result['count'] != 0){
							$formatted_data["present_presentage"][$result['month']-1] = $result['count']/$student_count;
						}
					}
					foreach ($overrole_absent as $result) {
						if($result['count'] != 0){
							$formatted_data["absent_presentage"][$result['month']-1] = $result['count']/$student_count;
						}
					}
				}else{
					$formatted_data['present'] = [0,0,0,0,0,0];
					$formatted_data['absent'] = [0,0,0,0,0,0];
					$formatted_data['present_presentage'] = [0,0,0,0,0,0];
					$formatted_data['absent_presentage'] = [0,0,0,0,0,0];
					$labels = ["week-1","week-2","week-3","week-4","week-5","week-6"];
					foreach ($present_result_set as $result) {
						if( date('W', mktime(0,0,0,1,1,$year)) != 1 ){
							$week_no = ($result['week'] +1 - (date("W", mktime(0,0,0,$month,1,$year))+1)%53);
						}else{
							$week_no = ($result['week'] +1 - date("W", mktime(0,0,0,$month,1,$year)));
						}
						$formatted_data["present"][$week_no] = $result['count'];
					}
					foreach ($absent_result_set as $result) {
						if( date('W', mktime(0,0,0,1,1,$year)) != 1 ){
							$week_no = ($result['week'] +1 - (date("W", mktime(0,0,0,$month,1,$year))+1)%53);
						}else{
							$week_no = ($result['week'] +1 - date("W", mktime(0,0,0,$month,1,$year)));
						}
						$formatted_data["absent"][$week_no] = $result['count'];
					}
					foreach ($absent_result_set as $result) {
						if( date('W', mktime(0,0,0,1,1,$year)) != 1 ){
							$week_no = ($result['week'] +1 - (date("W", mktime(0,0,0,$month,1,$year))+1)%53);
						}else{
							$week_no = ($result['week'] +1 - date("W", mktime(0,0,0,$month,1,$year)));
						}
						$formatted_data["absent"][$week_no] = $result['count'];
					}
					foreach ($overrole_present as $result) {
						if( date('W', mktime(0,0,0,1,1,$year)) != 1 ){
							$week_no = ($result['week'] +1 - (date("W", mktime(0,0,0,$month,1,$year))+1)%53);
						}else{
							$week_no = ($result['week'] +1 - date("W", mktime(0,0,0,$month,1,$year)));
						}
						if( $result['count'] != 0){
							$formatted_data["present_presentage"][$week_no] = $result['count']/$student_count;
						}
					}
					foreach ($overrole_absent as $result) {
						if( date('W', mktime(0,0,0,1,1,$year)) != 1 ){
							$week_no = ($result['week'] +1 - (date("W", mktime(0,0,0,$month,1,$year))+1)%53);
						}else{
							$week_no = ($result['week'] +1 - date("W", mktime(0,0,0,$month,1,$year)));
						}
						if ($result['count'] != 0) {
							$formatted_data["absent_presentage"][$week_no] = $result['count']/$student_count;
						}
					}
				}
				echo json_encode(["labels"=>$labels,"data"=>$formatted_data]);
			}else{
				echo "FALSE";
			}
		}

		// for dashboard student attendance
		public function dashboard_student_attendance_overview_doughnut(){
			$date = $_POST['date'];

			if(empty($date)){
				$date = date("Y-m-d");
			}
			$this->load->model('attendance');
			$present_result = $this->load->attendance->dashboard_student_attendance_overview_bar($date,1);
			$absent_result = $this->load->attendance->dashboard_student_attendance_overview_bar($date,0);

			if($present_result !== FALSE && $absent_result !== FALSE){
				echo json_encode(['present'=>$present_result,'absent'=>$absent_result]);
			}else{
				echo 'FALSE';
			}
		}

		// for overview particular teacher attendance
		public function teacher_attendance_overview_bar(){

			if(!isset($_POST)){
				echo 'FALSE';
				return;
			}

			$teacher_id = $_POST['teacher_id_bar'];
			$year = $_POST['year_bar'];
			$month = $_POST['month_bar'];

			if(empty($teacher_id)){
				echo 'FALSE';
				return;
			}

			if($year === "this"){
				$year = date('Y');
			}
			if($month === "this"){
				$month = date('m');
			}else if($month == 0){
				$month = NULL;
			}

			$this->load->model('attendance');
			$present_result_set = $this->load->attendance->teacher_attendance_overview_bar($teacher_id,$year,$month,1);
			$absent_result_set = $this->load->attendance->teacher_attendance_overview_bar($teacher_id,$year,$month,0);
			$formatted_data = ["present"=>[],"absent"=>[]];
			$labels = [];
			if($present_result_set && $absent_result_set){
				$present_result_set = $present_result_set->fetchAll();
				$absent_result_set = $absent_result_set->fetchAll();
				if($month == NULL){
					$formatted_data['present'] = [0,0,0,0,0,0,0,0,0,0,0,0];
					$formatted_data['absent'] = [0,0,0,0,0,0,0,0,0,0,0,0];
					$labels = [1,2,3,4,5,6,7,8,9,10,11,12];
					for ($i=0; $i < count($labels); $i++) {
						$labels[$i] = date("F", mktime(0,0,0,$labels[$i],1,$year));
					}
					foreach ($present_result_set as $result) {
						$formatted_data["present"][$result['month']-1] = $result['count'];
					}
					foreach ($absent_result_set as $result) {
						$formatted_data["absent"][$result['month']-1] = $result['count'];
					}
				}else{
					$formatted_data['present'] = [0,0,0,0,0,0];
					$formatted_data['absent'] = [0,0,0,0,0,0];
					$labels = ["week-1","week-2","week-3","week-4","week-5","week-6"];
					foreach ($present_result_set as $result) {
						if( date('W', mktime(0,0,0,1,1,$year)) != 1 ){
							$week_no = ($result['week'] +1 - (date("W", mktime(0,0,0,$month,1,$year))+1)%53);
						}else{
							$week_no = ($result['week'] +1 - date("W", mktime(0,0,0,$month,1,$year)));
						}
						$formatted_data["present"][$week_no] = $result['count'];
					}
					foreach ($absent_result_set as $result) {
						if( date('W', mktime(0,0,0,1,1,$year)) != 1 ){
							$week_no = ($result['week'] +1 - (date("W", mktime(0,0,0,$month,1,$year))+1)%53);
						}else{
							$week_no = ($result['week'] +1 - date("W", mktime(0,0,0,$month,1,$year)));
						}
						$formatted_data["absent"][$week_no] = $result['count'];
					}
				}
				echo json_encode(["labels"=>$labels,"data"=>$formatted_data]);
			}else{
				echo "FALSE";
			}
		}

		// for dashboard teacher attendance
		public function dashboard_teacher_attendance_overview_doughnut(){
			$date = $_POST['date'];

			if(empty($date)){
				$date = date("Y-m-d");
			}
			$this->load->model('attendance');
			$present_result = $this->load->attendance->dashboard_teacher_attendance_overview_bar($date,1);
			$absent_result = $this->load->attendance->dashboard_teacher_attendance_overview_bar($date,0);

			if($present_result !== FALSE && $absent_result !== FALSE){
				echo json_encode(['present'=>$present_result,'absent'=>$absent_result]);
			}else{
				echo 'FALSE';
			}
		}

		// for classroom attendance comparission
		public function classroom_attendance_comparission(){

			$grade = $_POST['grade'];
			$class = $_POST['class'];
			$date = $_POST['date'];
			$year = $_POST['year'];
			$month = $_POST['month'];

			if($grade == "None"){
				$grade = NULL;
			}
			if($class == "None"){
				$class = NULL;
			}
			if(empty($date)){
				$date = date('Y-m-d');
			}

			$this->load->model('attendance');
			$this->load->model('classrooms');
			$labels = [];
			$attendance_result = [];

			if($grade == NULL){
				$present_result = $this->load->attendance->dashboard_student_attendance_overview_bar($date,1);
				$absent_result = $this->load->attendance->dashboard_student_attendance_overview_bar($date,0);
				$labels = ["School Attendance"];
				if($present_result !== FALSE && $absent_result !== FALSE){
					echo json_encode(["success"=>1,"type"=>"school","labels"=>$labels, "data"=>['present'=>[$present_result],'absent'=>[$absent_result]]]);
					return;
				}else{
					echo json_encode(["success"=>0, "error"=>"Attendance Not Found."]);
					return;
				}
			}else if($class == NULL){
				$result = $this->load->classrooms->get_classroom_list(0,15,NULL,$grade);
				if(!$result){
					echo json_encode(["success"=>0,"error"=>"Classroom List Not Found."]);
					return;
				}
				foreach ($result as $cls) {
					array_push($labels,$cls['grade']."-".$cls['class']);
					$data = [];
					$result = $this->load->attendance->get_classroom_total($cls['id'],$date,1);
					if($result === FALSE){
						echo json_encode(["success"=>0,"error"=>"Attendance Not Found."]);
						return;
					}
					$data["present"] = $result;
					$result = $this->load->attendance->get_classroom_total($cls['id'],$date,0);
					if($result === FALSE){
						echo json_encode(["success"=>0,"error"=>"Attendance Not Found."]);
						return;
					}
					$data["absent"] = $result;
					$attendance_result[$cls['grade']."-".$cls['class']] = $data;
				}
				echo json_encode(["success"=>1, "type"=>"section","labels"=>$labels, "data"=>$attendance_result]);
				return;
			}else{
				$this->load->model("classroom");
				$result = $this->load->classroom->set_by_grade_class($grade,$class);
				if(!$result){
					echo json_encode(["success"=>0,"error"=>"Classroom Not Found."]);
						return;	
				}
				$class = $this->load->classroom->get_id();
				$no_of_days = date("t", strtotime("{$year}-{$month}-01"));
				$attendance_data = ["present"=>[],"absent"=>[]];
				for($i=1; $i<=$no_of_days; $i++){
					array_push($labels, $i);
					$date = "{$year}-{$month}-{$i}";
					$present = $this->load->attendance->get_classroom_total($class,$date,1);
					$absent = $this->load->attendance->get_classroom_total($class,$date,1);
					if($present === FALSE || $absent ===FALSE){
						echo json_encode(["success"=>0,"error"=>"Attendance Not Found."]);
						return;	
					}
					array_push($attendance_data["present"], $present);
					array_push($attendance_data["absent"], $absent);
				}
				echo json_encode(["success"=>1, "type"=>"classroom","labels"=>$labels, "data"=>$attendance_data]);
				return;
			};
		}
	}

 ?>