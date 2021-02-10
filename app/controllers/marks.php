<?php 

	class Marks extends Controller{
		public function __construct(){
			parent::__construct();
		}

		public function marks_report($student_id){

			$this->load->model('student');
			$r = new student();
			$r = $this->load->student->set_by_id($student_id);
			$r = $this->load->student->get_data();
			$data['student'] = $r;

			//$student_id = 1100021;
			$y=2020;
			$this->load->model('marks');
			$subject_list = $this->load->marks->student_subject_lists($r['grade']);
			$subject_list =$subject_list->fetchAll();
			$data['subject_list'] = $subject_list;


			
				for ($i=1; $i <=3 ; $i++) { 
					$marks_total[$y.'-'.$i] = 0;
					$marks_average[$y.'-'.$i] =0;

					$rls = $this->load->marks->get_marks_by_student_id($student_id,$i,$y);
					$rls = $rls->fetchAll();
					foreach ($rls as $abc) {
						$student_marks[$y.'-'.$i.'-'.$abc['subject_id']] = $abc['marks'];
						if(isset($student_marks[$y.'-'.$i.'-'.$abc['subject_id']]) && is_numeric($student_marks[$y.'-'.$i.'-'.$abc['subject_id']])){
							if( ($student_marks[$y.'-'.$i.'-'.$abc['subject_id']] >= 75 )  && ($student_marks[$y.'-'.$i.'-'.$abc['subject_id']] <= 100 ) ){
								$student_grades[$y.'-'.$i.'-'.$abc['subject_id']] = 'A';
							}
							elseif( ($student_marks[$y.'-'.$i.'-'.$abc['subject_id']] >= 65 )  && ($student_marks[$y.'-'.$i.'-'.$abc['subject_id']] <= 74 )  ){
								$student_grades[$y.'-'.$i.'-'.$abc['subject_id']] = 'B';
							}
							elseif( ($student_marks[$y.'-'.$i.'-'.$abc['subject_id']] >= 50 )  && ($student_marks[$y.'-'.$i.'-'.$abc['subject_id']] <= 64 ) ){
								$student_grades[$y.'-'.$i.'-'.$abc['subject_id']] = 'C';
							}
							elseif( ($student_marks[$y.'-'.$i.'-'.$abc['subject_id']] >= 35 )  && ($student_marks[$y.'-'.$i.'-'.$abc['subject_id']] <= 49 ) ){
								$student_grades[$y.'-'.$i.'-'.$abc['subject_id']] = 'S';
							}
							else{
								$student_grades[$y.'-'.$i.'-'.$abc['subject_id']] = 'F';
							}
						}
						$fl = 0;
						foreach ($subject_list as $subject) {
							if($subject['id'] == $abc['subject_id']){
								$fl =1;
							}
						}
						if($fl == 1){
						$marks_total[$y.'-'.$i] = $marks_total[$y.'-'.$i] + $student_marks[$y.'-'.$i.'-'.$abc['subject_id']] ;
						}
					}
					if(count($subject_list)!== 0){
						$marks_average[$y.'-'.$i] = $marks_total[$y.'-'.$i] / count($subject_list) ;
					}else{
						$marks_average[$y.'-'.$i] = 0;
					}
					
				}

			$data['marks_total'] =$marks_total;
			$data['marks_average'] =$marks_average;
			for ($i=1; $i <=3 ; $i++) { 
				          if( ($marks_average[$y.'-'.$i] >= 75 )  && ($marks_average[$y.'-'.$i] <= 100 ) ){
                              $marks_bgcolor[$y.'-'.$i] = "style=\"background-color:#008000\"";
                          }
                          elseif( ($marks_average[$y.'-'.$i] >= 65 )  && ($marks_average[$y.'-'.$i] <= 74 )  ){
                              $marks_bgcolor[$y.'-'.$i] = "style=\"background-color:#9ACD32\"";         
                          }
                          elseif( ($marks_average[$y.'-'.$i] >= 50 )  && ($marks_average[$y.'-'.$i] <= 64 ) ){
                             $marks_bgcolor[$y.'-'.$i] = "style=\"background-color:#CDBA00\"";
                          }               
                          elseif( ($marks_average[$y.'-'.$i] >= 35 )  && ($marks_average[$y.'-'.$i] <= 49 ) ){
                             $marks_bgcolor[$y.'-'.$i] = "style=\"background-color:#E86100\"";            
                          }
                          else{
                               $marks_bgcolor[$y.'-'.$i] = "style=\"background-color:#FF0000\"";        
                          }
			}
			$data['marks_bgcolor'] =$marks_bgcolor;
			
			if(isset($student_marks)){
				$data['student_marks']  =$student_marks;
			}
			if(isset($student_grades)){
				$data['student_grades']  =$student_grades;
			}
			$data['y'] = $y;

			for ($i=1; $i <=3 ; $i++) { 
				
					$rank = $this->load->marks-> get_rank($i);
					$rank = $rank->fetchAll();
					foreach ($rank as $r) {
						if($r['student_id']==$student_id){
							//echo $r['rank'];
							$student_rank[$i.'-term'] = $r['rank'];
						}
					}
			}
			if(isset($student_rank)){
				$data['student_rank']  =$student_rank;
			}
			
			//print_r($subject_list);
			/*foreach ($result as $re) {
				echo $re['subject_id'];echo '-->';echo $re['name'];echo '-->';echo $re['code'];echo '<br>';
			}*/
			$this->view_header_and_aside();
			$this->load->view("exam/exam_report",$data);
			$this->load->view("templates/footer");



	}

		//view exam results for the students
		public function classroom_marks_result_view($student_id,$t){
			//$t=3;
			$y=2020;
			$marks[][]="";

			$this->load->model("student");

			$student = new StudentModel();
			$student->set_by_id($student_id);
			$classroom_id = $student->get_classroom_id(); 


			$this->load->model("classroom");
			$this->load->model("marks");
			$result = $this->load->classroom->set_by_id($classroom_id);
			if(!$result){
				echo "Results not found.";
				exit();
			}
			$data['classroom_data'] = $this->load->classroom->get_data();
			$data['student_list'] = $this->load->marks->get_classroom_marks($classroom_id);
			$data["classroom_id"] = $classroom_id;
			$data["student_id"] = $student_id;
			$data["t"] = $t;

			$grd =$this->load->classroom->get_data();
			$res = $this->load->marks->student_subject_lists($grd['grade']);
			$data['subject_list'] = $res->fetchAll();

			if(isset($_POST['filter'])){
				$term= $_POST['term'];
				$y = 2020;
				$data["t"] = $term;
				$data["y"] = $y;

				header('Location:'.set_url("marks/classroom/result/view/$student_id/$term"));

			}
				$term = 1;
				$year = 2020;
				foreach ($data['student_list'] as $student) {
					$marks_total[$student['id'].'-'.$t]=0;
					$rls = $this->load->marks->get_marks_by_student_id($student['id'],$t,$y);
					$rls = $rls->fetchAll();
					foreach ($rls as $abc) {
						$student_marks[$student['id'].'-'.$abc['subject_id']] = $abc['marks'];

						$marks_total[$student['id'].'-'.$t] = $marks_total[$student['id'].'-'.$t] + $student_marks[$student['id'].'-'.$abc['subject_id']] ;
					}
				}

				if(isset($student_marks)){
					$data['std_marks'] = $student_marks;
				}

				$this->view_header_and_aside();
				$this->load->view("exam/classroom_marks_view",$data);
				$this->load->view("templates/footer");


		}
		// get classroom list
		public function classroom_list($page=NULL, $per_page=NULL){

			/*if(!$this->checkPermission->check_permission("attendance","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}*/

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

			$this->load->model("classrooms");
			$data['result_set'] = $this->load->classrooms->get_classroom_list($start,$per_page);
			$data['count'] = $this->load->classrooms->get_count()->fetch()['count'];
			$this->view_header_and_aside();
			$this->load->view("exam/marks_classroom_list",$data);
			$this->load->view("templates/footer");
		}


		// view classroom marks
		public function classroom_view($classroom_id,$t,$msg=null){
			/*if(!$this->checkPermission->check_permission("attendance","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}*/
			unset($_SESSION['cls_marks_upl']);
			$y=2020;
			$con = new Database();
			$marks[][]="";
			$this->load->model("classroom");
			$this->load->model("marks");
			$result = $this->load->classroom->set_by_id($classroom_id);
			if(!$result){
				echo "classroom not found.";
				exit();
			}
			$data['classroom_data'] = $this->load->classroom->get_data();
			$data['student_list'] = $this->load->marks->get_classroom_marks($classroom_id);
			$data["classroom_id"] = $classroom_id;

			$grd =$this->load->classroom->get_data();
			$res = $this->load->marks->student_subject_lists($grd['grade']);
			$data['subject_list'] = $res->fetchAll();

			$data["t"] = $t;
			$data["y"] = $y;
			$data['msg']=$msg;

			//$te = $con->insert("student_marks",["id"=>8, "marks"=> 23,"note"=>"","subject_id"=>1500009,"term"=>1,"year"=>2020]);
			//$te = $con->insert("stu-marks",["id"=>2,"classroom_id"=>1400040,"student_id"=>1100022,"first_term_total"=>0,"second_term_total"=>0,"third_term_total"=>0]);

			if(isset($_POST['filter'])){
				$term= $_POST['term'];
				$y = 2020;

				$data["t"] = $term;
				$data["y"] = $y;
				header('Location:'.set_url("marks/classroom/view/$classroom_id/$term"));

			}

			
			else{
			$term = 1;
			$year = 2020;
			foreach ($data['student_list'] as $student) {
				$marks_total[$student['id'].'-'.$t]=0;
				$rls = $this->load->marks->get_marks_by_student_id($student['id'],$t,$y);
				$rls = $rls->fetchAll();
				foreach ($rls as $abc) {
				
				$fl = 0;
				foreach ($data['subject_list'] as $subject) {
					if($subject['id'] == $abc['subject_id']){
						$fl =1;
					}
				}

				//if($fl == 1){
					$student_marks[$student['id'].'-'.$abc['subject_id']] = $abc['marks'];

					$marks_total[$student['id'].'-'.$t] = $marks_total[$student['id'].'-'.$t] + $student_marks[$student['id'].'-'.$abc['subject_id']] ;
				//}
				}
			}

			if(isset($student_marks)){
				$data['std_marks'] = $student_marks;
			}			

			if(isset($_POST['submit'])){
				/*foreach ($data['student_list'] as $student) {
						foreach ($_POST as $key => $value) {
							if($key !== 'submit'){
							$marks[$key] = $value;
							}
						}		
				}*/
				$subject_arr_no = array();
				$stu_marks = array();
				$marks = array();
				$arr_no = 2;
				$target  ="public/uploads/marksheet/";

				foreach ($data['subject_list'] as $subject) {
					$subject_arr_no[$arr_no] = $subject['id'];
					$arr_no++;
				}

				$filename = $_FILES["filename"]['name'];
				$filetype = explode(".", $filename);
				if(isset($_FILES['filename']['tmp_name']) && !empty($_FILES['filename']['tmp_name'])){
					if($filetype[1] == 'csv'){
					move_uploaded_file($_FILES['filename']['tmp_name'], $target.$filename);
					$file = fopen("C:\wamp64\www\mymvc\public\uploads\marksheet\\".$_FILES["filename"]['name'],'r');
					while (($line = fgetcsv($file)) !== FALSE) {
						//print_r($line);echo "<br>";
						$cur_student_id = null;
						foreach ($line as $key => $value) {
							//echo $key;echo $value;echo "<br>";
							if($key==0 && is_numeric($value)){
								$cur_student_id = $value;
							}

							elseif ($key !== 1){
								if(isset($cur_student_id)){
									$stu_marks[$cur_student_id.'-'.$subject_arr_no[$key]] = $value;
									$marks[$cur_student_id.'-'.$subject_arr_no[$key]]= $value;
								}
							}

						}
					}
					fclose($file);
					unset($data['std_marks']);
					$data['std_marks'] = $marks;
					$_SESSION['cls_marks_upl'] = $data;
					header('Location:'.set_url("marks/upload"));
					}
					else{
						$msg = "Only csv files are allowed....";
						header('Location:'.set_url("marks/classroom/view/$classroom_id/$t/$msg"));


					}
				}
			}
			if(isset($marks_total)){
				foreach ($marks_total as $key => $value) {
					
					$str = explode("-", $key);
					$std_id =  $str[0];
					$term = $str[1];

					if($term ==1){
						$total_marks= $con->update("stu-marks",["first_term_total"=> $value], ["student_id"=>$std_id]);
					}
					elseif($term ==2){
						$total_marks= $con->update("stu-marks",["second_term_total"=> $value], ["student_id"=>$std_id]);
					}
					elseif($term==3){
						$total_marks= $con->update("stu-marks",["third_term_total"=> $value], ["student_id"=>$std_id]);
					}
				}
			}

		//$resul = $con->insert("student_marks",["id"=>5, "marks"=> 100,"note"=>"","subject_id"=>1500037,"term"=>1,"year"=>2020]);


			$this->view_header_and_aside();
			$this->load->view("exam/classroom_marks_upload",$data);
			$this->load->view("templates/footer");}
		//print_r($resul);

	}

	public function marksheet_preview(){

		/*$subject_arr_no = array();
		$stu_marks = array();
		$arr_no = 2;
		$this->load->model("marks");
		$res = $this->load->marks->student_subject_lists('10');
		$data['subject_list'] = $res->fetchAll();

		foreach ($data['subject_list'] as $subject) {
			$subject_arr_no[$arr_no] = $subject['id'];
			$arr_no++;
		}
		
		$file = fopen('my.csv','r');
		while (($line = fgetcsv($file)) !== FALSE) {
			//print_r($line);echo "<br>";
			$cur_student_id = null;
			foreach ($line as $key => $value) {
				//echo $key;echo $value;echo "<br>";
				if($key==0 && is_numeric($value)){
					$cur_student_id = $value;
				}

				elseif ($key !== 1){
					if(isset($cur_student_id)){
						$stu_marks[$cur_student_id.'-'.$subject_arr_no[$key]] = $value;
					}
				}

			}
		}
		fclose($file);

		print_r($stu_marks);*/

		//unset($_SESSION['cls_marks_upl']);
		//print_r($_SESSION['cls_marks_upl']);

			$data = $_SESSION['cls_marks_upl'];
			$classroom_id = $data['classroom_id'];
			$t = $data['t'];
			$y = $data['y'];
			$marks = $data['std_marks'];

			if(isset($_POST['accept'])){
				$this->load->model("marks");
				$res = $this->load->marks->upload_classroom_marks1($classroom_id,$marks,$t,$y);

				if($res){
					$msg = "Marksheet Updated Successfully.";
				}
				header('Location:'.set_url("marks/classroom/view/$classroom_id/$t/$msg"));
				

			}

			if(isset($_POST['cancel'])){
				$msg = "No Changes made.";
				header('Location:'.set_url("marks/classroom/view/$classroom_id/$t/$msg"));
			}

			$this->view_header_and_aside();
			$this->load->view("exam/upload_marks_preview",$data);
			$this->load->view("templates/footer");


	}
}

 ?>