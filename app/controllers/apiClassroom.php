<?php 

	class apiClassroom extends Controller{
		public function __construct() {
			parent::__construct();
		}

		public function get_grades($category){
			$data['category'] = $category;
			$this->load->view("../../public/assets/api/classrooms",$data);
		}

		public function search(){
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
	        			$body .= "<tr><td colspan=9 class='text-center p-0 bg-gray'></td></tr>";
	        			$body .= "<tr><td colspan=9 class='text-center bg-gray'></td></tr>";
	        		}
					$body .="<tr>";
					$body .= "<td>".$result['id']."</td>";
					$body .= "<td>".$result['grade']."</td>";
					$body .= "<td>".$result['class']."</td>";
					$body .= "<td>";
					if(!empty($result['class_teacher_id'])){
						$body .= $result['class_teacher_id'];
					}else{
						$body .= 'Not Asign';
					}
					$body .="</td>";
					$body .= "<td>
								<div class='login_buttons col-12 col-md-12 d-flex justify-content-center align-items-center'>
	                				<a class='btn btn-blue p-1' href='".set_url('classroom/student/list/'.$result['id'])."'>List</a>";
	                				if($_SESSION['role']==='admin'){
	                					$body .= "<a class='btn btn-blue p-1 ml-3' href='".set_url('classroom/student/add/'.$result['id'])."'>Add</a>";
	                				}

	    				$body .="</div>
							</td>";
					$body .= "<td class='text-center'>";
						if($_SESSION['role']==='admin'){
                			$body .= "<a class='btn btn-blue p-1' href='". set_url('classroom/timetable/'.$result['id'])."'>View</a>";
            			}else{
                			$body .= "<a class='btn btn-blue p-1' href='".set_url('classroom/timetable/view/'.$result['id'])."'>View</a>";
            			}
					$body .= "</td>";
                    if($_SESSION['role']==='admin'){							
						$body .= "<td>
									<div class='login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center'>
		                				<a class='btn btn-blue p-1' href='".set_url('classroom/subjects/'.$result['id'])."'>Subjects</a>
				    				</div>
								</td>";
						$body .= "<td>
									<div class='login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center'>
		                				<a class='btn btn-blue p-1' href='".set_url('classroom/update/'.$result['id'])."'>Update</a>
				    				</div>
								</td>";
						$body .= "<td>
									<div class='login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center'>
										<a class='btn p-1' title='Delete' href='".set_url('classroom/delete/'.$result['id']) ."' onclick=\"show_dialog(this,'Delete message','Are you sure to delete?')\"><i class='fas fa-trash delete-button'></i></a>
				    				</div>
								</td>";
					}
					$body .= "</tr>";
					$grade = $result['grade'];
				}
				$data['body'] = $body;
				echo json_encode($data);
			}else{
				$body =  "<tr><td colspan=8 class='text-center bg-red'>Classrooms not found...</td></tr>";
				$data['body'] = $body;
				$data['count'] = 0;
				echo json_encode($data);
			}
		}

		// update classroom timetable 
		function update_timetable(){
			$_POST = json_decode( file_get_contents("php://input"),true);
			// print_r(json_decode(json_encode( $_POST)),true);
			$classroom_id = $_POST['classroom_id'];
			// return;
			$time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];
			$day_map = ["1"=>"mon","2"=>"tue","3"=>"wed","4"=>"thu","5"=>"fri"];

			$timetable = $_POST['timetable'];
			// update teacher timetable
			$subjects = ['General'=>[], 'Optional'=>[], 'Other'=>[]];
			foreach ($_POST['subjects']["G"] as $key => $value) {
				array_push($subjects['General'], ["id"=>$key,"teacher_id"=>$value['teacher_id'],"periods"=>$value['periods']]);
			}

			// load classroom model
			$this->load->model("classroom");
			$found_classroom = $this->load->classroom->set_by_id($classroom_id);
			if(!$found_classroom){
				echo "Classroom Not Found.";
				exit();
			}

			// when update classroom timetable
			$found_timetable = $this->load->classroom->get_timetabel_object();
			$all_data = [];
			foreach ($timetable as $value) {
				$value = json_decode($value,true);
				$td = [];
				$td['day'] = $value['day'];
				$td['period'] = $value["period"];
				$td['task'] = $value['task'];
				array_push($all_data, $td);
			}
			try {
				if($found_timetable){
					$result = $found_timetable->update_timetable($all_data,$classroom_id,$subjects);
					if(!$result){
						throw new PDOException();
					}
				}else{
					$result = $found_timetable->create();
					if(!$result){
						throw new PDOException();
					}
					$result = $found_timetable->update_timetable($all_data,$classroom_id,$subjects);
					if(!$result){
						throw new PDOException();
					}
				}
				$success = 1;
			} catch (Exception $e) {
				$success = 0;
			}
			echo json_encode( ["success"=>$success ] );
		}


		// add a new notice
		public function add_notice(){

			$classroom_id = $_POST['classroom_id'];
			$notice['title'] = trim($_POST['title']);
			$notice['classroom_id'] = $_POST['classroom_id'];
			$file = NULL;
			if(!empty($_FILES['img']['name'])){
				$notice['image'] = $_FILES['img']['name'];
				$file = $_FILES['img'];
			}
			$notice['description'] = $_POST['description'];
			$notice['expire'] = $_POST['expire_date'];

			$this->load->model("classroom");
			$this->load->classroom->set_by_id($classroom_id);
			$result = $this->load->classroom->add_notice($notice,$file);
			if($result){
				echo json_encode( ['success'=>"1"]);
			}else{
				echo json_encode( ['success'=>"0"]);
			}
			return;
		}

		// get a ntice
		public function get_notice($notice_id){

			$this->load->model("classroom");
			$result = $this->load->classroom->get_notice($notice_id);
			if($result){
				echo json_encode(["success"=>1,"data"=>$result->fetch()]);
			}else{
				echo json_encode(["success"=>0, "error"=>"Notice Not Found."]);
			}
			return;
		}
		// update a notice
		public function update_notice($notice_id){
			$this->load->model("classroom");

			$notice['title'] = trim($_POST['title']);
			$file = NULL;
			$notice['image'] = NULL;
			if(!empty($_FILES['img']['name'])){
				$notice['image'] = $_FILES['img']['name'];
				$file = $_FILES['img'];
			}
			$notice['description'] = $_POST['description'];
			$notice['expire'] = $_POST['expire_date'];

			$result = $this->load->classroom->update_notice($notice_id,$notice,$file);
			if($result){
				echo json_encode(["success"=>1]);
			}else{
				echo json_encode(["success"=>0,"error"=>"Update Failed."]);
			}
		}
	}

 ?>