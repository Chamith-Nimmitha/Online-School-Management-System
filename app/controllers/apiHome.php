
<?php 

	class ApiHome extends Controller{
		public function __construct() {
			parent::__construct();
		}

		public function add_notice(){
			$notice['text'] = trim($_POST['text']);
			$file = NULL;
			if(!empty($_FILES['img']['name'])){
				$notice['image'] = $_FILES['img']['name'];
				$file = $_FILES['img'];
			}
			$notice['reference'] = $_POST['reference'];

			$this->load->model("home");
			$result = $this->load->home->add_notice($notice,$file);
			if($result){
				echo json_encode( ['success'=>"1"]);
			}else{
				echo json_encode( ['success'=>"0"]);
			}
			return;
		}

		// get a ntice
		public function get_notice($notice_id){

			$this->load->model("home");
			$result = $this->load->home->get_notice($notice_id);
			if($result){
				echo json_encode(["success"=>1,"data"=>$result->fetch()]);
			}else{
				echo json_encode(["success"=>0, "error"=>"Notice Not Found."]);
			}
			return;
		}

		// update a notice
		public function update_notice($notice_id){
			$this->load->model("notice");

			$notice['text'] = trim($_POST['text']);
			$file = NULL;
			$notice['image'] = NULL;
			if(!empty($_FILES['img']['name'])){
				$notice['image'] = $_FILES['img']['name'];
				$file = $_FILES['img'];
			}
			$notice['reference'] = $_POST['reference'];

			$result = $this->load->home->update_notice($notice_id,$notice,$file);
			if($result){
				echo json_encode(["success"=>1]);
			}else{
				echo json_encode(["success"=>0,"error"=>"Update Failed."]);
			}
		}
	}
 ?>