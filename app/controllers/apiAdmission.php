<?php 

class ApiAdmission extends Controller{
	public function __construct(){
		parent::__construct();
	}

	public function search(){
		$post = json_decode(file_get_contents("php://input"));
		$data["type"] = $post->type;
		$data["data"] = $post->value;
		$this->load->view("../../public/assets/api/admission_list",$data);
	}

}
?>
