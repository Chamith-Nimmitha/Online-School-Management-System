<?php 

	class apiMarks extends Controller{
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
	                				<a class='btn btn-blue' href='". set_url('marks/classroom/view/'.$result['id']).'/1'."'>View</a>
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


		// classroom marks search
		public function classroom_marks_search(){
			$term = $_POST['term'];
			$year= $_POST['year'];

			if(empty($student_id)){
				$student_id = NULL;
			}

			if(empty($date)){
				$date =  date("Y-m-d");
			}



			$con = new Database();
			$marks[][]="";
			$this->load->model("classroom");
			$this->load->model("marks");
			$result = $this->load->classroom->set_by_id($classroom_id);
			if(!$result){
				echo "classroom not found.";
				exit();
			}
			$data['classroom_data'] = $this->load->classroom->get_data();
			$data['student_list'] = $this->load->marks->get_classroom_marks($classroom_id);
			$data["classroom_id"] = $classroom_id;
		}
	}
?>