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
            $this->view_header_and_aside();
            $this->load->view("subject/subject_registration");
            $this->load->view("templates/footer");
        }

        // view all subjects in the system
        public function list()
        {
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
                $result_set = $this->load->subjects->get_subject_list($subject_id,$subject_name,$subject_code,$grade,$medium);
                $data['subject_id'] = $subject_id;
                $data['grade'] = $grade;
                $data['medium'] = $medium;
            }else{
                $result_set = $this->load->subjects->get_subject_list();
            }
            unset($_POST);
            $data['result_set'] = $result_set;
            $this->view_header_and_aside();
            $this->load->view("subject/subject_list",$data);
            $this->load->view("templates/footer");
        }

        // update subjects in the system
        public function update()
        {
            $this->view_header_and_aside();
            $this->load->view("subject/subjectnew-update");
            $this->load->view("templates/footer");
        }
    }

?>