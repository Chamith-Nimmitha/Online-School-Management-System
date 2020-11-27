<?php
     class Teacher extends Controller{
		
		//view the list of teachers
		public function teacher_list_view(){
		    $this->view_header_and_aside();
            $this->load->view("teacher/teacher_list_view");
            $this->load->view("templates/footer");
		}
		//register new teachers
		public function teacher_registration_form(){

			$this->view_header_and_aside();
            $this->load->view("teacher/teacher_registration_form");
            $this->load->view("templates/footer");
		}

		//update teacher details
		public function teacher_list_update(){

			$this->view_header_and_aside();
            $this->load->view("teacher/teacher_list_update");
            $this->load->view("templates/footer");
		}
	 }
?>