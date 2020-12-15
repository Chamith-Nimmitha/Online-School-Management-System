<?php 

	if(isset($category) && !empty($category) ){
		require_once(MODELS."classrooms.php");
		$classrooms = new classroomsModel();
		$result_set = $classrooms->get_section_list_by_category($category);
		if($result_set){
			echo json_encode($result_set);
		}else{
			echo "FALSE";
		}
	}else{
		echo "FALSE";
	}

 ?>