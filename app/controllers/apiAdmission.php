<?php 

class ApiAdmission extends Controller{
	public function __construct(){
		parent::__construct();
	}

	public function search(){
		$post = json_decode(file_get_contents("php://input"));
		$state = $post->type;
		if($state === NULL || $state === "all"){
			$state = NULL;
		}
		$id = $post->id;
		if(empty($id)){
			$id = NULL;
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
		$this->load->model("admission");
		$result_set = $this->load->admission->get_list($start,$per_page,$id,$state);
		$data['count'] = $this->load->admission->get_count()->fetch()['count'];

		if($result_set && $result_set->rowCount() >0){
			$row = "";
			foreach ($result_set as $result) {
				$row .="<tr>";
				$row .= "<td>".$result['id']."</td>";
				$row .= "<td>".stripslashes($result['name_with_initials'])."</td>";
				$row .= "<td>".$result['grade']."</td>";
				$row .= "<td>".stripslashes($result['address'])."</td>";
				if($result['state'] == 'accepted'){
					$row .= "<td style='background:#009922'>".$result['state']."</td>";
				}else if($result['state'] == 'deleted'){
					$row .= "<td style='background:#ff5555'>".$result['state']."</td>";
				}else if($result['state'] == 'read'){
					$row .= "<td style='background:#ffffff'>".$result['state']."</td>";
				}else if($result['state'] == 'unread'){
					$row .= "<td style='background:#00ffff'>".$result['state']."</td>";
				}else{
					$row .= "<td style='background:#333333;color:white;'>".$result['state']."</td>";
				}

				$row .= "<td><a href=". set_url('admission/view/').$result['id'].">view</a>";
				$row .= "<td><a href=". set_url('admission/delete/').$result['id']." onclick=\"return confirm('Are you sure to delete?')\">delete</a>";
				$row .= "</tr>";
			}
			$data['rows'] = $row;
			echo json_encode($data);
		}else{
			$row =  "<tr><td colspan=7 class='text-center bg-red'>Admissions not found...</td></tr>";
			$data['rows'] = $row;
			$data['count'] = 0;
			echo json_encode($data);
		}
	}
}
?>
