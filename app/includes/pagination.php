<?php

if(isset($_GET['ajax'])){
	display_pagination($_GET['count'],$_GET['current_page'],$_GET['per_page']);
}
function display_pagination($count,$current_page,$per_page,$route,$function_name){
	if(is_numeric($count)){
		$total = $count;
	}else{
		$total = $count->fetch()['count'];
	}
	$num_pages = ceil($total / $per_page);
	echo "<div id='pagination_div' class='mt-5 d-flex align-items-center justify-content-start w-100 flex-wrap'>";
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]"."/".explode("/", $_SERVER['REQUEST_URI'])[1]."/".$route;
	if($current_page != 1){
		// echo "<a class='t-d-none btn btn-blue' href='".$actual_link."/".($current_page-1)."/".$per_page."'>Perv</a>";
		echo "<button type='button' class='t-d-none btn btn-blue' onclick='".$function_name."(".($current_page-1).",".$per_page.")'>Perv</button>";
	}else{
		echo "<a class=' btn fg-white bg-gray' disabled='disabled'>Prev</a>";
	}
	for ($i=1; $i <= $num_pages; $i++) { 
		// echo "<a class='t-d-none btn pl-3 pr-3 ";
		echo "<button type='button' class='t-d-none btn pl-3 pr-3 ";
		if($current_page == $i){
			echo "btn-red";
		}else{
			echo "btn-blue";
		}
		// echo "' href='".$actual_link."/".$i."/".$per_page."'>".$i."</a>";
		echo "' onclick='".$function_name."(".($i).",".$per_page.")'>".$i."</button>";
			
	}
	if($current_page == $num_pages || $num_pages==0){
		echo "<a class='btn fg-white bg-gray' disabled='disabled'>Next</a>";
	}else{
		// echo "<a class='t-d-none btn btn-blue' href='".$actual_link."/".($current_page+1)."/".$per_page."'>Next</a>";
		echo "<button type='button' class='t-d-none btn btn-blue' onclick='".$function_name."(".($current_page+1).",".$per_page.")'>Next</button>";
	}
	echo "</div>";
	echo "<div class='w-100 d-flex align-items-center justify-content-end'>";
		echo "<p class='mr-3'>Per Page : </p>";
		echo "<button type='button' class='t-d-none btn pl-3 pr-3 ";
		if($per_page == 1){
			echo "btn-red";
		}else{
			echo "btn-blue";
		}
		echo "' onclick='".$function_name."(1,1)'>1</button>";
		echo "<button class='t-d-none btn pl-3 pr-3 ";
		if($per_page == 3){
			echo "btn-red";
		}else{
			echo "btn-blue";
		}
		echo "' onclick='".$function_name."(1,3)'>3</button>";
		echo "<button class='t-d-none btn pl-3 pr-3 ";
		if($per_page == 5){
			echo "btn-red";
		}else{
			echo "btn-blue";
		}
		echo "' onclick='".$function_name."(1,5)'>5</button>";
		echo "<button class='t-d-none btn pl-3 pr-3 ";
		if($per_page == 10){
			echo "btn-red";
		}else{
			echo "btn-blue";
		}
		echo "' onclick='".$function_name."(1,10)'>10</button>";
	echo "</div>";
}

 ?>