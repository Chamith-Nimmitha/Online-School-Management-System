<?php 

class ApiAdmission extends Controller{
	public function __construct(){
		parent::__construct();
	}

	// search Read, Unread, Accepted admissions
	public function search(){
		$post = json_decode(file_get_contents("php://input"));
		$state = $post->type;
		if($state === NULL || $state === "all"){
			$state = ["Read","Unread","Accepted"];
		}else{
			$state = [$state];
		}
		$id = $post->id;
		if(empty($id) && strlen($id) ===0){
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
		$result_set = $this->load->admission->get_list($start,$per_page,$id,$id,$id,$state);
		$data['count'] = $this->load->admission->get_count()->fetch()['count'];
		if($result_set && $result_set->rowCount() >0){
			$body = "";
			foreach ($result_set as $result) {
				$body .="<tr>";
				$body .= "<td>".$result['id']."</td>";
				$body .= "<td>".stripslashes($result['name_with_initials'])."</td>";
				$body .= "<td>".$result['grade']."</td>";
				$body .= "<td class='text-center'>".stripslashes($result['address'])."</td>";
				if($result['state'] == 'Accepted'){
					$body .= "<td class='text-center' style='background:#009922'>".$result['state']."</td>";
				}else if($result['state'] == 'Read'){
					$body .= "<td class='text-center' style='background:#ffffff'>".$result['state']."</td>";
				}else if($result['state'] == 'Unread'){
					$body .= "<td class='text-center' style='background:#00ffff'>".$result['state']."</td>";
				}else{
					$body .= "<td class='text-center' style='background:#333333;color:white;'>".$result['state']."</td>";
				}

				$body .= "<td class='text-center'><a class='btn btn-blue p-1 pr-2 pl-2' href=". set_url('admission/view/').$result['id'].">View</a>";
				$body .= "</tr>";
			}
			$data['body'] = $body;
			echo json_encode($data);
		}else{
			$body =  "<tr><td colspan=7 class='text-center bg-red'>Admissions Not Found...</td></tr>";
			$data['body'] = $body;
			$data['count'] = 0;
			echo json_encode($data);
		}
	}

	// search Rejected, Registered, NotInterviewed admissions
	public function u_search(){
		$post = json_decode(file_get_contents("php://input"));
		$state = $post->type;
		if($state === NULL || $state === "all"){
			$state = ["Rejected","Registered","Not Interviewed"];
		}else{
			$state = [$state];
		}
		$id = $post->id;
		if(empty($id) && strlen($id) ===0){
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
		$result_set = $this->load->admission->get_list($start,$per_page,$id,$id,$id,$state);
		$data['count'] = $this->load->admission->get_count()->fetch()['count'];
		if($result_set && $result_set->rowCount() >0){
			$body = "";
			foreach ($result_set as $result) {
				$body .="<tr>";
				$body .= "<td>".$result['id']."</td>";
				$body .= "<td>".stripslashes($result['name_with_initials'])."</td>";
				$body .= "<td>".$result['grade']."</td>";
				$body .= "<td class='text-center'>".stripslashes($result['address'])."</td>";
				if($result['state'] == 'Registered'){
					$body .= "<td class='text-center' style='background:#ff5555'>".$result['state']."</td>";
				}else if($result['state'] == 'Not Interviewed'){
					$body .= "<td class='text-center' style='background:#00ffff'>".$result['state']."</td>";
				}else if($result['state'] == 'Rejected'){
					$body .= "<td class='text-center' style='background:#ffffff'>".$result['state']."</td>";
				}else{
					$body .= "<td class='text-center' style='background:#333333;color:white;'>".$result['state']."</td>";
				}

				$body .= "<td class='text-center'><a class='btn btn-blue p-1 pr-2 pl-2' href=". set_url('admission/view/').$result['id'].">View</a>";
				$body .= "</tr>";
			}
			$data['body'] = $body;
			echo json_encode($data);
		}else{
			$body =  "<tr><td colspan=7 class='text-center bg-red'>Admissions Not Found...</td></tr>";
			$data['body'] = $body;
			$data['count'] = 0;
			echo json_encode($data);
		}
	}

	// check parent id is valid
	public function parent_validation(){
		$post = json_decode(file_get_contents("php://input"));
		$parent_id = $post->parent_id;

		$this->load->model("admission");
		$result = $this->load->admission->check_parent_id($parent_id);
		if($result && $result->rowCount() == 1){
			echo json_encode($result->fetch()["name_with_initials"]);
		}else{
			echo "false";
		}
		return;
	}
}
?>
