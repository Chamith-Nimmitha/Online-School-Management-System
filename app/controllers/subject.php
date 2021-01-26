<?php

    class  Subject extends Controller
    {
        public function __construct()
        {
            parent::__construct();
        }

        // add new subjects to system
        public function registration()
        {
            if(!$this->checkPermission->check_permission("subject","create")){
                $this->view_header_and_aside();
                $this->load->view("common/error");
                $this->load->view("templates/footer");
                return;
            }
            $data = [];
            $errors = [];
            if(isset($_POST['submit'])){
                $medium = $_POST['medium'];
                $grade = $_POST['grade'];
                $name = addslashes(trim($_POST['name']));
                $description = addslashes(trim($_POST['description']));
                $code = $_POST['code'];
                $type = $_POST['type'];
                $category = $_POST['category'];

                // check required fields
                $resquire_fields['name'] = [3,50,1,"Subject Name"];
                $errors = check_input_fields($resquire_fields);

                $insert['medium'] = $medium;
                $insert['grade'] = $grade;
                $insert['name'] = $name;
                $insert['code'] = $code;
                $insert['type'] = $type;
                $insert['category'] = $category;
                $insert['description'] = $description;
                $this->load->model("subjects");
                $result = $this->load->subjects->register($insert);
                if($result){
                    $data['info'] = "Subject registration success.";
                }else{
                    $errors['registration'] = "Already Registered.";
                    $data['medium'] = $medium;
                    $data['grade'] = $grade;
                    $data['name'] = $name;
                    $data['code'] = $code;
                    $data['type'] = $type;
                    $data['category'] = $category;
                    $data['description'] = $description;
                }
                unset($_POST);
            }

            $data['errors'] = $errors;
            $data['oparation'] = "register";
            $this->view_header_and_aside();
            $this->load->view("subject/subject_registration",$data);
            $this->load->view("templates/footer");
        }

        // update a subject
        public function update($id){
            if(!$this->checkPermission->check_permission("subject","update")){
                $this->view_header_and_aside();
                $this->load->view("common/error");
                $this->load->view("templates/footer");
                return;
            }
            $this->load->model("subject");
            $this->load->model("subjects");
            $data = [];
            if(isset($_POST['update'])){
                $medium = $_POST['medium'];
                $grade = $_POST['grade'];
                $name = addslashes(trim($_POST['name']));
                $description = addslashes(trim($_POST['description']));
                $code = $_POST['code'];

                 // check required fields
                $resquire_fields['name'] = [3,50,1,"Subject Name"];
                $errors = check_input_fields($resquire_fields);

                $update['medium'] = $medium;
                $update['grade'] = $grade;
                $update['name'] = $name;
                $update['code'] = $code;
                $update['description'] = $description;
                // print_r($_POST);
                // exit();
                $result = $this->load->subjects->update_subject($id,$update);
                if(!$result){
                    $data['error'] = "Update Failed";
                }else{
                    $data['info'] = "Update successful";
                }

            }

            $result = $this->load->subject->set_by_id($id);
            if(!$result){
                $data['error'] = "Subject Not Found.";
            }else{
                $temp = $this->load->subject->get_data();
                foreach ($temp as $key => $value) {
                    $data[$key] = $value;
                }
            }
            $data['oparation'] = "update";
            $this->view_header_and_aside();
            $this->load->view("subject/subject_registration",$data);
            $this->load->view("templates/footer");
        }

        // view all subjects in the system
        public function list($page=NULL, $per_page=NULL,$info="", $error="")
        {
            if(!$this->checkPermission->check_permission("subject","view")){
                $this->view_header_and_aside();
                $this->load->view("common/error");
                $this->load->view("templates/footer");
                return;
            }

            // count page info for pagination
            if($per_page === NULL){
                $per_page = PER_PAGE;
            }
            if($page === Null){
                $page = 1;
                $start = 0;
            }else{
                $start = ($page-1)*$per_page;
            }

            $data['page'] = $page;
            $data['per_page'] = $per_page;
            $data['start'] = $start;

            $this->load->model("subjects");

            if(isset($_POST['search'])){
                $subject_id = addslashes(trim($_POST['subject-id']));
                $subject_name = $subject_id;
                $subject_code = $subject_id;
                $grade = $_POST['grade'];
                $medium = $_POST['medium'];

                if(empty($subject_id)){
                    $subject_id = NULL;
                    $subject_name = NULL;
                    $subject_code = NULL;
                }
                if($grade === 'all'){
                    $grade = NULL;
                }
                if($medium == 'all'){
                    $medium = NULL;
                }
                $result_set = $this->load->subjects->get_subject_list($start,$per_page,$subject_id,$subject_name,$subject_code,$grade,$medium);
                $data['subject_id'] = $subject_id;
                $data['grade'] = $grade;
                $data['medium'] = $medium;
            }else{
                $result_set = $this->load->subjects->get_subject_list($start,$per_page);
            }
            unset($_POST);
            if(isset($_SESSION['snackbar_msg'])){
                $data['msg'] = $_SESSION['snackbar_msg'];
                unset($_SESSION['snackbar_msg']);
            }
            if(isset($_SESSION['info'])){
                $data['info'] = $_SESSION['info'];
                $data['error'] = $_SESSION['error'];
                unset($_SESSION['info']);
                unset($_SESSION['error']);
            }
            $data['result_set'] = $result_set;
            $data['count'] = $this->load->subjects->get_count()->fetch()['count'];
            $this->view_header_and_aside();
            $this->load->view("subject/subject_list",$data);
            $this->load->view("templates/footer");
        }

        // delete a subject
        public function delete($id){
            if(!$this->checkPermission->check_permission("subject","delete")){
                $this->view_header_and_aside();
                $this->load->view("common/error");
                $this->load->view("templates/footer");
                return;
            }
            $this->load->model("subjects");
            $result = $this->load->subjects->delete_subject($id);
            $error = "";
            $info = "";
            if($result){
                $info = "Subject ${id} deleted.";
            }else{
                $error = "Deletion failed.";
            }
            if(!empty($info)){
                $_SESSION['snackbar_msg'] = $info;
            }else{
                $_SESSION['snackbar_msg'] = $error;
            }
            $_SESSION['info'] = $info;
            $_SESSION['error'] = $error;
            header("Location:". set_url("subject/list"));
        }

        // upload csv files
        public function subject_upload()
        {
            $field_errors = array();
            $col_error = array();
            $error = "";
            $info = "";

            if(isset($_POST["submit"]))
            {
                if($_FILES['file']['name'])
                {
                    $filename = explode(".", $_FILES['file']['name']);

                    if($filename[1] == 'csv')
                    {
                        $handle = fopen($_FILES['file']['tmp_name'], "r");

                        while($dataset = fgetcsv($handle))
                        {
                            //$error = '';
                            $colcount = count($dataset);
                            $info = '';
                            //echo '<tr>';

                            if($colcount != 3)
                            {
                                //$error = 'Column count incorrect';
                                //$field_errors['$colcount'] = "Column count incorrect";
                                $col_error[0] = "Column count incorrect";
                            }
                            else
                            {
                                if($colcount == 3)
                                {
                                    //checking data types
                                    if(!(is_numeric($dataset[0])))
                                    {
                                        //$error = 'error';
                                        $field_errors['dataset[0]'] = "Error";
                                    }

                                    if(!(is_string($dataset[1])))
                                    {
                                        //$error = 'error';
                                        $field_errors['dataset[1]'] = "Error";
                                    }

                                    if(!(is_string($dataset[2])))
                                    {
                                        //$error = 'error';
                                        $field_errors['dataset[2]'] = "Error";
                                    }

                                    $sub_code = strtoupper(substr($dataset[1], 0, 1)) ."-". ($dataset[0]) ."-". strtoupper(substr($dataset[2], 0, 3));
                                }
                                // else
                                // {
                                //     if(!(is_numeric($data[0])))
                                //     {
                                //         //$error = 'error';
                                //         $field_errors['error'] = $error;
                                //     }

                                //     if(!(is_string($data[1])))
                                //     {
                                //         //$error = 'error';
                                //         $field_errors['error'] = $error;
                                //     }

                                //     if(!(is_string($data[2])))
                                //     {
                                //         //$error = 'error';
                                //         $field_errors['error'] = $error;
                                //     }

                                //     if(!(is_string($data[3])))
                                //     {
                                //         //$error = 'error';
                                //         $field_errors['error'] = $error;
                                //     }
                                // }

                            }

                            $field_errors = array_merge($field_errors, $col_error);

                            if(empty($field_errors))
                            {
                                $data = array();

                                $data["name"] = $dataset[0];
                                $data["grade"] = $dataset[1];
                                $data["medium"] = $dataset[2];
                            }

                            if(count($field_errors) === 0)
                            {
                                $this->load->model("subject");
                                $result = $this->load->subject->insert_data($data);

                                if($result)
                                {
                                    $info = "File Uploaded Successfully.";
                                    //unset($_POST);
                                }
                                else
                                {
                                    $info = "File Uploading Fail.";
                                }
                                // else
                                // {
                                //     $this->load->view("subject/subject-upload");
                                // }
                            }
                            else
                            {
                                $info = "File Uploading Fail.......................";
                            }
                            // if(!(empty($field_error)))
                            // {
                            //     $this->load->view("subject/subject_upload");
                            // }


                            //echo '</tr>';


                         /*   if($error)
                            {
                                $this->load->view("subject/subject-upload");   
                            }
                            else
                            {
                                $this->load->view("subject/subject-upload");
                            }*/
                        }

                    /*if(!(empty($field_error)))
                        {
                            //$this->load->view("subject/subject_upload");
                            return;
                            //$this->view_header_and_aside();
                            //$this->load->view("subject/subject_upload", ["field_error"=>$field_error,"info"=>$info,"error"=>$error]);
                            //$this->load->view("templates/footer");
                        }*/
                    }

                    fclose($handle);
                }
            }
            

            $this->view_header_and_aside();
            $this->load->view("subject/subject_upload", ["field_errors"=>$field_errors,"info"=>$info,"error"=>$error]);
            $this->load->view("templates/footer");
        }
	}
    

?>