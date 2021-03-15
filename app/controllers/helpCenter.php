
<?php 

	class HelpCenter extends Controller{

		public function __construct(){
			parent::__construct();
		}

		public function help_center(){
			$this->view_header_and_aside();
			$this->load->view("common/help_center");
			$this->load->view("templates/footer");
		}
	}

 ?>