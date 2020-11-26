<?php

    class Teacher extends Controller{
        public function teacher_registration(){

            $errors = array();
            $infomation = "";
            $error = "";

            if(isset($_POST['submit'])){

                $name_with_initials = addslashes($_POST['name_with_initials']);
				$first_name = addslashes($_POST['first_name']);
				$middle_name = addslashes($_POST['middle_name']);
				$last_name = addslashes($_POST['last_name']);
				$gender = addslashes($_POST['gender']);
				$dob = addslashes($_POST['dob']);
				$address = addslashes($_POST['address']);
                $email = addslashes($_POST['email']);
                if(!valid_email($email)){
					$all_errors[3] = "Invalid student email address.";
				}
				$contact_number = addslashes($_POST['contact_number']);
                $all_errors[5] = validate_contact_number($contact_number);
                $nic = addslashes($_POST['nic']);


                $required_fields = array();
				$required_fields['name_with_initials']=[0,50,1,"Name with initials"];
				$required_fields['first_name']=[0,20,1,"First name"];
				$required_fields['middle_name']=[0,50,0,"Middle name"];
				$required_fields['last_name']=[0,20,1,"Last name"];
				$required_fields['gender']=[1,6,1,"Gender"];
				$required_fields['dob']=[10,10,1,"Dath of birth"];
				$required_fields['address']=[0,100,1,"Address"];
				$required_fields['email']=[0,100,1,"Email"];
				$result = validate_contact_number($_POST['contact-number']);
				if($result !== 1){
					$errors['contact-number'] = $result;
                }
                $required_fields['nic']=[0,10,1,"NIC"];

                $errors = array_merge($errors,check_input_fields($required_fields));

                if(empty($errors)){
                    $data = array();

                    $data["name_with_initials"]= $name_with_initials;
					$data["first_name"]= $first_name;
					$data["middle_name"]= $middle_name;
					$data["last_name"]= $last_name;
					$data["gender"]= $gender;
					$data["dob"]= $dob;
					$data["address"]= $address;
					$data["email"]= $email;
                    $data["contact_number"]= $contact_number;
                    $data["nic"]= $nic;
                    
                    if(count($errors) === 0 ){
						$this->load->model("teacher");
						$res = $this->load->teacher->insert_data($data);
						if($res){
						$info = "Successfully Registered";
							unset($_POST);
						}else{
							$error = "Try Again!.";
						}
					}
                }
            }
            $this->view_header_and_aside();
			// view form and footer
			$this->load->view("teacher/teacher_registration_form",["errors"=>$errors,"information"=>$information,"error"=>$error]);
			$this->load->view("templates/footer");
        }
    }

?>