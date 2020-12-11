<?php 
	
	// $id = NULL;
	// $name = NULL;
	// $grade = NULL;
	// $class = NULL;
	// $start = NULL;
	// $count = NULL;
	// if(isset($_GET['id']) && !empty($_GET['id'])){
	// 	$id = $_GET['id'];
	// }
	// if(isset($_GET['name']) && !empty($_GET['name'])){
	// 	$name = $_GET['name'];
	// }
	// if(isset($_GET['grade']) && !empty($_GET['grade'])){
	// 	$grade = $_GET['grade'];
	// }
	// if(isset($_GET['class']) && !empty($_GET['class'])){
	// 	$class = $_GET['class'];
	// }
	// if(isset($_GET['start'])){
	// 	$start = $_GET['start'];
	// }
	// if(isset($_GET['count'])){
	// 	$count = $_GET['count'];
	// }

	$student_info = new StudentsInfo();
	$result_set = $student_info->get_student_list($id,$name,$grade,$class);
	print_r($result_set);
	if($result_set){
		unset($student_info);
		echo json_encode($result_set);
	}else{
		echo "FALSE";
	}
	
 ?>