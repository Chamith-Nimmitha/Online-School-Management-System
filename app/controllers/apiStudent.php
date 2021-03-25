<?php 

	class ApiStudent extends Controller{
		public function __construct() {
			parent::__construct();
		}

		public function search(){
			$post = json_decode(file_get_contents("php://input"));
			$student_id = $post->id;
			$student_name = $post->name;
			$grade = $post->grade;
			$class = $post->class;
			// for pagination
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

			$this->load->model("studentsInfo");

            if(empty($student_id)){
                $student_id = NULL;
                $student_name = NULL;
            }
            if($grade == 'all'){
                $grade = NULL;
            }
            if($class == 'all'){
                $class = NULL;
            }
            $result_set = $this->load->studentsInfo->get_student_list($start,$per_page,$student_id,$student_name,$grade,$class);
            $data['count'] = $this->load->studentsInfo->get_count()->fetch()['count'];
            if($result_set && count($result_set) > 0){
            	$row = "";
				foreach ($result_set as $result) {
					$row .="<tr>";
					$row .= "<td>".$result['id']."</td>";
					$row .= "<td>".$result['name_with_initials']."</td>";
					$row .= "<td class='text-center'>".$result['grade']."</td>";
					$row .= "<td class='text-center'>".$result['class']."</td>";
					$row .= "<td>".$result['contact_number']."</td>";
					$row .= "<td class='text-center'>";
					if( $result['is_deleted'] ==0 ){
						$row .= "Active";
					}else{
						$row .= "Blocked";
					}
					$row .= "</td>";
					$row .= "<td class='text-center'><a href='timetable/view/".$result['id']."' class='btn btn-blue t-d-none p-1'>timetable</a></td>";
					$row .= "<td class='text-center'><a href='".set_url("student/exam/".$result['id'])."' class='btn btn-blue t-d-none p-1'>Marks</a></td>";
					$row .= "<td class='text-center'><a href='".set_url("profile/student/".$result['id'])."' class='btn t-d-none p-1'><i title='profile' class='fas fa-user-circle profile-button'></i></a></td>";
					if($_SESSION['role'] === "admin"){
						if($result['is_deleted'] == 0){
							$row .= "<td class='text-center'><a title='Delete' href='".set_url("student/delete/".$result['id'])."/1' class='btn t-d-none p-1' onclick=\"show_dialog(this,'Block Student','Are you sure to block student ".$result['name_with_initials']."?')\"><i class='fas fa-user-slash'></i></a></td>";
						}else if($result['is_deleted'] ==1){
							$row .= "<td class='text-center'><a title='Delete' href='".set_url("student/delete/".$result['id'])."/0' class='btn t-d-none p-1' onclick=\"show_dialog(this,'Active Student','Are you sure to active student ".$result['name_with_initials']."?')\"><i style='color:green;' class='fas fa-user-plus'></i></a></td>";
							
						}
					}
					$row .="</tr>";

				}
				$data['rows'] = $row;
				echo json_encode($data);
			}else{
				$row = "<tr><td colspan=10 class='text-center bg-red'>Students not found...</td></tr>";
				$data['rows'] = $row;
				$data['count'] = 0;
				echo json_encode($data);
			}
		}
	}


 ?>