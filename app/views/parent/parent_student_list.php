
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
    <div class="mt-5  w-75 d-flex flex-col align-items-center">
        <h2 class="pt-3 pb-3">Clildrent List</h2>
        <hr class="topic-hr w-100">
    </div>
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
                    <?php if($_SESSION['role']=="admin" || $_SESSION['role']=="teacher"){ ?>
                        <th>Attendance</th>
                        <th>Exam Results</th>
                    <?php } ?>
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
                				<a href="<?php echo set_url('classroom/view/'.$student['classroom_id']); ?>" class="btn btn-blue p-1">Info</a>
                			</td>
                			<td class="text-center">
                				<a href="<?php echo set_url('student/timetable/view/'.$student
                                ['id']); ?>" class="btn btn-blue p-1">view</a>
                			</td>

                            <?php if($_SESSION['role']=="admin" || $_SESSION['role']=="teacher"){ ?>
                			<td class="text-center">
                				<a href="<?php echo set_url('student/attendance/'.$student
                                ['id']) ?>" class="btn btn-blue p-1">Report</a>
                			</td>
                            <td class="text-center">
                                <a href="<?php echo set_url('student/marks/report/'.$student['id']); ?>" class="btn btn-blue p-1">Report</a>
                            </td>
                            <?php } ?>
                		</tr>	
                <?php 
            		}
                } ?>
            </tbody>
        </table>
        <div class="w-100 p-1"></div>
	</div>
</div>