<?php

	class HomeModel extends Model{
		public function get_header_data(){
			$this->con->get(['name','value']);
			return $this->con->select("website_data",['category'=>'school']);
		}

		public function get_noticeboard_data(){
			return $this->con->select("notice");
		}

		public function add_notice($data,$file=NULL){
			try {
				$this->con->db->beginTransaction();

				$result = $this->con->insert("notice",$data);

				if(!$result || $result->rowCount() != 1){
					throw new Exception();
				}
				$this->con->get(['id']);
				$result = $this->con->select("notice",$data);
				$notice_id = $result->fetch()['id'];

				if(!$result || $result->rowCount() != 1){
					throw new Exception();
				}

				if($file !== NULL){
					$target = BASEPATH."public/assets/img/notice_images/";
					$rename = $notice_id;
					$data['image'] = $rename . "." .strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
					$res = upload_file($file,$target, 2000000, $rename);
					if($res !== 1){
						throw new Exception();
					}
					$result = $this->con->update("notice",["image"=>$data['image']],["id"=>$notice_id]);
					if(!$result || $result->rowCount() != 1){
						throw new Exception();
					}
				}
				$this->con->db->commit();
				return TRUE;
			} catch (Exception $e) {
				$this->con->db->rollBack();
				return FALSE;
			}
		}

		// get a ntice
		public function get_notice($notice_id){
			return $this->con->select("notice",["id"=>$notice_id]);
		}
	}