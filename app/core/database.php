<?php require_once(CONFIG."database.php"); ?>
<?php 
	class Database {
		private $dsn;
		public $db;
		private $query;
		private $pre_query;
		private $pre_query_count;
		private $table;
		private $where;
		private $parameters;
		private $select;
		private $get;
		private $order;
		private $limit;

		public function __construct(){
			global $db_config;
			$host = $db_config['hostname'];
			$username = $db_config['username'];
			$password = $db_config['password'];
			$dbname = $db_config['dbname'];
			$this->dsn = "mysql:host=". $host.";dbname=".$dbname;
			$this->db = new PDO($this->dsn, $username, $password);
			$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			// $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$this->query = "";
			$this->table = "";
			$this->where = "";
			$this->select = "";
			$this->get = "";
			$this->order = "";
			$this->limit = "";
			$this->parameters = array();
		}

		public function get($fields){
			foreach ($fields as  $value) {
				if (empty($this->get)){
					$this->get .= "`".$value."`";
				}else{
					$this->get .= ",`".$value."`";
				}
			}
		}

		public function where($ass_array){
			foreach ($ass_array as $key => $value) {
				array_push($this->parameters, $value);
				if(empty($this->where)){
					$this->where .= "`".$key. "` = ? ";
				}else{
					$this->where .= "&& `". $key. "` = ? ";
				}
			}
		}

		public function set_table($table){
			$this->table = $table;
		}

		private function reset_values(){
			$this->query = "";
			$this->table = "";
			$this->where = "";
			$this->select = "";
			$this->get = "";
			$this->order = "";
			$this->limit = "";
			$this->parameters = array();
		}

		public function select($table, $fields=NULL){

			$this->query = "SELECT";
			if(empty($this->get)){
				$this->query .=" * ";
			}else{
				$this->query .= " ".$this->get;
			}

			$this->query .= " FROM `".$table."` ";

			if($fields === NULL){
				if(!empty($this->where)){
					$this->query .= "WHERE ". $this->where;
				}
			}else{
				$where = "";
				foreach ($fields as $key => $value) {
					array_push($this->parameters, $value);
					if(empty($where)){
						$where .= "`".$key. "` = ? ";
					}else{
						$where .= "&& `".$key. "` = ? ";
					}
				}
				$this->query .= "WHERE ".$where;
			}
			$this->query .= " ".$this->order;
			$this->query .= " ".$this->limit.";";
			$this->pre_query = $this->query;
			$stmt = $this->db->prepare($this->query);
			$stmt->execute($this->parameters);
			// $this->db->closeCursor();
			// echo $this->query;
			$this->reset_values();
			return $stmt;
		}

		public function insert($table,$fields){
			$this->query .= "INSERT INTO ";

			$this->query .= "`".$table."` ";

			$keys = "";
			$values = "";
			foreach ($fields as $key => $value) {
				if(empty($keys)){
					$keys .= "`".$key."`";
				}else{
					$keys .= ",`".$key."`";
				}

				array_push($this->parameters, $value);
				if(empty($values)){
					$values .= " ? ";
				}else{
					$values .= ",? ";
				}
			}

			$this->query .= "(".$keys.") VALUES (".$values.");";
			$this->pre_query = $this->query;
			$stmt = $this->db->prepare($this->query);
			$stmt->execute($this->parameters);
			// echo $this->query."<br>";
			$this->reset_values();
			return $stmt;
		}

		public function delete($table, $fields=NULL){
			
			$this->query .= "DELETE FROM ";

			$this->query .= "`".$table."` ";

			if($fields == NULL){
				$this->query .= "WHERE ". $this->where.";";
			}else{
				$where = "";
				foreach ($fields as $key => $value) {
					array_push($this->parameters, $value);
					if(empty($where)){
						$where .= "`".$key. "` = ? ";
					}else{
						$where .= "&& `".$key. "` = ? ";
					}
				}
				$this->query .= "WHERE ".$where." ;";
			}
			$this->pre_query = $this->query;
			$stmt = $this->db->prepare($this->query);
			$stmt->execute($this->parameters);
			// $this->db->closeCursor();
			$this->reset_values();
			return $stmt;
		}

		public function update($table,$fields,$wheres=NULL){
			$this->query .= "UPDATE `".$table."` SET ";
			$set = "";
			$pre_arr = array();
			foreach ($fields as $key => $value) {
				array_push($pre_arr, $value);
				if(empty($set)){
					$set .= "`".$key."` = ? ";
				}else{
					$set .= ", `".$key."` = ? ";
				}
			}
			$this->parameters = array_merge($pre_arr,$this->parameters);
			$this->query .= $set." ";
			if($wheres == NULL){
				$this->query .= "WHERE ". $this->where.";";
			}else{
				$where = "";
				foreach ($wheres as $key => $value) {
					array_push($this->parameters, $value);
					if(empty($where)){
						$where .= "`".$key. "` = ? ";
					}else{
						$where .= "&& `".$key. "` = ? ";
					}
				}
				$this->query .= "WHERE ".$where." ;";
			}
			$this->pre_query = $this->query;
			$stmt = $this->db->prepare($this->query);
			$stmt->execute($this->parameters);
			// $this->db->closeCursor();
			// echo $this->query;
			$this->reset_values();
			return $stmt;
		}

		public function orderBy($or){
			$this->order = " ORDER BY `".$or."` ASC ";
		}
		public function limit($l){
			$this->limit = "LIMIT ".$l;
		}

		public function pure_query($query){
			$this->reset_values();
			$this->pre_query = $query;
			// echo $query;
			return $this->db->query($query);
		}

		public function get_next_auto_increment($tablename){
			$this->query = "SELECT AUTO_INCREMENT FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA` = '".$GLOBALS['dbname']."' AND `TABLE_NAME` = '".$tablename."'";

			$this->pre_query = $this->query;
			$result = $this->db->query($this->query);
			$this->reset_values();
			return $result;
		}
	}
 ?>