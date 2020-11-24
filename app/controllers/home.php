<?php 

	class Home extends Controller{

		//homepage
		public function index(){
			$this->view_header_and_aside();
			$rls_set = $this->load->home->get_noticeboard_data();
			if($rls_set){
				$rls_set = $rls_set->fetchAll();
				$this->load->view("common/home",["header"=>$this->header_data,"rls_set"=>$rls_set]);
				$this->load->view("templates/footer");
			}else{
				echo "header data not found.";
			}
		}

		//contact us page in homepage
		public function contact(){
			$this->view_header_and_aside();
			$this->load->view("common/contact",['header'=>$this->header_data]);
			$this->load->view("templates/footer");
		}

		//about page in homepage
		public function about(){
			$this->view_header_and_aside();
			$this->load->view("common/about",['header'=>$this->header_data]);
			$this->load->view("templates/footer");
		}
	}