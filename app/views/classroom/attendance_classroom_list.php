<?php include_once("session.php"); ?>
<?php require_once("../php/classes/classroom_info.class.php"); ?>

<?php
    $classroom_info_obj = new ClassroomInfo();
    $result_set = $classroom_info_obj->get_classroom_list();
?>

<?php require_once("../templates/header.php") ;?>
<?php require_once("../templates/aside.php"); ?>



<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">


		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('pages/attendance_classroom_list.php'); ?>" method="get" class="d-flex align-items-center col-12">
				<div class="d-flex col-12 align-items-center justify-content-center">
					<div class="mt-5">
						<input type="reset" class="btn btn-blue" onclick="reset_form(this)" value="reset">
					</div>
					<div class="ml-5">
						<label for="classroom-id">Classroom ID</label>
						<input type="text" name="classroom-id" id="classroom-id" placeholder="classroom ID" value="<?php if(isset($_GET['classroom-id'])){echo $_GET['classroom-id'];} ?>">
					</div>
					<div  class="  ml-5 align-items-center">
						<label for="grade" class="mr-3 d-normal">Grade : </label>
						<select name="grade" id="grade" style="width: 100px">
							<option value="all" <?php if(isset($_GET['grade'])){if($_GET['grade'] == "all"){echo 'selected="selected"';}}else{echo 'selected="selected"';} ?>>All</option>
							<option value="1" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "1")){echo 'selected="selected"';} ?> >1</option>
							<option value="2" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "2")){echo 'selected="selected"';} ?> >2</option>
							<option value="3" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "3")){echo 'selected="selected"';} ?> >3</option>
							<option value="4" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "4")){echo 'selected="selected"';} ?> >4</option>
							<option value="5" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "5")){echo 'selected="selected"';} ?> >5</option>
							<option value="6" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "6")){echo 'selected="selected"';} ?> >6</option>
							<option value="7" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "7")){echo 'selected="selected"';} ?> >7</option>
							<option value="8" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "8")){echo 'selected="selected"';} ?> >8</option>
							<option value="9" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "9")){echo 'selected="selected"';} ?> >9</option>
							<option value="10" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "10")){echo 'selected="selected"';} ?> >10</option>
							<option value="11" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "11")){echo 'selected="selected"';} ?> >11</option>
							<option value="12" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "12")){echo 'selected="selected"';} ?> >12</option>
							<option value="13" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "13")){echo 'selected="selected"';} ?> >13</option>
						</select>
					</div>
					<div  class="  ml-5 align-items-center">
						<label for="class" class="mr-3 d-normal">Class:</label>
						<select name="class" id="class">
							<option value="all" <?php if(isset($_GET['class']) && ($_GET['class'] == "all")){echo 'selected="selected"';} ?> >All</option>
							<option value="A" <?php if(isset($_GET['class']) && ($_GET['class'] == "A")){echo 'selected="selected"';} ?> >A</option>
							<option value="B" <?php if(isset($_GET['class']) && ($_GET['class'] == "B")){echo 'selected="selected"';} ?> >B</option>
							<option value="C" <?php if(isset($_GET['class']) && ($_GET['class'] == "C")){echo 'selected="selected"';} ?> >C</option>
							<option value="D" <?php if(isset($_GET['class']) && ($_GET['class'] == "D")){echo 'selected="selected"';} ?> >D</option>
							<option value="E" <?php if(isset($_GET['class']) && ($_GET['class'] == "E")){echo 'selected="selected"';} ?> >E</option>
							<option value="F" <?php if(isset($_GET['class']) && ($_GET['class'] == "F")){echo 'selected="selected"';} ?> >F</option>
							<option value="G" <?php if(isset($_GET['class']) && ($_GET['class'] == "G")){echo 'selected="selected"';} ?> >G</option>
							<option value="H" <?php if(isset($_GET['class']) && ($_GET['class'] == "H")){echo 'selected="selected"';} ?> >H</option>
						</select>				
					</div>
					<input type="submit" class="btn btn-blue ml-3 mt-5" value="Show">
				</div>
			</form>
		</div>

		<div class="col-10 flex-col" style="overflow-x: scroll;overflow-y: hidden;">

		    <table class="table-strip-dark">
			    <caption class="p-5"><b>ALL CLASSROOM ATTENDANCE</b></caption>
			    <thead>
				    <tr>
                        <th>Classroom ID</th>
                        <th>grade</th>
                        <th>class</th>
                        <th>class teacher</th>
                        <th>Attendance</th>
				    </tr>
			    </thead>
			    
                <tbody>

				<?php 
				foreach ($result_set as $result) {
                ?>

					<tr>
                        <td><?php echo $result['id']; ?></td>
                        <td class="text-center"><?php echo $result['grade']; ?></td>
                        <td class="text-center"><?php echo $result['class']; ?></td>
                        <td><?php echo $result['class_teacher_id']; ?></td>
						<td class="text-center">
							<div>
                				<a class="btn btn-blue" href="classroom_attendance_view.php?classroom-id=<?php echo $result['id']; ?> ">View</a>
		    				</div>
						</td>
					</tr>

				<?php
				}
                ?>
                 
                </tbody>
        
            </table>
        

		</div>  
</div>

<?php require_once("../templates/footer.php") ;?>
