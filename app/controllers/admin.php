<?php

    class Admin extends Controller{

        public function __construct(){
            parent::__construct();
        }

        // admin can delete student
        public function student_delete($student_id){
            $con = new Database();
            $result = $con->update("student",array("is_deleted"=>1),array("id"=>$student_id));
            header("Location:". set_url("student/list"));
        }
    }