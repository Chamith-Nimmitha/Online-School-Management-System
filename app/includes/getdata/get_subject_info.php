<?php require_once("../common.php"); ?>
<?php require_once("../database.php"); ?>
<?php 

	class Subject{
		public function __construct($id, $name, $code){
			global $con;
			$this->id = $id;
			$this->name = $name;
			$this->code = $code;
			$this->con = $con;
		}

		public function get_data(){
			$query = "SELECT * FROM `subject` WHERE `id`='$this->id' || `code`='$this->code'LIMIT 1";
			$result = $this->con->pure_query($query);

			if($result && $result->rowCount() == 1){
				echo json_encode($result->fetch());
			}else{
				echo "error";
			}
		}
	}

	$id = "";
	$name = "";
	$code = "";

	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	if(isset($_GET['name'])){
		$name = $_GET['name'];
	}
	if(isset($_GET['code'])){
		$code = $_GET['code'];
	}

	$subject = new Subject($id,$name,$code);
	$subject->get_data();
 ?>