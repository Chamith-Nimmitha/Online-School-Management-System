
<?php 

	class ApiPagination extends Controller {
		public function __construct() {
			parent::__construct();
		}

		public function pagination(){

			$post = json_decode( file_get_contents("php://input"));
			$route = $post->route;
			$count = $post->count;
			$func = $post->func;

			$start = 0;
			if(empty($id)){
				$id = NULL;
			}
			if(isset($post->per_page)){
				$per_page = $post->per_page;
			}else{
				$per_page = PER_PAGE;
			}
			if(isset($post->page)){
				$page = $post->page;
				$start = ($page-1) * $per_page;
			}else{
				$page = 1;
			}

			require_once(INCLUDES."pagination.php");
			display_pagination($count,$page,$per_page, $route,$func);
		}
	}

 ?>