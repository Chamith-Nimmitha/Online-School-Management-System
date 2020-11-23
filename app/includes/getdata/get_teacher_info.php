<?php require_once("../../php/common.php"); ?>
<?php require_once("../../php/database.php"); ?>
<?php 

	$id = "";
	$name_with_initials = "";
	$grade = "";
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	if(isset($_GET['name_with_initials'])){
		$name_with_initials = $_GET['name_with_initials'];
	}

	if(isset($_GET['grade'])){
		$grade = $_GET['grade'];
	}

	$teacher = new Teacher($id, $name_with_initials,$grade);
	if(!empty($id)){
		if(!empty($name_with_initials)){
			$teacher->validate_teacher();
		}else{
			$teacher->get_by_id();
		}
	}else if(!empty($name_with_initials)){
		$teacher->get_by_name();
	}else if(!empty($grade)){
		$teacher->get_by_grade();
	}

	class Teacher{
		public function __construct($id, $name_with_initials,$grade){
			global $con;
			$this->con = $con;
			$this->id = $id;
			$this->name_with_initials = $name_with_initials;
			$this->grade = $grade;
		}

		public function get_by_id(){
			$result = $this->con->select("teacher",array("id"=>$this->id));
			if($result && $result->rowCount()==1){
				echo json_encode($result->fetch());
			}else{
				echo "invalid";
			}	
		}
		public function get_by_name(){
			$result = $this->con->select("teacher",array("name_with_initials"=>$this->name_with_initials));
			if($result && $result->rowCount()==1){
				echo json_encode($result->fetch());
			}else{
				echo "invalid";
			}	
		}
		public function get_by_grade(){
			$result = $this->con->select("teacher",array("grade"=>$this->grade));
			if($result && $result->rowCount()>0){
				echo json_encode($result->fetchAll());
			}else{
				echo "invalid";
			}	
		}

		public function validate_teacher(){
			$query = "SELECT * FROM `teacher` WHERE `id` LIKE '%$this->id%' || `name_with_initials` LIKE '%$this->name_with_initials%'";
			$result = $this->con->pure_query($query);
			if($result && $result->rowCount()==1){
				echo json_encode($result->fetch());
			}else{
				echo "invalid";
			}	
		}
	}

 ?>