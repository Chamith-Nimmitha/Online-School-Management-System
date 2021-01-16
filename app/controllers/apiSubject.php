<?php 

	class ApiSubject extends Controller{

		public function __construct() {
			parent::__construct();
		}

		public function search(){
			$post = json_decode(file_get_contents("php://input"));

			$subject_id = addslashes(trim($post->id));
			$subject_name = $subject_id; // this is true for only this situation
			$subject_code = $subject_id; // this is true for only this situation
			if(empty($subject_id) && strlen($subject_id) ===0){
				$subject_id = NULL;
				$subject_name = NULL;
				$subject_code = NULL;
			}
			$grade = $post->grade;
			if($grade === NULL || $grade === "all"){
				$grade = NULL;
			}
			$medium = $post->medium;
			if($medium === NULL || $medium === "all"){
				$medium = NULL;
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
			$this->load->model("subjects");
			 $result_set = $this->load->subjects->get_subject_list($start,$per_page,$subject_id,$subject_name,$subject_code,$grade,$medium);
			$data['count'] = $this->load->subjects->get_count()->fetch()['count'];

			if($result_set && !empty($result_set)){
				$body = "";
				foreach ($result_set as $result) {
					$body .="<tr>";
					$body .= "<td>".$result['id']."</td>";
					$body .= "<td>".$result['grade']."</td>";
					$body .= "<td>".$result['medium']."</td>";
					$body .= "<td>".$result['name']."</td>";
					$body .= "<td>".$result['code']."</td>";
					$body .= "<td class='text-center'>
								<div class='login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center'>
									<a class='btn btn-blue' href='".set_url('subject/update/'.$result['id'])."'>Update</a>
			    				</div>
							</td>";
					$body .= "<td class='text-center'>
								<div class='login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center'>
									<a class='btn' title='Delete' href='".set_url('subject/delete/'.$result['id'])."' onclick=\"show_dialog(this,'Delete message','Are you sure to delete?')\"><i class='fas fa-trash delete-button'></i></a>
			    				</div>
							</td>";
					$body .= "</tr>";
				}
				$data['body'] = $body;
				echo json_encode($data);
			}else{
				$body =  "<tr><td colspan=7 class='text-center bg-red'>Subjects not found...</td></tr>";
				$data['body'] = $body;
				$data['count'] = 0;
				echo json_encode($data);
			}
		}
	}

 ?>