<?php include_once("session.php"); ?>
<?php require_once("../templates/header.php") ;?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
    <div id="school-statistics" class="col-12  justify-content-center ">
		<h2 class="text-center p-5">Timetables</h2>
		<div class="statistics-flex justify-content-center">	
			<div id="total-subjects" class="d-flex flex-col s-item align-items-center bg-lightgreen m-2 p-3">
				<h3 class="bb pb-1  text-center">Total Number of Teachers' Timetables</h3>
				<span class="pt-1"></span>
			</div> <!-- #total-subjects -->
			
		</div>
	</div> <!-- #school-statistics -->
	<div class="col-12 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
			
		<table class="table-strip-dark">
			
			<thead>
				<tr>
					<th></th>
					<th>Teacher's Index Number</th>
					<th>Teacher's Name</th>
					<th>View the Timetable</th>
					<th>Update the Timetable</th>
					<th>Delete the Timetable</th>
				</tr>
			</thead>
			
		</table>
		</div>
		<br>
		<br>
		<br>
		<div class="login_buttons col-12 col-md-2 justify-content-end pr-5 d-flex align-items-center">
				<a class="btn btn-blue mr-5" href="#">Add a Timetable</a>
				
			</div>
</div>

<?php require_once("../templates/footer.php"); ?>