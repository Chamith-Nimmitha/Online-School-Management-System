<?php 

	class ParentsModel extends Model{
		public function __construct() {
			parent::__construct();
		}

		public function search($id=NULL,$name=NULL,$occupation=NULL){
			$query = "SELECT * FROM `parent` ";
			$where_flag = 0;
			$params = [];
			if($id !== NULL){
				$query .= "WHERE (`id` LIKE ? ";
				array_push($params, "%{$id}%");
				$where_flag = 1;
			}
			if($name !== NULL){
				if($where_flag == 1 ){
					$query .= " || `name` LIKE ? )";
				}else{
					$query .= " WHERE `name` LIKE ?";
				}
					array_push($params, "%{$name}%");
					$where_flag = 1;
			}else if($where_flag == 1 ){
				$query .= ") ";
			}

			if($occupation !== NULL){
				if($where_flag == 1 ){
					$query .= " && `occupation` LIKE ? "; 
				}else{
					$query .= " WHERE `occupation` LIKE ? "; 
				}
				array_push($params, "%{$occupation}%");
				$where_flag = 1;
			}

			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			if($result){
				return $stmt->fetchAll();
			}else{
				return FALSE;
			}
		}
	}

 ?>