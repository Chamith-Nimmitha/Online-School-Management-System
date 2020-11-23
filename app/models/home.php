<?php

	class HomeModel extends Model{
		public function get_header_data(){
			$this->con->get(['name','value']);
			return $this->con->select("website_data",['category'=>'school']);
		}

		public function get_noticeboard_data(){
			return $this->con->select("notice");
		}
	}