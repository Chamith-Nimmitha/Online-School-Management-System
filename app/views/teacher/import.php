<?php
class Import extends Controller {
	function __construct() {
		parent::__construct();
		/* Session::init(); */
	}
	function import(){
			if(isset($_POST['save']))
			{
					$file = $_FILES['file']['tmp_name'];
					$handle = fopen($file, "r");
					$c = 0;/*
					while(($filesop = fgetcsv($handle, 1000, ",")) !== false)*/
					{
						$name = $filesop[0];
						$email = $filesop[1];
						$contact = $filesop[2];
						$data = array(
							'id'=> null,
							'name' =>$name,
							'email' =>$email,
							'contact' => $contact
						);
						if($c<>0){					/*SKIP THE FIRST ROW*/
							$this->model->submit_index($data);
						}
						$c = $c + 1;
					}
					echo "Data imported successfully !"	;
			}
			$this->view->render('hello/import_data');
	}
	
}