<?php 

	class InterviewPanelModel extends Model{
		public function __construct() {
			parent::__construct();
		}

		public function get_interview_panels($where=[]){
			if(count($where) == 0){
				return $this->con->select("interview_panel");
			}else{
				return $this->con->select("interview_panel", $where);
			}
		}

		// get all interview panel teachers
		public function get_interview_panel_teachers($interview_panel_id){
			return $this->con->select("teacher",['interview_panel_id'=>$interview_panel_id]);
		}

		// register new interview panel
		public function register($data,$teachers){
			try {
				$this->con->db->beginTransaction();
				$result = $this->con->insert("interview_panel", $data);
				if(!$result || $result->rowCount() !== 1){
					throw new PDOException("Panel creation failed.", 1);
				}
				$this->con->get(['id']);
				$result = $this->con->select("interview_panel",$data);
				if(!$result || $result->rowCount() !== 1){
					throw new PDOException("Panel creation failed.", 1);
				}
				$panel_id = $result->fetch()['id'];

				require_once(MODELS."timetable.php");
				$tt = new TimetableModel();
				$result = $tt->create($panel_id,"interview");
				if(!$result){
					throw new PDOException("Timetable creation failed.", 1);	
				}

				foreach ($teachers as $teacher) {
					$result = $this->con->update("teacher",['interview_panel_id'=>$panel_id],["id"=>$teacher]);					
					if(!$result || $result->rowCount() !== 1){
						throw new PDOException();
					}
				}

				$this->con->db->commit();
				return $panel_id;
			} catch (Exception $e) {
				$this->con->db->rollBack();
				return FALSE;
				
			}
		}

		// Update interview panel
		public function update_panel($panel_id,$data,$teachers){
			try {
				print_r($panel_id);
				print_r($data);
				$this->con->db->beginTransaction();
				$result = $this->con->update("interview_panel", $data,["id"=>$panel_id]);
				if(!$result){
					throw new PDOException();
				}
				$old_teachers = $this->get_interview_panel_teachers($panel_id);
				if(!$old_teachers){
					throw new PDOException();
				}
				$old_teachers = $old_teachers->fetchAll();
				$query = "UPDATE `teacher` SET `interview_panel_id`= NULL WHERE `id`= ? ";
				foreach ($old_teachers as $teacher) {
					$result = $this->con->pure_query($query,[$teacher['id']]);
					if(!$result || $result->rowCount() !== 1){
						throw new PDOException();
					}
				}

				foreach ($teachers as $teacher) {
					$result = $this->con->update("teacher",['interview_panel_id'=>$panel_id],["id"=>$teacher]);					
					if(!$result || $result->rowCount() !== 1){
						throw new PDOException();
					}
				}
				$this->con->db->commit();
				return TRUE;
			} catch (Exception $e) {
				$this->con->db->rollBack();
				return FALSE;
				
			}
		}
	}
 ?>