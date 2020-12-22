<?php require_once("../php/database.php") ?>
<?php require_once("../php/common.php") ?>
<?php require_once("../templates/header.php") ?>
<?php require_once("../templates/aside.php") ?>



<?php 
if(isset($_POST['submit'])){

	$query1 = "SELECT * FROM student WHERE grade='10'";

	$result_sets = $con->pure_query($query1)->fetchAll();

	echo 
'<div id="content" class="col-9 flex-col align-items-center justify-content-start">
		<form action="exam_mark_view.php" method="post" enctype="multipart/form-data" >
		<fieldset class="col-12">
			<legend>Enter Marks</legend>

				<div class="form-group">
					<label for="classes">Select Grade</label>
					<input type="text" value="10" disabled></input>
				</div>

				<div class="form-group">
					<label for="class">Select Division</label>
					<input type="text" value="B" disabled></input>
				</div>

				<div class="form-group">
					<label for="exam">Select The Exam</label>
					<input type="text" value='.$_POST['exam'].' disabled></input>
				</div>


				<div class="form-group">
					<label for="subjects">Select Subject</label>
					<input type="text" value='.$_POST['subjects'].' disabled></input>
				</div>

		</fieldset>
		</form>

		<center>
	    <form method="POST" enctype="multipart/form-data">
            <br/><br/><br/>
            <div align="center">
                <label>Select a File:</label>
                <input type="file" name="file"/>
                <br/>
                <input type="submit" name="submit" value="Import" class="btn btn-info"/>
            </div>
        </form>

	   </center>		

<div class="row">
<div class="container col-12 table table-strip-dark text-center">
<table style="width:1010px">
		    <tr class="">
    			<th>ID</th>
    			<th>Name</th>
    			<th>Marks</th>
    			<th>Grade Point</th>
    			<th>Comments</th>
  			</tr>';

		if($result_sets){
		foreach ($result_sets as $data) {
			echo '<tr>
					<td>'.$data['id'].'</td>
					<td>'.$data['name_with_initials'].'</td>
					<td>
					
					<form>

						<div class="form-group">
							<div>
								<input type="text" name="marks" value="93" class="form-group" maxlength="3" size="3" disabled></input>
							</div>
					
						</div>
					</form>

					</td>

					<td>
					A+
					</td>

					<td>

						<form>
							<div class="form-group">
								<div>
									<input type="text" name="comments" value="Very Good" class="form-group" size="15" disabled></input>
								</div>

					</td>
				  </tr>
					</table>
					</div>
					</div>
					';
		}
		

	}





}

else{

	/*
<div id="content" class="col-9 flex-col align-items-center justify-content-start">

		<form action="exam_mark_upload.php" method="post" enctype="multipart/form-data" >

		<fieldset class="col-12">

			<legend>Enter Marks</legend>

				<div class="form-group">

					<label for="exam">Select The Exam</label>
					<select name="exam" id="">
						<option value="First-Term-Exam">First Term Exam</option>
						<option value="Second-Term-Exam">Second Term Exam</option>
						<option value="Third-Term-Exam">Third Term Exam</option>
						<option value="Model-Exam">Model Exam</option>
					</select>

				</div>

				<div class="form-group">

					<label for="classes">Select Grade</label>
					<select name="classes" id="">
  						<option value="1">1</option>
  						<option value="2">2</option>
 						<option value="3">3</option>
  						<option value="4">4</option>
  						<option value="5">5</option>
  						<option value="6">6</option>
  						<option value="7">7</option>
  						<option value="8">8</option>
  						<option value="9">9</option>
  						<option value="10">10</option>
  						<option value="11">11</option>
  						<option value="12">12</option>
					</select>

				</div>

				<div class="form-group">

					<label for="section">Select Division</label>
					<select name="section" id="">
						<option value="A">A</option>
						<option value="B">B</option>
						<option value="C">C</option>
						<option value="D">D</option>
						<option value="E">E</option>
					</select>

				</div>


				<div class="form-group">

					<label for="subjects">Select Subject</label>
					<select name="subjects" id="">
  						<option value="Mathematics">Mathematics</option>
  						<option value="Science">Science</option>
 						<option value="English">English</option>
				</div>

				<div class="form-group">

					<input type="submit" name="submit" class="m-2 btn btn-blue">

				</div>


		</fieldset>
	</form>
</div>

	*/
echo '

<div id="content" class="col-9 flex-col align-items-center justify-content-start">

		<form action="exam_mark_view.php" method="post" enctype="multipart/form-data" >
		
		<fieldset class="col-12">
			<legend>Enter Marks</legend>


				<div class="form-group">

					<label for="classes">Select Grade</label>
					<input type="text" value="10" disabled></input>

				</div>

				<div class="form-group">

					<label for="section">Select Division</label>
					<input type="text" value="B" disabled></input>

				</div>

				<div class="form-group">

					<label for="exam">Select The Exam</label>
					<select name="exam" id="">
						<option value="First-Term-Exam">First Term Exam</option>
						<option value="Second-Term-Exam">Second Term Exam</option>
						<option value="Third-Term-Exam">Third Term Exam</option>
						<option value="Model-Exam">Model Exam</option>
						<option value="Unit-Exam">Unit Exam</option>
					</select>

				</div>


				<div class="form-group">

					<label for="subjects">Select Subject</label>
					<select name="subjects" id="">
  						<option value="Mathematics">Mathematics</option>
  						<option value="Science">Science</option>
 						<option value="English">English</option>
 						<option value="Physics">Physics</option>
 						<option value="Chemistry">Chemistry</option>
 						<option value="Biology">Biology</option>
 						<option value="History">History</option>
 						<option value="ICT">ICT</option>

				</div>

				<div class="form-group">

					<input type="submit" name="submit" class="m-2 btn btn-blue">

				</div>


		</fieldset>
	</form>
</div>

</div>
';

}
?>

<?php require_once("../templates/footer.php") ?>
