<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<?php 
		if(isset($error) && !empty($error)){
			echo "<p class='bg-red d-flex justify-content-center col-8 p-3'>";
			echo $error;
			echo "</p>";
		}
	 ?>

	<h2 class="mt-5 mb-5"><?php if(isset($result) && !empty($result)){echo "{$result['grade']}-{$result['class']}";} ?> Classroom View</h2>
	<hr class="topic-hr w-75">
	<div class="col-12 d-flex flex-col align-items-center">
		 <form class="col-8">
	        <fieldset class="p-4 col-12">
	        	<legend>Classroom Info</legend>
	            <div class="d-flex w-100">
	                <label class="col-4">Section</label>
	                <input type="text" value="<?php echo $result['category'] ?>" disabled="disabled">
	            </div>

	            <div class="d-flex w-100">
	                <label class="col-4">Grade</label>
	                <input type="text" value="<?php echo $result['grade'] ?>" disabled="disabled">
	            </div>
	                
	            <div class="d-flex w-100">
	                <label class="col-4">Class</label>
	                <input type="text" value="<?php echo $result['class'] ?>" disabled="disabled">
	            </div>


	            <div class="d-flex w-100">
	                <label class="col-4">Class Teacher</label>
	                <input type="text" value="<?php if(isset($result['class_teacher_name'])){echo $result['class_teacher_name'];}else{echo "Not Assign";} ?>" disabled="disabled">
	            </div>
	            <div class="d-flex w-100">
	                <label class="col-4" for="description">Description</label>
	                <textarea name="description" id="description"  class="w-100" rows="10" disabled="disabled"><?php if(isset($result)){echo $result['description'];} ?></textarea>
	            </div>
	            <div class="d-flex w-100">
	                <label class="col-4">Number of Students</label>
	                <input type="text" value="<?php echo $result['student_count']; ?>" disabled="disabled">
	            </div>
	            <div class="w-100 p-1"></div>
	        </fieldset>
	    </form>
		
	</div>

	<div class="col-12 mt-5 d-flex flex-col align-items-center">
		<h2 class="mb-5">Links</h2>
		<hr class="topic-hr w-75">
		<div class="col-8 d-flex flex-col">
			<?php if($_SESSION['role'] == 'admin'){
				echo '<a href="'.set_url("classroom/student/list/".$result['id']).'" class="profile-links">
					<p>Classroom Students</p>
				</a>';
				echo '<a href="'.set_url("classroom/timetable/".$result['id']).'" class="profile-links">
					<p>Classroom Timetable</p>
				</a>';
				echo '<a href="'.set_url("classroom/subjects/".$result['id']).'" class="profile-links">
					<p>Classroom Subjects</p>
				</a>';

			// }else if($_SESSION['role'] == "teacher" || ($_SESSION['role']=="student" && $_SESSION['classroom_id'] == $result['id'])){
			}else if($_SESSION['role'] == "teacher" || ($_SESSION['role']=="student" && $_SESSION['classroom_id'] == $result['id'])){
				echo '<a href="'.set_url("classroom/student/list").'" class="profile-links">
					<p>Classroom Students</p>
				</a>';
				echo '<a href="'.set_url("classroom/timetable/view/".$result['id']).'" class="profile-links">
					<p>Classroom Timetable</p>
				</a>';				
			}else if($_SESSION['role'] == "parent"){
				echo '<a href="'.set_url("classroom/student/list/".$result['id']).'" class="profile-links">
					<p>Classroom Students</p>
				</a>';
				echo '<a href="'.set_url("classroom/timetable/view/".$result['id']).'" class="profile-links">
					<p>Classroom Timetable</p>
				</a>';				
			} ?>
		</div>
	</div>

</div>