<?php 

class ApiAdmission extends Controller{
	public function __construct(){
		parent::__construct();
	}

	public function search($type,$value=""){
		$data["type"] = $type;
		$data["data"] = $value;
		$this->load->view("../includes/getdata/admission_list",$data);
	}

}
?>
