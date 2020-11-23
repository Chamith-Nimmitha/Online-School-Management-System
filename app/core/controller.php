<?php 

	class Controller extends Load{
		protected $load;
		protected $header_data =[];
		public function __construct(){
			$this->load = new Load();
			$this->load->model("home");
			$result = $this->load->home->get_header_data();
			if($result){
				$header_result = $result->fetchAll();
				foreach ($header_result as $data) {
					$this->header_data[$data['name']] = $data['value'];
				}
				$this->load->view("templates/header",["header"=>$this->header_data]);
			}else{
				echo "header data not found.";
			}
		}
	}