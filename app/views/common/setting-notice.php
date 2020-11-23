<?php require_once("../php/database.php") ?>
<?php require_once("../php/common.php") ?>

<?php
	$statemnt = "SELECT * FROM `notice`";
	$rls_set = $con->pure_query($statemnt)->fetchAll();
	
	if($rls_set){
		foreach ($rls_set as $data1) {
			$notice[$data1['id']."_text"] = $data1['text'];
			$notice[$data1['id']."_image"] = $data1['image'];
			$notice[$data1['id']."_reference"] = $data1['reference'];
		}
	}

if(isset($_POST['submit'])){

$note['1_text']=$_POST['notice1-text'];
$note['1_reference']=$_POST['notice1-ref'];
$note['2_text']=$_POST['notice2-text'];
$note['2_reference']=$_POST['notice2-ref'];
$note['3_text']=$_POST['notice3-text'];
$note['3_reference']=$_POST['notice3-ref'];
$note['4_text']=$_POST['notice4-text'];
$note['4_reference']=$_POST['notice4-ref'];
$note['5_text']=$_POST['notice5-text'];
$note['5_reference']=$_POST['notice5-ref'];
$note['1000_text']=$_POST['no-notice'];
$targ = "../img/notice_images/";

$errors1 = array();
$info1 = array();
    
$errors2 = array();
$info2 = array();

$errors3 = array();
$info3 = array();

$errors4 = array();
$info4 = array();

$errors5 = array();
$info5 = array();


		if(isset($_FILES['notice1-image']['tmp_name']) && !empty($_FILES['notice1-image']['tmp_name'])){
			$re1 = upload_file($_FILES['notice1-image'],$targ,2000000);
			$errors1 = $re1[1];
			$info1 = $re1[2];
			if(count($info1) == 1){
				$note['1_image'] = $_FILES['notice1-image']['name'];
				foreach ($note as $n => $val) {
					$id=explode("_",$n);
					
					if($id[1]=='text'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"text"=>$val));
					}
					else if($id[1]=='image'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"image"=>$val));	
					}					
					else if($id[1]=='reference'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"reference"=>$val));	
					}

					if(!$re1){
						
						if($id[1]=='text'){
							$con->update("notice",array("text"=>$val),array("id"=>$id[0]));
						}
						elseif ($id[1]=='image') {
							$con->update("notice",array("image"=>$val),array("id"=>$id[0]));
						}
						elseif ($id[1]=='reference') {
							$con->update("notice",array("reference"=>$val),array("id"=>$id[0]));
						}
					}					
				}
			}else{
				$error1 = "Error occured while uploading.<br>";
				array_push($errors1, $error1);
			}
		}

		if(isset($_FILES['notice2-image']['tmp_name']) && !empty($_FILES['notice2-image']['tmp_name'])){
			$re1 = upload_file($_FILES['notice2-image'],$targ,2000000);
			$errors2 = $re1[1];
			$info2 = $re1[2];
			if(count($info2) == 1){
				$note['2_image'] = $_FILES['notice2-image']['name'];
				foreach ($note as $n => $val) {
					$id=explode("_",$n);
					
					if($id[1]=='text'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"text"=>$val));
					}
					else if($id[1]=='image'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"image"=>$val));	
					}					
					else if($id[1]=='reference'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"reference"=>$val));	
					}

					if(!$re1){
						
						if($id[1]=='text'){
							$con->update("notice",array("text"=>$val),array("id"=>$id[0]));
						}
						elseif ($id[1]=='image') {
							$con->update("notice",array("image"=>$val),array("id"=>$id[0]));
						}
						elseif ($id[1]=='reference') {
							$con->update("notice",array("reference"=>$val),array("id"=>$id[0]));
						}
					}					
				}
			}else{
				$error1 = "Error occured while uploading.<br>";
				array_push($errors1, $error1);
			}
		}

		if(isset($_FILES['notice3-image']['tmp_name']) && !empty($_FILES['notice3-image']['tmp_name'])){
			$re1 = upload_file($_FILES['notice3-image'],$targ,2000000);
			$errors3 = $re1[1];
			$info3 = $re1[2];
			if(count($info3) == 1){
				$note['3_image'] = $_FILES['notice3-image']['name'];
				foreach ($note as $n => $val) {
					$id=explode("_",$n);
					
					if($id[1]=='text'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"text"=>$val));
					}
					else if($id[1]=='image'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"image"=>$val));	
					}					
					else if($id[1]=='reference'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"reference"=>$val));	
					}

					if(!$re1){
						
						if($id[1]=='text'){
							$con->update("notice",array("text"=>$val),array("id"=>$id[0]));
						}
						elseif ($id[1]=='image') {
							$con->update("notice",array("image"=>$val),array("id"=>$id[0]));
						}
						elseif ($id[1]=='reference') {
							$con->update("notice",array("reference"=>$val),array("id"=>$id[0]));
						}
					}					
				}
			}else{
				$error1 = "Error occured while uploading.<br>";
				array_push($errors1, $error1);
			}
		}

		if(isset($_FILES['notice4-image']['tmp_name']) && !empty($_FILES['notice4-image']['tmp_name'])){
			$re1 = upload_file($_FILES['notice4-image'],$targ,2000000);
			$errors4 = $re1[1];
			$info4 = $re1[2];
			if(count($info4) == 1){
				$note['4_image'] = $_FILES['notice4-image']['name'];
				foreach ($note as $n => $val) {
					$id=explode("_",$n);
					
					if($id[1]=='text'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"text"=>$val));
					}
					else if($id[1]=='image'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"image"=>$val));	
					}					
					else if($id[1]=='reference'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"reference"=>$val));	
					}

					if(!$re1){
						
						if($id[1]=='text'){
							$con->update("notice",array("text"=>$val),array("id"=>$id[0]));
						}
						elseif ($id[1]=='image') {
							$con->update("notice",array("image"=>$val),array("id"=>$id[0]));
						}
						elseif ($id[1]=='reference') {
							$con->update("notice",array("reference"=>$val),array("id"=>$id[0]));
						}
					}					
				}
			}else{
				$error1 = "Error occured while uploading.<br>";
				array_push($errors1, $error1);
			}
		}

		if(isset($_FILES['notice5-image']['tmp_name']) && !empty($_FILES['notice5-image']['tmp_name'])){
			$re1 = upload_file($_FILES['notice5-image'],$targ,2000000);
			$errors5 = $re1[1];
			$info5 = $re1[2];
			if(count($info5) == 1){
				$note['5_image'] = $_FILES['notice5-image']['name'];
				foreach ($note as $n => $val) {
					$id=explode("_",$n);
					
					if($id[1]=='text'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"text"=>$val));
					}
					else if($id[1]=='image'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"image"=>$val));	
					}					
					else if($id[1]=='reference'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"reference"=>$val));	
					}

					if(!$re1){
						
						if($id[1]=='text'){
							$con->update("notice",array("text"=>$val),array("id"=>$id[0]));
						}
						elseif ($id[1]=='image') {
							$con->update("notice",array("image"=>$val),array("id"=>$id[0]));
						}
						elseif ($id[1]=='reference') {
							$con->update("notice",array("reference"=>$val),array("id"=>$id[0]));
						}
					}					
				}
			}else{
				$error1 = "Error occured while uploading.<br>";
				array_push($errors1, $error1);
			}
		}

				foreach ($note as $n => $val) {
					$id=explode("_",$n);
					
					if($id[1]=='text'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"text"=>$val));
					}					
					else if($id[1]=='reference'){
					$re1 = $con->insert("notice",array("id"=>$id[0],"reference"=>$val));	
					}

					if(!$re1){
						
						if($id[1]=='text'){
							$con->update("notice",array("text"=>$val),array("id"=>$id[0]));
						}
						elseif ($id[1]=='reference') {
							$con->update("notice",array("reference"=>$val),array("id"=>$id[0]));
						}
					}					
				}






