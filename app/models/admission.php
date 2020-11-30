<?php 

	class AdmissionModel extends Model{

		// insert data to the database
		public function insert_data($data){
			return $result = $this->con->insert("admission",$data);
		}

		// get admission form data
		public function get_data($admission_id){
			$this->con->where(array("id"=>$admission_id));
			$result_set = $this->con->select('admission');
			if($result_set && $result_set->rowCount() === 1){
				return $result_set->fetch();
			}else{
				return FALSE;
			}
		}
	}