<?php 
	class Load{
		protected function view($view_name, $data=[]){
			$file = VIEWS.$view_name.".php";
			if(file_exists($file)){
				extract($data);
				ob_start();
				require($file);
				ob_end_flush();
			}else{
				echo "view does not exist.";
			}
		}

		protected function model($model_name,$file_name=""){
			if(!empty($file_name)){
				$file = MODELS.$file_name.".php";
			}else{
				$file = MODELS.$model_name.".php";
			}
			if(file_exists($file)){
				require_once($file);
				$name = ucfirst($model_name)."Model";
				$this->{$model_name} = new $name();
				// return new $name();
			}else{
				echo "Model does not exist.";
			}
		}
	}