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

                // check required fields
                $resquire_fields['name'] = [3,50,1,"Subject Name"];
                $errors = check_input_fields($resquire_fields);

                $insert['medium'] = $medium;
                $insert['grade'] = $grade;
                $insert['name'] = $name;
                $insert['code'] = $code;
                $insert['description'] = $description;
                $this->load->model("subjects");
                $result = $this->load->subjects->register($insert);
                if($result){
                    $data['info'] = "Subject registration success.";
                }else{
                    $errors['registration'] = "Registration failed.";
                    $data['medium'] = $medium;
                    $data['grade'] = $grade;
                    $data['name'] = $name;
                    $data['code'] = $code;
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
            $data['result_set'] = $result_set;
            $data['count'] = $this->load->subjects->get_count()->fetch()['count'];
            $data['info'] = $info;
            $data['error'] = $error;
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
                $info = "Deletion successful.";
            }else{
                $error = "Deletion failed.";
            }
            $this->list($info,$error);
        }
    }

?>