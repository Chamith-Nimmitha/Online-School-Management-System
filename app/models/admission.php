<?php 

	class AdmissionModel extends Model{

		// insert data to the database
		public function insert_data($data){
			$con = new Database();
			return $result = $con->insert("admission",$data);
		}
	}