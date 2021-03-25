
<?php 

	class ApiParent extends Controller {
		public function __construct(){
			parent::__construct();
		}

		public function search(){
			$post = json_decode(file_get_contents("php://input"));
			$parent_id = addslashes(trim($post->id));
			$parent_name = $parent_id; // this true only for this situation
			$occupation = addslashes(trim($post->occupation));

			// for pagination
			$start = 0;
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

			$this->load->model("parents");

            if(empty($parent_id)){
                $parent_id = NULL;
                $parent_name = NULL;
            }
            if(empty($occupation)){
                $occupation = NULL;
            }

            $result_set = $this->load->parents->search($start,$per_page,$parent_id,$parent_name,$occupation);
            $data['count'] = $this->load->parents->get_count()->fetch()['count'];
            if($result_set && count($result_set) > 0){
            	$body = "";
				foreach ($result_set as $result) {
					$body .="<tr>";
					$body .= "<td>".$result['id']."</td>";
					$body .= "<td>".$result['name']."</td>";
					$body .= "<td>".$result['type']."</td>";
					$body .= "<td class='text-center'>".$result['contact_number']."</td>";
					$body .= "<td class='text-center'>
								<div>
									<a href='".set_url('profile/parent/'.$result['id']). "'' class='btn t-d-none'><i title='profile' class='fas fa-user-circle profile-button'></i></a>
								</div>
							</td>";
					$body .= "<td class='text-center'>
								<a title='Delete' href='". set_url('parent/delete/'.$result['id'])."' class='btn t-d-none' onclick=\"show_dialog(this,'Delete message','Are you sure to delete?')\"><i class='fas fa-trash delete-button'></i></a>
							</td>";
					$body .="</tr>";
					}
				$data['body'] = $body;
				echo json_encode($data);
			}else{
				$body = "<tr><td colspan=10 class='text-center bg-red'>Students not found...</td></tr>";
				$data['body'] = $body;
				$data['count'] = 0;
				echo json_encode($data);
			}
		}
	}
 ?>