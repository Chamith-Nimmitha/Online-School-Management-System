<?php

if(isset($_GET['ajax'])){
	display_pagination($_GET['count'],$_GET['current_page'],$_GET['per_page']);
}
function display_pagination($count,$current_page,$per_page,$route,$function_name,$options=[]){
	if(is_numeric($count)){
		$total = $count;
	}else{
		$total = $count->fetch()['count'];
	}
	echo "<hr class='col-12'>";
	$num_pages = ceil($total / $per_page);
	echo "<div class='pagination_div mt-5 d-flex align-items-center justify-content-end w-100 flex-wrap'>";
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]"."/".explode("/", $_SERVER['REQUEST_URI'])[1]."/".$route;
	
	// ECHO PAGES
	if($current_page != 1){
		echo "<button type='button' class='t-d-none btn pagination-btn1' onclick='".$function_name."(".($current_page-1).",".$per_page.")'>Perv</button>";
	}else{
		echo "<button class=' btn fg-white pagination-btn3' disabled='disabled'>Prev</button>";
	}

	for ($i=1; $i <= $num_pages; $i++) { 
		echo "<button type='button' class='t-d-none btn pl-3 pr-3 ";
		if($current_page == $i){
			echo "pagination-btn2";
		}else{
			echo "pagination-btn1";
		}
		echo "' onclick='".$function_name."(".($i).",".$per_page.")'>".$i."</button>";
			
	}
	if($current_page == $num_pages || $num_pages==0){
		echo "<button class='btn fg-white pagination-btn3' disabled='disabled'>Next</button>";
	}else{
		echo "<button type='button' class='t-d-none btn pagination-btn1' onclick='".$function_name."(".($current_page+1).",".$per_page.")'>Next</button>";
	}
	echo "</div>";

	//  ECHO PER PAGE OPTIONS
	echo "<div class='w-100 d-flex align-items-center justify-content-start'>";
		echo "<p class='mr-3'>Per Page : </p>";
		echo "<button type='button' class='t-d-none btn pl-3 pr-3 ";
		if($per_page == 1){
			echo "pagination-btn2";
		}else{
			echo "pagination-btn1";
		}
		echo "' onclick='".$function_name."(1,1)'>1</button>";
		echo "<button class='t-d-none btn pl-3 pr-3 ";
		if($per_page == 3){
			echo "pagination-btn2";
		}else{
			echo "pagination-btn1";
		}
		echo "' onclick='".$function_name."(1,3)'>3</button>";
		echo "<button class='t-d-none btn pl-3 pr-3 ";
		if($per_page == 5){
			echo "pagination-btn2";
		}else{
			echo "pagination-btn1";
		}
		echo "' onclick='".$function_name."(1,5)'>5</button>";
		echo "<button class='t-d-none btn pl-3 pr-3 ";
		if($per_page == 10){
			echo "pagination-btn2";
		}else{
			echo "pagination-btn1";
		}
		echo "' onclick='".$function_name."(1,10)'>10</button>";
	echo "</div>";
}

 ?>