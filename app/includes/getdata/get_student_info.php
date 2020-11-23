<?php require_once("../common.php"); ?>
<?php require_once("../database.php"); ?>
<?php require_once( realpath(dirname( __FILE__ ))."/../classes/students_info.class.php" ); ?>
<?php 
	
	$id = NULL;
	$name = NULL;
	$grade = NULL;
	$class = NULL;
	$start = NULL;
	$count = NULL;
	if(isset($_GET['id']) && !empty($_GET['id'])){
		$id = $_GET['id'];
	}
	if(isset($_GET['name']) && !empty($_GET['name'])){
		$name = $_GET['name'];
	}
	if(isset($_GET['grade']) && !empty($_GET['grade'])){
		$grade = $_GET['grade'];
	}
	if(isset($_GET['class']) && !empty($_GET['class'])){
		$class = $_GET['class'];
	}
	if(isset($_GET['start'])){
		$start = $_GET['start'];
	}
	if(isset($_GET['count'])){
		$count = $_GET['count'];
	}

	$student_info = new StudentsInfo($start,$count);
	$result_set = $student_info->get_student_list($id,$name,$grade,$class);
	if($result_set){
		$count = $student_info->get_pre_query_count();
		$result_set[count($result_set)] = $count;
		unset($student_info);
		echo json_encode($result_set);
	}else{
		echo "FALSE";
	}
	
 ?>