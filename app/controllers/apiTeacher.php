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
		$result_set = $this->load->teachers->get_list($start,$per_page,$id,$t_name);
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

				$row .= "<td><a href=". set_url('teacher/subject/list/').$result['id'].">List</a>";
				$row .= "<td><a href=". set_url('teacher/update/').$result['id'].">Update</a>";
				$row .= "<td><a href=". set_url('teacher/delete/').$result['id']." onclick=\"return confirm('Are you sure to delete?')\">Delete</a>";
				$row .= "</tr>";
			}
			$data['rows'] = $row;
			echo json_encode($data);
		}else{
			$row =  "<tr><td colspan=8 class='text-center bg-red'>Teacher not found...</td></tr>";
			$data['rows'] = $row;
			$data['count'] = 0;
			echo json_encode($data);
		}

	}


}
?>