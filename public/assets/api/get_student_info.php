<?php 
	
	if(!isset($id) || empty($id)){
		$id = NULL;
	}
	if(!isset($name) || empty($name)){
		$name = NULL;
	}
	if(!isset($grade) || empty($grade)){
		$grade = NULL;
	}
	if(!isset($class) || empty($class)){
		$class = NULL;
	}

	$student_info = new StudentsInfo();
	$result_set = $student_info->get_student_list($id,$name,$grade,$class);
	if($result_set){
		unset($student_info);
		echo json_encode($result_set);
	}else{
		echo "FALSE";
	}
	
 ?>