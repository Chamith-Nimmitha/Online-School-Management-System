<?php 
	if(!isset($_SESSION)){
		session_start();
	}
 ?>
<?php require_once( realpath(dirname(__FILE__)). "/../php/common.php" ); ?>
<?php require_once( realpath(dirname(__FILE__)). "/../php/database.php" ); ?>

<?php 
	$result = $con->select("student",array("parent_id"=>$_SESSION['user_id']));
	if($result){
		$students = $result->fetchAll();
	}

 ?>


<?php require_once("../templates/header.php") ;?>
<?php require_once("../templates/aside.php"); ?>

	<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
		<div class="col-8 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
		    <table class="table-strip-dark">
			    <caption class="p-5"><b>Children List</b></caption>
			    <thead>
				    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Grade</th>
                        <th>Classroom</th>
                        <th>Timetable</th>
                        <th>Attendance</th>
                        <th>Exam Results</th>
				    </tr>
			    </thead>  
                <tbody>
                    <?php if(isset($students) && !empty($students)){
                    	foreach ($students as $student) { ?>
                    		<tr>
                    			<td><?php echo $student['id']; ?></td>
                    			<td><?php echo $student['name_with_initials']; ?></td>
                    			<td><?php echo $student['grade']; ?></td>
                    			<td class="text-center">
                    				<a href="<?php echo set_url('pages/classroom_student_view.php',array('classroom_id'=>$student['classroom_id'])); ?>" class="btn btn-blue p-1">Info</a>
                    			</td>
                    			<td class="text-center">
                    				<a href="<?php echo set_url('pages/student_timetable_view.php',array("student_id"=>$student
                                    ['id'])) ?>" class="btn btn-blue p-1">view</a>
                    			</td>
                    			<td class="text-center">
                    				<a href="<?php echo set_url('pages/student_attendance_view.php') ?>" class="btn btn-blue p-1">Report</a>
                    			</td>
                    			<td class="text-center">
                    				<a href="<?php echo set_url('pages/student_marks_report.php') ?>" class="btn btn-blue p-1">Report</a>
                    			</td>
                    		</tr>	
                    <?php 
                		}
                    } ?>
                </tbody>
            </table>
            <div class="w-100 p-1"></div>
		</div>
	</div>

<?php require_once("../templates/footer.php"); ?>