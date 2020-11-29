<?php

    class Student extends Controller{

        public function __construct() {
            parent::__construct();
        }

        // show list of student
        public function list(){
            $this->view_header_and_aside();
            $this->load->view("student/student_list");
            $this->load->view("templates/footer");
        }

        // view student timetable all users can use this
        public function timetable_view($id=""){
            
            $time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];
            $day_map = ["1"=>"mon","2"=>"tue","3"=>"wed","4"=>"thu","5"=>"fri"];
            $timetable_data = [];
            if(!empty($id)){
                $user_id = $id;
            }else{
                $user_id = $_SESSION['user_id'];
            }
            $con = new Database();
            $con->get(array("classroom_id","grade"));
            $student_info = $con->select("student",array("id"=>$user_id));
            if($student_info && $student_info->rowCount() ==1 ){
                $data = $student_info->fetch();
                $classroom_id = $data['classroom_id'];
                $student_grade = $data['grade'];
            }
            
            $con->get(array("id"));
            $timetable = $con->select("normal_timetable",array("user_id"=>$classroom_id, "type"=>"classroom"));
            
            if($timetable && $timetable->rowCount() == 1){
                $timetable_id = $timetable->fetch()['id'];
                $con->get(array("day","period","task"));
                $con->orderBy("period");
                $con->limit(40);
                $time = $con->select("normal_day",array("timetable_id"=>$timetable_id));
                
                if($time && $time->rowCount() >0){
                    $timetable_day = $time->fetchAll();
                }else{
                    echo "Error";
                }
                $timetable_data = array("mon"=>array(), "tue"=>array(), "wed"=>array(), "thu"=>array(), "fri"=>array());
                foreach ($timetable_day as $index => $data) {
                    $timetable_data[$data['day']][$data['period']] = $data['task'];
                }
            }else{
                $error = "Not found student classroom.";
                $classroom_id="";
            }
            
            $data = [
                'timetable_data'=>$timetable_data,
                'time_map'=>$time_map,
                "day_map"=>$day_map,
                "classroom_id" =>$classroom_id,
                "student_grade" => $student_grade
            ];
            $this->view_header_and_aside();
            $this->load->view("student/student_timetable_view",$data);
            $this->load->view("templates/footer");
        }

        // student exam results
        public function exam($student_id=""){
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
    }