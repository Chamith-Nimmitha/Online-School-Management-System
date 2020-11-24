<?php 

	class Model extends Database{
		public $con;
		public function __construct(){
			$this->con = new Database();
		}
	}