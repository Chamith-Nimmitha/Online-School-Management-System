<?php

    class Student extends Controller{

        public $msg;
        public $err;
        public function __construct() {
            parent::__construct();
        }

        // show list of student
        public function list($page=Null, $per_page=NULL){

            if(!$this->checkPermission->check_permission("student_list","view")){
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

            $this->load->model("studentsInfo");

            if(isset($_POST['search'])){
                $student_id = addslashes(trim($_POST['student-id']));
                $student_name = $student_id;
                $grade = $_POST['grade'];
                $class = $_POST['class'];

                if(empty($student_id)){
                    $student_id = NULL;
                    $student_name = NULL;
                }
                if($grade == 'all'){
                    $grade = NULL;
                }
                if($class == 'all'){
                    $class = NULL;
                }
                $result_set = $this->load->studentsInfo->get_student_list($start,$per_page,$student_id,$student_name,$grade,$class);

                $data['student_id'] = $student_id;
                $data['grade'] = $_POST['grade'];
                $data['class'] = $_POST['class'];
            }else{
                $result_set = $this->load->studentsInfo->get_student_list($start,$per_page);
            }
            unset($_POST);
            $data['count'] = $this->load->studentsInfo->get_count()->fetch()['count'];
            $data['result_set'] = $result_set;
            if(isset($_SESSION['snackbar_msg'])){
                $data['msg'] = $_SESSION['snackbar_msg'];
            }
            unset($_SESSION['snackbar_msg']);
            $this->view_header_and_aside();
            $this->load->view("student/student_list",$data);
            $this->load->view("templates/footer");
        }

        // admin can delete student
        public function student_delete($student_id){
            $this->load->model("student");
            $result = $this->load->student->set_by_id($student_id);
            $msg  = "";
            $err  = "";
            if(!$result){
                $err = "Student ${student_id} didn't exist.";
            }
            $result = $this->load->student->delete_self();
            if(!$result){
                $err = "Deletion failed.";
            }else{
                $msg = "Student ${student_id} deleted.";
            }
            if(!empty($msg)){
                $_SESSION['snackbar_msg'] = $msg;
            }else{
                $_SESSION['snackbar_msg'] = $err;
            }
            header("Location:". set_url("student/list"));
        }

        // view student timetable all users can use this
        public function timetable_view($id=""){
            if(!$this->checkPermission->check_permission("student","view")){
                $this->view_header_and_aside();
                $this->load->view("common/error");
                $this->load->view("templates/footer");
                return;
            }
            $time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];
            $day_map = ["1"=>"mon","2"=>"tue","3"=>"wed","4"=>"thu","5"=>"fri"];
            $timetable_data = [];
            $classroom_id = NULL;
            $grade = NULL;
            $class = NULL;
            if(!empty($id)){
                $user_id = $id;
            }else{
                $user_id = $_SESSION['user_id'];
            }
            $this->load->model("student");
            $this->load->model("subjects");
            $result = $this->load->student->set_by_id($user_id);
            if($result){
                $grade = $this->load->student->get_grade();
                $class = $this->load->student->get_class();
                $cls = $this->load->student->get_classroom_object();
                if($cls){
                    $classroom_id = $cls->get_id();
                    $tt = $cls->get_converted_timetable();
                    if($tt){
                        $timetable_data = $tt;
                    }
                }
            }
            $data = [
                'timetable_data'=>$timetable_data,
                'time_map'=>$time_map,
                "day_map"=>$day_map,
                "classroom_id" =>$classroom_id,
                "grade" => $grade,
                "class" => $class
            ];
            $this->view_header_and_aside();
            $this->load->view("student/student_timetable_view",$data);
            $this->load->view("templates/footer");
        }

        // student exam results
        public function exam_report($student_id=""){
            if( empty($student_id)){
                $student_id = $_SESSION['user_id'];
            }
             if(isset($student_id)){
                $this->load->model("student");
                $r = $this->load->student->set_by_id($student_id);
                if($r){
                $result = $this->load->student->get_data();
                }
            }

            $this->view_header_and_aside();
            $this->load->view("student/student_marks_report",['result'=>$result]);
            $this->load->view("templates/footer");
        }

        // attendance
        public function attendance($student_id=NULL){
            if(!$this->checkPermission->check_permission("attendance","view")){
                $this->view_header_and_aside();
                $this->load->view("common/error");
                $this->load->view("templates/footer");
                return;
            }
            if($student_id == NULL){
                if(isset($_POST['id'])){
                    $student_id = $_POST['id'];
                }else{
                    $student_id = $_SESSION['user_id'];
                }
            }else{
                if($_SESSION['role'] == "student"){
                    $student_id = $_SESSION['user_id'];
                }
            }

            $this->load->model("attendance");
            $result_set = $this->load->attendance->get_attendance_by_student_id($student_id);
            if($result_set){
                $data['result_set'] = $result_set->fetchAll();
            }else{
                $data['result_set'] = FALSE;
            }
            $data['student_id'] = $student_id;
            $this->view_header_and_aside();
            $this->load->view("student/student_attendance_view",$data);
            $this->load->view("templates/footer");
        }

        // attendance
        public function attendance_report(){
            $this->view_header_and_aside();
            $this->load->view("student/student_attendance_report");
            $this->load->view("templates/footer");
        }

        // view own learing subject list
        public function subject_list(){
            if(!$this->checkPermission->check_permission("subject","view")){
                $this->view_header_and_aside();
                $this->load->view("common/error");
                $this->load->view("templates/footer");
                return;
            }
            $con = new Database();
            $result_set = $con->select("tea_sub_student",array("student_id"=>$_SESSION['user_id']));
            if($result_set){
                $result_set = $result_set->fetchAll();
                $table_data = array();
                for($i=0; $i < count($result_set); $i++) {
                    $tea_sub = $con->select("teacher_subject", array("id"=>$result_set[$i]['teacher_subject_id']));
                    if($tea_sub && $tea_sub->rowCount() === 1){
                        $con->get(array("name_with_initials"));
                        $teacher = $con->select("teacher", array("id"=>$tea_sub['teacher_id']));
                        if($teacher && $teacher->rowCount()===1){
                            $subject = $con->select("suject", array("id"=>$tea_sub['subject_id']));
                            if($subject && $subject->rowCount() === 1){
                                $teacher = $teacher->fetch();
                                $subject = $subject->fetch();
                                $table_data[$i] = array("name"=>$subject['name'],"code"=>$subject['code'],"teacher_name"=>$teacher['name_with_initials']);
                            }
                        }
                    }
                }
            }
            $table_data[0] = array("name"=>"Maths","code"=>"12MAT","teacher_name"=>"R.P.Kumara");
            $table_data[1] = array("name"=>"Chemistry","code"=>"12CHE","teacher_name"=>"C.W.Gamage");

            $data['table_data'] = $table_data;
            $this->view_header_and_aside();
            $this->load->view("student/student_subject_list",$data);
            $this->load->view("templates/footer");
        }

        //view parent profile
        public function parent_view(){
            if(!$this->checkPermission->check_permission("parent","view")){
                $this->view_header_and_aside();
                $this->load->view("common/error");
                $this->load->view("templates/footer");
                return;
            }
            $this->view_header_and_aside();
            $this->load->view("student/student_attendance_view");
            $this->load->view("templates/footer");
        }
    }