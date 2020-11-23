<?php

if(isset($_GET['ajax'])){
	display_pagination($_GET['count'],$_GET['current_page'],$_GET['per_page']);
}
function display_pagination($count,$current_page,$per_page){
	if(is_numeric($count)){
		$total = $count;
	}else{
		$total = $count->fetch()['count'];
	}
	$num_pages = ceil($total / $per_page);
	echo "<div id='pagination_div' class='mt-5 d-flex align-items-center justify-content-start w-100 flex-wrap'>";
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$actual_link = explode("page=", $actual_link)[0];
	if( strpos($actual_link, "?") === FALSE){
		$actual_link .= "?";
	}
	
	if(strripos($actual_link, "&") !== strlen($actual_link)-1 && strripos($actual_link, "?") !== strlen($actual_link)-1 ){
		$actual_link .= "&";
	}
	if(isset($_GET['actual_link'])){
		$actual_link = $_GET['actual_link'];
		$actual_link = str_replace("@", "&", $actual_link);
	}
	if($current_page != 1){
		echo "<a class='t-d-none btn btn-blue' href='".$actual_link."page=".($current_page-1)."&per_page=".$per_page."'>Perv</a>";
	}else{
		echo "<a class=' btn fg-white bg-gray' disabled='disabled'>Prev</a>";
	}
	for ($i=1; $i <= $num_pages; $i++) { 
		echo "<a class='t-d-none btn pl-3 pr-3 ";
		if($current_page == $i){
			echo "btn-red";
		}else{
			echo "btn-blue";
		}
		echo "' href='".$actual_link."page=".$i."&per_page=".$per_page."'>".$i."</a>";
			
	}
	if($current_page == $num_pages || $num_pages==0){
		echo "<a class='btn fg-white bg-gray' disabled='disabled'>Next</a>";
	}else{
		echo "<a class='t-d-none btn btn-blue' href='".$actual_link."page=".($current_page+1)."&per_page=".$per_page."'>Next</a>";
	}
	echo "</div>";
	echo "<div class='w-100 d-flex align-items-center justify-content-end'>";
		echo "<p class='mr-3'>Per Page : </p>";
		echo "<a class='t-d-none btn pl-3 pr-3 ";
		if($per_page == 1){
			echo "btn-red";
		}else{
			echo "btn-blue";
		}
		echo "' href='".$actual_link."page=1&per_page=1'>1</a>";
		echo "<a class='t-d-none btn pl-3 pr-3 ";
		if($per_page == 3){
			echo "btn-red";
		}else{
			echo "btn-blue";
		}
		echo "' href='".$actual_link."page=1&per_page=3'>3</a>";
		echo "<a class='t-d-none btn pl-3 pr-3 ";
		if($per_page == 5){
			echo "btn-red";
		}else{
			echo "btn-blue";
		}
		echo "' href='".$actual_link."page=1&per_page=5'>5</a>";
		echo "<a class='t-d-none btn pl-3 pr-3 ";
		if($per_page == 10){
			echo "btn-red";
		}else{
			echo "btn-blue";
		}
		echo "' href='".$actual_link."page=1&per_page=10'>10</a>";
	echo "</div>";
}

 ?>