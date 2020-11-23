<?php 

	class App{
		protected $controller;
		protected $metod;
		protected $params = [];

		public function __construct(){
			$this->prepareURL();
			$this->render();
		}

		//get url path and extract controller,method and parameters
		private function prepareURL(){
			require_once(CONFIG."routes.php");
			global $routes;
			$url = $_SERVER["QUERY_STRING"];
			$url = trim($url,"/");
			$url = explode("/",$url);
			foreach ($routes as $key => $value) {
				$route_url = explode("/", $key);
				if(count($route_url) == count($url)){
					if($route_url[0] === $url[0]){
						$real_url = trim($value,"/");
						$real_url = explode("/",$real_url);
						if(count($url) >1){
							if($route_url[1] === $url[1]){
								$this->controller = $real_url[0];
								$this->method = isset($real_url[1]) ? $real_url[1] : "index";
								unset($url[0],$url[1]);
								$this->params = !empty($url) ? array_values($url) : [];
								break;
							}else if(count($url) === count(explode("$",$value))){
								$this->controller = $real_url[0];
								$this->method = isset($real_url[1]) ? $real_url[1] : "index";
								unset($url[0]);
								$this->params = !empty($url) ? array_values($url) : [];
								break;
							}
						}else{
							$this->controller = !empty($real_url[0]) ? ucwords($real_url[0]) : "Home";
							$this->method = isset($real_url[1]) ? $real_url[1] : "index";
							unset($url[0],$url[1]);
							$this->params = !empty($url) ? array_values($url) : [];
							break;
						}
					}
				}
			}
			return;
		}

		// run the controller which discovered by prepareURL method.
		private function render(){
			if(class_exists($this->controller)){
				$controller = new $this->controller();
				if(method_exists($controller, $this->method)){
					call_user_func_array([$controller,$this->method],$this->params);
				}else{
					echo "This Method not exist.";
				}
			}else{
				echo $this->controller;
				echo "This controller not exist.";
			}
		}
	}