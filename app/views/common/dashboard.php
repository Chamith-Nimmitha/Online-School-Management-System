<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($msg)){
			echo "<p class='d-flex justify-content-center bg-lightgreen fb-green col-8 p-3'>";
			echo $msg;
			echo "</p>";
		}  
	?>
	<div id="school-statistics" class="col-12  justify-content-center ">
		<h2 class="text-center p-5">School Statistics</h2>
		<div class="statistics-flex justify-content-center">	
			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
				<h3 class="bb pb-1 text-center">Total Students</h3>
				<span class="pt-1"><?php if(isset($count['student'])){echo $count['student']; } ?></span>
			</div> 
			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
				<h3 class="bb pb-1 text-center">Total Teachers</h3>
				<span class="pt-1"><?php if(isset($count['teacher'])){echo $count['teacher']; } ?></span>
			</div> 
			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
				<h3 class="bb pb-1  text-center">Total Subjects</h3>
				<span class="pt-1"><?php if(isset($count['subject'])){echo $count['subject']; } ?></span>
			</div> 
			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
				<h3 class="bb pb-1  text-center">Total Classrooms</h3>
				<span class="pt-1"><?php if(isset($count['classroom'])){echo $count['classroom']; } ?></span>
			</div>
			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
				<h3 class="bb pb-1  text-center">Total Parents</h3>
				<span class="pt-1"><?php if(isset($count['parent'])){echo $count['parent']; } ?></span>
			</div>
			
		</div>
	</div> <!-- #school-statistics -->

		<hr class="w-100">
	<div id="school-attendance" class="col-12 d-flex flex-col align-items-center">
		<h2 class="text-center p-5">School Attendance</h2>
		<div class="col-12 d-flex justify-content-center">
			<form action="">
				<div class="d-flex">
					<label for="date">Date</label>
					<input type="date" name="date" id="date" class="ml-3">
				</div>
			</form>
		</div>
		<div class="statistics-flex  justify-content-center">	
			<div id="total-students-attendance" class="d-flex flex-col align-items-center bg-lightblue l-item m-2 p-3">
				<h3 class="bb pb-1 text-center">Total Students Attendance</h3>
				<span class="pt-1"> Presents : 900</span>
				<span class="pt-1"> Absent : 100</span>
			</div> <!-- #total-student-attendance -->

			<div id="total-teachers-attendance" class="d-flex flex-col align-items-center bg-lightblue l-item m-2 p-3">
				<h3 class="bb pb-1 text-center">Total Teachers Attendance</h3>
				<span> Presents : 135</span>
				<span> Absent : 10</span>
			</div> <!-- #total-teachers-attendance -->

		</div>
	</div> <!-- #school-attendance -->
</div> <!-- #content -->