$con->update("notice",array("text"=>$note['1000_text']),array("id"=>"1000"));

}

	$statemnt = "SELECT * FROM `notice`";
	$rls_set = $con->pure_query($statemnt)->fetchAll();
	
	if($rls_set){
		foreach ($rls_set as $data1) {
			$notice[$data1['id']."_text"] = $data1['text'];
			$notice[$data1['id']."_image"] = $data1['image'];
			$notice[$data1['id']."_reference"] = $data1['reference'];
		}
	}

	



?>

<?php require_once("../templates/header.php") ?>
<?php require_once("../templates/aside.php") ?>


<?php 
		/*if(isset($errors) && !empty($errors)){
			echo "<p class='float-left w-75 bg-red p-2'>";
			foreach ($errors as $error) {
				echo $error . "<br>";
			}
			echo "</p>";
		}

		if(isset($info) && !empty($info)){
			echo "<p class='float-left w-75 bg-green p-2'>";
			foreach ($info as $in) {
				echo $in . "<br>";
			}
			echo "</p>";
		}*/
?>



<div id="content" class="col-9 flex-col align-items-center justify-content-start">

	<form action="setting-notice.php" method="post" enctype="multipart/form-data">
		<fieldset>	
			<legend>Notice Settings</legend>
				<div class="form-group">
					<label for="no-notice">Number of Notices</label>
					<input type="text" name="no-notice" id="no-notice" value="<?php if(!empty($notice['1000_text'])){echo $notice['1000_text'];} ?>">
				</div>

				<br><br>

			<fieldset>
				<legend>Notice-1</legend>

				<div class="form-group">
					<label for="notice1-text">Notice Text</label>
					<input type="text" name="notice1-text" id="notice1-text" value="<?php if(!empty($notice['1_text'])){echo $notice['1_text'];} ?>">
				</div>

				<div class="form-group">
					<label for="notice1-image">Insert Image</label>
					<input type="file" name="notice1-image" id="notice1-image">
				</div>

				<div class="form-group">
					<label for="notice1-ref">Notice Reference</label>
					<input type="text" name="notice1-ref" id="notice1-ref" value="<?php if(!empty($notice['1_reference'])){echo $notice['1_reference'];} ?>">
				</div>

			</fieldset>

			<fieldset>
				<legend>Notice-2</legend>

				<div class="form-group">
					<label for="notice2-text">Notice Text</label>
					<input type="text" name="notice2-text" id="notice2-text" value="<?php if(!empty($notice['2_text'])){echo $notice['2_text'];} ?>">
				</div>

				<div class="form-group">
					<label for="notice2-image">Insert Image</label>
					<input type="file" name="notice2-image" id="notice2-image">
				</div>

				<div class="form-group">
					<label for="notice2-ref">Notice Reference</label>
					<input type="text" name="notice2-ref" id="notice2-ref" value="<?php if(!empty($notice['2_reference'])){echo $notice['2_reference'];} ?>">
				</div>

			</fieldset>

			<fieldset>
				<legend>Notice-3</legend>

				<div class="form-group">
					<label for="notice3-text">Notice Text</label>
					<input type="text" name="notice3-text" id="notice3-text" value="<?php if(!empty($notice['3_text'])){echo $notice['3_text'];} ?>">
				</div>

				<div class="form-group">
					<label for="notice3-image">Insert Image</label>
					<input type="file" name="notice3-image" id="notice3-image">
				</div>

				<div class="form-group">
					<label for="notice3-ref">Notice Reference</label>
					<input type="text" name="notice3-ref" id="notice3-ref" value="<?php if(!empty($notice['3_reference'])){echo $notice['3_reference'];} ?>">
				</div>

			</fieldset>

			<fieldset>
				<legend>Notice-4</legend>

				<div class="form-group">
					<label for="notice4-text">Notice Text</label>
					<input type="text" name="notice4-text" id="notice4-text" value="<?php if(!empty($notice['4_text'])){echo $notice['4_text'];} ?>">
				</div>

				<div class="form-group">
					<label for="notice4-image">Insert Image</label>
					<input type="file" name="notice4-image" id="notice4-image">
				</div>

				<div class="form-group">
					<label for="notice4-ref">Notice Reference</label>
					<input type="text" name="notice4-ref" id="notice4-ref" value="<?php if(!empty($notice['4_reference'])){echo $notice['4_reference'];} ?>">
				</div>

			</fieldset>

			<fieldset>
				<legend>Notice-5</legend>

				<div class="form-group">
					<label for="notice5-text">Notice Text</label>
					<input type="text" name="notice5-text" id="notice5-text" value="<?php if(!empty($notice['5_text'])){echo $notice['5_text'];} ?>">
				</div>

				<div class="form-group">
					<label for="notice5-image">Insert Image</label>
					<input type="file" name="notice5-image" id="notice5-image">
				</div>

				<div class="form-group">
					<label for="notice5-ref">Notice Reference</label>
					<input type="text" name="notice5-ref" id="notice5-ref" value="<?php if(!empty($notice['5_reference'])){echo $notice['5_reference'];} ?>">
				</div>

			</fieldset>
<!--
			</fieldset>

			<fieldset>
				<legend>Notice-6</legend>

				<div class="form-group">
					<label for="notice6-text">Notice Text</label>
					<input type="text" name="notice6-text" id="notice6-text" value="<?php /*if(!empty($notice['6_text'])){echo $notice['6_text'];} */?>">
				</div>

				<div class="form-group">
					<label for="notice6-image">Insert Image</label>
					<input type="file" name="notice6-image" id="notice6-image">
				</div>

				<div class="form-group">
					<label for="notice6-ref">Notice Reference</label>
					<input type="text" name="notice6-ref" id="notice6-ref" value="<?php/* if(!empty($notice['5_reference'])){echo $notice['6_reference'];*/} ?>">
				</div>

			</fieldset>

-->

				<div class="form-group">
					<button type="submit" name="submit" class="btn btn-blue">Submit</button>
				</div>

		</fieldset>
	</form>

</div> <!-- #content -->


<?php 	require_once("../templates/footer.php") ?>