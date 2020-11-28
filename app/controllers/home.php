<?php 

	class Home extends Controller{

		public function __construct() {
			parent::__construct();
		}
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

		//homepage-setting page
		public function settings_school(){
		
		$con = new Database();
			$row = $this->load->home->get_header_data();
			foreach ($row as $data) {
				$result['school_'.$data['name']] = $data['value'];
			}

		if(isset($_POST['submit'])){
		$is_ok = 1;
		$errors = array();
		$info = array();
		$msg=array();
		$field_errors = array();


      	$target = "public/assets/img/school_badge/";
		$school['name'] = $_POST['school-name']; 
		$school['address'] = $_POST['school-address']; 
		$school['contact_number'] = $_POST['school-contact-number']; 
		$school['email'] = $_POST['school-email'];
		$school['vision'] = $_POST['school-vision'];
		$school['mission'] = $_POST['school-mission'];
		$school['principal_message'] = $_POST['school-principal-message'];
		$school['welcome_message'] = $_POST['school-welcome-message'];
		$school['description'] = $_POST['school-description'];
		$school['website'] = $_POST['school-website'];
		$school['brief_history'] = $_POST['school-brief-history'];
		$school['fb_id'] = $_POST['school-fb-id'];
		$school['twitter_id'] = $_POST['school-twitter-id'];
		$school['insta_id'] = $_POST['school-insta-id'];
		$school['linkedin_id'] = $_POST['school-linkedin-id'];

		$required_fields = array();
		$required_fields['school-name']=[0,30,1,"School Name"];
		$required_fields['school-address']=[0,30,1,"School Address"];

		$c_no = validate_contact_number($_POST['school-contact-number']);
		if($c_no !== 1){
			$field_errors['school-contact-number'] = $c_no;
		}

		if(!valid_email($school['email'])){
			$field_errors["school-email"] = "Invalid email address.";
		}

		$required_fields['school-vision']=[0,50,1,"School Vision"];
		$required_fields['school-mission']=[0,150,1,"School Mission"];
		$required_fields['school-principal-message']=[0,550,1,"School Principal Message"];
		$required_fields['school-welcome-message']=[0,550,1,"School Welcome Message"];
		$required_fields['school-description']=[0,1000,1,"School Description"];
		$required_fields['school-website']=[0,30,1,"School Website"];
		$required_fields['school-brief-history']=[0,2000,1,"School Brief History"];
		$required_fields['school-fb-id']=[0,50,1,"School Facebook ID"];
		$required_fields['school-twitter-id']=[0,50,1,"School Twitter ID"];
		$required_fields['school-insta-id']=[0,50,1,"School Instagram ID"];
		$required_fields['school-linkedin-id']=[0,50,1,"School LinkedIn ID"];

		$field_errors = array_merge($field_errors,check_input_fields($required_fields));


		if(isset($_FILES['school-badge']['tmp_name']) && !empty($_FILES['school-badge']['tmp_name'])){
			$result = upload_file($_FILES['school-badge'],$target,2000000);
			if($result !== 1){
				$errors['school-badge'] = $result;
			}
			else{
				$info['school-badge'] = "Updated Successfully";
			}			
			if($result == 1){
				$school['badge'] = $_FILES['school-badge']['name'];
			}

		}

		if(isset($_FILES['school-flag']['tmp_name']) && !empty($_FILES['school-flag']['tmp_name'])){
			$result = upload_file($_FILES['school-flag'],$target,2000000);
			if($result !== 1){
				$errors['school-flag'] = $result;
			}
			else{
				$info['school-flag'] = "Updated Successfully";
			}	

			if($result == 1){
				$school['flag'] = $_FILES['school-flag']['name'];
			}

		}

		if(isset($_FILES['school-image']['tmp_name']) && !empty($_FILES['school-image']['tmp_name'])){
			$result = upload_file($_FILES['school-image'],$target,2000000);
			if($result !== 1){
				$errors['school-image'] = $result;
			}
			else{
				$info['school-image'] = "Updated Successfully";
			}	

			if($result == 1){
				$school['image'] = $_FILES['school-image']['name'];
			}

		}

		if(isset($_FILES['school-map']['tmp_name']) && !empty($_FILES['school-map']['tmp_name'])){
			$result = upload_file($_FILES['school-map'],$target,2000000);
			if($result !== 1){
				$errors['school-map'] = $result;
			}
			else{
				$info['school-map'] = "Updated Successfully";
			}	

			if($result == 1){
				$school['map'] = $_FILES['school-map']['name'];
			}

		}

		if(isset($_FILES['bg-image']['tmp_name']) && !empty($_FILES['bg-image']['tmp_name'])){
			$result = upload_file($_FILES['bg-image'],$target,2000000);
			if($result !== 1){
				$errors['bg-image'] = $result;
			}
			else{
				$info['bg-image'] = "Updated Successfully";
			}	

			if($result == 1){
				$school['background'] = $_FILES['bg-image']['name'];
			}

		}

		if(empty($errors) && empty($field_errors)){
			foreach ($school as $name => $value) {
				//$result = $con->insert("website_data",array("category"=>"school","name"=>$name, "value"=>$value));
				//if(!$result){
					$result = $con->update("website_data",array("value"=>$value),array("name"=>$name));
					

				//}
			}
			
			$info['data']="Updated Successfully";
		}

		}
			$row = $this->load->home->get_header_data();
			foreach ($row as $data) {
				$re['school_'.$data['name']] = $data['value'];
			}
	
			
			if( !empty($errors) || !empty($field_errors) ){
				$this->view_header_and_aside();
				$this->load->view("common/settings-school",['header'=>$this->header_data,"field_errors"=>$field_errors,'result'=>$re,'errors'=>$errors]);
			}
			/*elseif(isset($info) && !empty($info)){
				$this->view_header_and_aside();
				$this->load->view("common/settings-school",['header'=>$this->header_data,"field_errors"=>$field_errors,'result'=>$re,'info'=>$info,]);
			}*/
			/*elseif((isset($errors) && !empty($errors)) && (isset($info) && !empty($info)) ){
				$this->view_header_and_aside();
				$this->load->view("common/settings-school",['header'=>$this->header_data,"field_errors"=>$field_errors,'info'=>$info,'result'=>$re,'info'=>$info,'errors'=>$errors]);
			}*/
			else{

				$this->view_header_and_aside();
				if(!empty($info)){
				$this->load->view("common/settings-school",['header'=>$this->header_data,'result'=>$re,'info'=>$info]);
				}
				else{
				$this->load->view("common/settings-school",['header'=>$this->header_data,'result'=>$re]);	
				}
			}
			
			$this->load->view("templates/footer");
		}

		public function setting_notice(){

		}


	}