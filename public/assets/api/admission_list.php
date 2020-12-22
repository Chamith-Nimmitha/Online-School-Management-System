<?php 
	$con = new Database();
	if(isset($data) && isset($type)){
		if(strlen($data) > 0 && strlen($data) <3){
			if($type =="all"){
				$query = "SELECT  * FROM `admission` WHERE grade='{$data}' OR name_with_initials like '%{$data}%' LIMIT 20";
			}else{
				$query = "SELECT * FROM `admission` WHERE (grade={$data} OR name_with_initials like '%{$data}%')	 AND state='{$type}' LIMIT 20";
			}
		}else if(strlen($data) > 2){
			if($type =="all"){
				$query = "SELECT * FROM `admission` WHERE id like '%{$data}%' OR name_with_initials like '%{$data}%' LIMIT 20";
			}else{
				$query = "SELECT * FROM `admission` WHERE (id like '%{$data}%' OR name_with_initials like '%{$data}%') AND state='{$type}' LIMIT 20";
			}
		}else{
			if($type =="all"){
				$query = "SELECT *FROM `admission` LIMIT 20";
			}else{
				$query = "SELECT *FROM `admission` WHERE state='{$type}' LIMIT 20";
			}
		}
		$result_set = $con->pure_query($query);
		if($result_set && $result_set->rowCount() >0 ){
			$result_set = $result_set->fetchAll();
			foreach ($result_set as $result) {
				$row ="<tr>";
				$row .= "<td>".$result['id']."</td>";
				$row .= "<td>".stripslashes($result['name_with_initials'])."</td>";
				$row .= "<td>".$result['grade']."</td>";
				$row .= "<td>".stripslashes($result['address'])."</td>";
				if($result['state'] == 'accepted'){
					$row .= "<td style='background:#009922'>".$result['state']."</td>";
				}else if($result['state'] == 'deleted'){
					$row .= "<td style='background:#ff5555'>".$result['state']."</td>";
				}else if($result['state'] == 'read'){
					$row .= "<td style='background:#ffffff'>".$result['state']."</td>";
				}else if($result['state'] == 'unread'){
					$row .= "<td style='background:#00ffff'>".$result['state']."</td>";
				}else{
					$row .= "<td style='background:#333333;color:white'>".$result['state']."</td>";
				}

				$row .= "<td><a href=\"admission_view.php?admission-id=".$result['id']."&back=http://localhost/sms/pages/admissions_all.php?aside-link-selector=all\">view</a></td>";
				$row .= "<td><a href=". set_url('pages/admissions_all.php').'?admission-search=';
				if(isset($_GET['admission-search'])){
					$row .= $_GET['admission-search'];
				}else{
					$row .= "all";
				}
				$row .='&delete='.$result['id'].">delete</a></td>";
				$row .= "</tr>";
				echo $row;
			}
				echo "</tbody>";
				echo "</table>";
		}else{
			echo "<tr><td colspan=7 class='text-center bg-red'>Students not found...</td></tr>";
			echo "</tbody>";
			echo "</table>";
		}
	}
 ?>