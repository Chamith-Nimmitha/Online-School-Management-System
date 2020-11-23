<?php 

	class Controller extends Load{
		protected $load;
		public function __construct(){
			$this->load = new Load();
		}
	}