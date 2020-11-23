<?php

	class HomeModel extends Model{
		public function index(){
			return $this->con->select("student");
		}
	}