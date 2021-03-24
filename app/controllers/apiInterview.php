
<?php 

	class ApiInterview extends Controller {
		public function __construct(){
			parent::__construct();
		}

		public function search(){
			$post = json_decode(file_get_contents("php://input"));
			$adm_id = addslashes(trim($post->adm_id));
			$panel_id = addslashes(trim($post->panel_id));
			$state = addslashes(trim($post->state));

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

			$this->load->model("interview");

            if(empty($adm_id)){
                $adm_id = NULL;
            }
            if(empty($panel_id)){
                $panel_id = NULL;
            }
            if(empty($state)){
                $state = NULL;
            }

            $time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];

            $result_set = $this->load->interview->search($start,$per_page,$adm_id,$panel_id,$state);
            $data['count'] = $this->load->interview->get_count()->fetch()['count'];
            if($result_set && $result_set->rowCount() > 0){
            	$body = "";
            	$result_set = $result_set->fetchAll();
				foreach ($result_set as $result) {
					$body .="<tr>";
					$body .= "<td>".$result['id']."</td>";
					$body .= "<td>".$result['admission_id']."</td>";
					$body .= "<td>".$result['date']."</td>";
					$body .= "<td>".$time_map[$result['period']]."</td>";
					$body .= "<td>".$result['interview_panel_id']."</td>";
					if($result['state'] == 'notInterviewed'){
						$body .= "<td style='background:#009922'>To be Interview</td>";
					}else{
						$body .= "<td style='background:#333333;color:white;' class='text-center'>".$result['state']."</td>";
					}

					$body .= "<td><a class='t-d-none btn btn-blue p-1' href='".set_url('interview/view/').$result['admission_id']."'>View</a></td>";
					if($_SESSION['role'] == "admin"){
						$body .= "<td><a class='d-flex justify-content-center t-d-none btn p-1' href='".set_url('interview/delete/').$result['admission_id']."' onclick=\"show_dialog(this,'Delete message','Are you sure to delete?')\"><i class='fas fa-trash delete-button'></i></a></td>";
					}
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