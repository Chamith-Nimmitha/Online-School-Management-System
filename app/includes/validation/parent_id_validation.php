<?php include_once("../../php/database.php"); ?>
<?php 
	if(isset($_GET['id'])){

		$con->get(array('id'));
		$result = $con->select("parent",array("id"=>$_GET['id']));
		if($result && $result->rowCount()==1){
			echo "ok";
		}else{
			echo "invalid";
		}
	}

 ?>