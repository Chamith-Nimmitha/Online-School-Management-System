<?php 

	class CheckPermission{

		public function check_permission($model,$operation){
			if( (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') || (isset($_SESSION['permissions'][$model][$operation]) && $_SESSION['permissions'][$model][$operation] == 1)){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

 ?>