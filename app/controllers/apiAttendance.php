<?php 

	class apiAttendance extends Controller{
		public function __construct() {
			parent::__construct();
		}

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
	}

 ?>