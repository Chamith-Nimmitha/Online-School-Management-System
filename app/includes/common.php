<?php 
function check_input_fields($fields){
	// $feilds is a two dimentional array
	// each array in $fileds array, have four elements.
	// [  [min,max,is_required, field_name] ] 
	$field_errors = array();
	foreach($fields as $field => $constraints){
		$len = strlen(trim($_POST[$field]));
		if ( $len === 0 && $constraints[2] === 1 ){
			$field_errors[$field] = "$constraints[3] is required.";
		}else if( $len < $constraints[0] ){
			$field_errors[$field] = "$constraints[3] at least $constraints[0] characters.";
		}else if( $len > $constraints[1] ){
			$field_errors[$field] = "$constraints[3] must less than $constraints[0] characters.";
		}
	}
	return $field_errors;
}

// upload image files
function upload_file($file,$target,$size=2000000,$rename=NULL){
	$imageFileType = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
	if($rename === NULL){
		$target_file = $target . basename($file['name']);
	}else{
		$target_file = $target . $rename . ".$imageFileType";
	}
	$check = getimagesize($file['tmp_name']);

	//check if file already exist.
	// if(file_exists($target_file)){
	// 	return "Sorry, school badge already exists.";
	// }

	//check file size in bytes
	if($file['size'] > $size){
		return "Sorry, file is too large";
	}
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
		return "Only jpg,png,jpeg files are allowed.";
	}
	if(move_uploaded_file($file['tmp_name'], $target_file)){
		return 1;
	}else{
		return "File upload field.";	
	}
}

function valid_email($str) {
	return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

function validate_contact_number($str){
	//not number
	$number = trim($str);
	if(!ctype_digit($number)){
		return "Contact number must be a number";
	}
	//check number is mobile number
	// if( strlen($number) >2){
	// 	$isp = substr($str, 0,3);
	// 	if( !($isp == "070" || $isp == "071" || $isp == "072" || $isp == "075" || $isp == "076" || $isp == "077" || $isp == "078")){
	// 		return "Contact number must begin with 070, 071, 072, 075, 076, 077 or 078.";
	// 	}
	// }
	//not have 10 digit
	if(strlen($str) != 10 ){
		return "Contact Number must be 10 characters";
	}
	return 1;
}

?>