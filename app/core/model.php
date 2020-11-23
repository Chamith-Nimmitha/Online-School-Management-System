<?php 

	class Model extends Database{
		public function __construct(){
			$this->con = new Database();
		}
	}