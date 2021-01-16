<?php 

class ApiTeacher extends Controller{
	public function __construct(){
		parent::__construct();
	}

	public function search(){
		$post = json_decode(file_get_contents("php://input"));
		$t_name = $post->name;
		$id = $post->id;
		if(empty($id) && strlen($id) ===0){
			$id = NULL;
			$t_name =NULL;
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
		$this->load->model("teachers");
		$result_set = $this->load->teachers->get_teacher_list($start,$per_page,$id,$t_name);
		$data['count'] = $this->load->teachers->get_count()->fetch()['count'];

		if($result_set && count($result_set) > 0){
			$row = "";
			foreach ($result_set as $result) {
				$row .="<tr>";
				$row .= "<td>".$result['id']."</td>";
				$row .= "<td>".stripslashes($result['name_with_initials'])."</td>";
				$row .= "<td>".$result['email']."</td>";
				$row .= "<td>".$result['contact_number']."</td>";
				$row .= "<td>".$result['nic']."</td>";

				$row .= "<td class='text-center'><a class='btn btn-blue t-d-none p-1' href=". set_url('teacher/subject/list/').$result['id'].">List</a>";
				if($_SESSION['role']==='admin'){
					$row .= "<td class='text-center'><a class='btn btn-blue t-d-none p-1' href=". set_url('teacher/update/').$result['id'].">Update</a>";
					$row .= "<td class='text-center'><a title='Delete' href=". set_url('teacher/delete/').$result['id']." onclick=\"show_dialog(this,'Delete message','Are you sure to delete?')\"><i class='fas fa-trash delete-button'></i></a>";
				}
				$row .= "</tr>";
			}
			$data['rows'] = $row;
			echo json_encode($data);
		}else{
			$row =  "<tr><td colspan=8 class='text-center bg-red'>Teacher Not Found...</td></tr>";
			$data['rows'] = $row;
			$data['count'] = 0;
			echo json_encode($data);
		}

	}


	public function subject($input){
		//$post = json_decode(file_get_contents("php://input"));
		//echo json_encode($post);
		//$id=$post->id;
		//echo $post->id;

		/*if(empty($id) && strlen($id) ===0){
			$id = NULL;
		}*/

		//if($id!==NULL){
			//$id = $_GET['id'];
		if(is_numeric($input)){
		$id=$input;
		$this->load->model("subject");
		$this->load->subject->set_by_id($id);
		$sub_data=$this->load->subject->get_data();
		}
		else{
			$code = $input;
			$this->load->model("subject");
			$this->load->subject->set_by_code($code);
			$sub_data=$this->load->subject->get_data();
		}

		if(isset($sub_data['id'])){
			echo json_encode($sub_data);}
		else{
			echo "error";
		}

		//}
		/* if(isset($_GET['code'])){
			$code = $_GET['code'];
			$this->load->model("subject");
			$this->load->subject->set_by_code($code);
			$sub_data=$this->load->subject->get_data();
			$data1['data'] = $sub_data;
			echo json_encode($sub_data);
		}
		else{
			echo 'error1';
		}*/

		/*if(isset($_GET['name'])){
			$name = $_GET['name'];
		}*/


	}

		public function delete_teacher_subject($subject_id,$teacher_id){
			$con=new Database();
			return $con->delete("teacher_subject",["subject_id"=>$subject_id,"teacher_id"=>$teacher_id]);

		}


}
?>