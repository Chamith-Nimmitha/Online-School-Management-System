<script >
function showDiv() {
   document.getElementById('report').style.display = "";
}
</script>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
    <?php 
        if(isset($msg) && !empty($msg)){
            echo '<div class="">';
            echo $msg;
            echo '</div>';
        }
    ?>

    <div class="mt-5  w-75 d-flex flex-col align-items-center">
        <h2 class="pt-3 pb-3">Classroom Marks Upload</h2>
        <hr class="topic-hr w-100">
    </div>
    <div id="marks_notification" class="d-none w-75">
        <p style="background: #eee;" class="w-100 p-2 text-center fg-red"> </p>
    </div>
    <div class="d-flex justify-content-center align-items-center">
        <form id="marks_filter" class="d-flex align-items-center col-12" method="POST" enctype="multipart/form-data" action="<?php echo set_url("marks/classroom/view/$classroom_id/$t");?>">
            <div class="d-flex col-12 align-items-center justify-content-center">
                <div class="mt-5">
                    <input type="reset" class="btn btn-blue" onclick="reset_form('marks_filter')" value="reset">
                </div>
                <input type="hidden" name="classroom_id" id="marks_classroom_id" class="btn btn-blue" value="<?php echo $classroom_data['id']; ?>">
                <input type="hidden" name="classroom_grade" id="marks_classroom_grade" class="btn btn-blue" value="<?php echo $classroom_data['grade']; ?>">
                <div class="ml-5">
                    <label for="term">Term</label>
                    <select name="term" id="term">
                        <option value="0">Select Term</option>
                        <option value="1">1st Term</option>
                        <option value="2">2nd Term</option>
                        <option value="3">3rd Term</option>
                    </select>
                </div>
                <button  class="btn btn-blue ml-3 mt-5" name="filter" onclick="//classroom_marks_search()" value="Show">Filter</button>
            </div>
        </form>
    </div>
    <form  id="upload_marks" class="col-12 d-flex justify-content-center" method="POST" enctype="multipart/form-data" action="<?php echo set_url("marks/classroom/view/$classroom_id/$t");?>">
        <div class="col-10 flex-col" style="overflow-x: scroll;overflow-y: hidden;"> 
            <table class="table-strip-dark">
                <caption class="p-5"><b>Student Marks<br><?php if(isset($classroom_data['grade'])){echo 'Grade-'.$classroom_data['grade'].$classroom_data['class']; }?><br><?php if(isset($y)){echo 'Year-'.$y; }?><br><?php if(isset($t)){echo 'Term-'.$t; }?><br></b></caption>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            	<?php 
                            		foreach ($subject_list as $subject) {
                            	?>
                            				<th width='6%'><?php echo substr($subject['name'],0,3);?></th>
                            	<?php
                            		}
                            	?>

                            <th >View Marks</th>
                        </tr>
                    </thead>
                    <tbody id="tbody" class="p-1">
                        <?php 
                            if(isset($student_list) && !empty($student_list)){
                                foreach ($student_list as $student) {
                         ?>
                         <tr>
                            <td><?php echo $student['id']; ?></td>
                            <td><?php echo $student['name_with_initials']; ?></td>
                            	<?php 
                            		foreach ($subject_list as $subject) {
                            	?>
                            		<td><input type="text" name="<?php echo $student['id'].'-'.$subject['id']; ?>" id="<?php echo $student['id'].'-'.$subject['id']; ?>" placeholder="" value="<?php if(isset($std_marks[$student['id'].'-'.$subject['id']])){echo $std_marks[$student['id'].'-'.$subject['id']];} ?>" maxlength="3" disabled></td>
                            	<?php 
                            	}

		                        ?>
                            <td><a class="btn btn-blue" href="<?php echo set_url('student/marks/report/'.$student['id']); ?>">View Report</a></td>
                        </tr> 
                        <?php 
                                }
                            }else{
                                echo "<tr><td colspan=10 class='text-center bg-red'>Student not found...</td></tr>";
                            }
                         ?>                                   
                    </tbody>
            </table>
            <br>
            <div class="align-items-center justify-content-end">

        	</div>	
        </div>

<?php 
    if($_SESSION['role']=='admin'){
        echo '<div class="d-flex flex-row w-75 justify-content-center align-items-center">';
        echo '<label></b>Upload Student Marksheet&nbsp&nbsp&nbsp</b></label>';
        echo '<input type="file" name="filename" id="filename">';
        echo '<input type="submit" name="submit" id="submit" onclick="//mark_classroom_attendance()" class="btn btn-blue m-1">';
        echo '</div>';
    }
?>
    </form>
    <button onclick="showDiv()" class="btn btn-blue m-1">Show Classroom Reports</button>
	<div class="col-12 justify-content-around" style="display: none" id="report">
		<!-- subject grades pie -->
		<script >subject_grades_pie();student_result_overview_bar();subject_average_overview_bar();</script>
		<div class="mt-5 border b-rad" style="width: 45%;" >

			<div class="d-flex align-items-center justify-content-center  m-0 p-0">
				<h4><b>Classroom Subject Report</b></h4>
			</div>
			<div class="d-flex align-items-center justify-content-center  ">
				<h4><b><?php echo 'Grade-'.$classroom_data['grade'].$classroom_data['class']; ?></b></h4>
			</div>
		<form id="dashboard_marks_filter">
			<div class="d-flex align-items-center">
                    <label for="term" class="p-2">Term</label>
                    <select name="term" id="term"  onchange="subject_grades_pie()">
                        <option value="1">1st Term</option>
                        <option value="2">2nd Term</option>
                        <option value="3">3rd Term</option>
                    </select>

                    <label for="year" class="p-2">Subject</label>
                    <select name="subject" id="subject" onchange="subject_grades_pie()">
                        <?php 
                        	foreach ($subject_list as $subject) {
                        		?>
                        		<option value="<?php echo $subject['id'] ?>"><?php echo $subject['name'] ?></option>
                        <?php		
                        	}
                        ?>
                    </select>


			</div>
			</form>
			<div class="bg-white p-5 w-100">
				<canvas id="subject_grades_pie" width="100" height="100"></canvas>
			</div>
		</div>

		<div class="mt-5 p-1 border b-rad" style="width: 45%;">

			<div class="d-flex align-items-center justify-content-center  ">
				<h4><b>Classroom Marks Report</b></h4>
			</div>
			<div class="d-flex align-items-center justify-content-center  ">
				<h4><b><?php echo 'Grade-'.$classroom_data['grade'].$classroom_data['class']; ?></b></h4>
			</div>

			<div class="bg-white p-5 w-100" style="margin-top:52px">
				<canvas id="student_result_overview_bar" width="100" height="100"></canvas>
			</div>
		</div>

		<div class="mt-5 border b-rad" style="width: 100%;">
			<div class="d-flex align-items-center justify-content-center  ">
				<h4><b>Subject Average Report</b></h4>
			</div>
			<div class="d-flex align-items-center justify-content-center ">
				<h4><b><?php echo 'Grade-'.$classroom_data['grade'].$classroom_data['class']; ?></b></h4>
			</div>

			<div class="bg-white p-5 w-100" style="margin-top:30px">
				<canvas id="subject_average_overview_bar" width="100" height="50"></canvas>
			</div>
		</div>

	</div>
</div>

