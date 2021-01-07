
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
                				<a href="<?php echo set_url('classroom/student/list/'.$student['classroom_id']); ?>" class="btn btn-blue p-1">Info</a>
                			</td>
                			<td class="text-center">
                				<a href="<?php echo set_url('student/timetable/view/'.$student
                                ['id']); ?>" class="btn btn-blue p-1">view</a>
                			</td>
                			<td class="text-center">
                				<a href="<?php echo set_url('student/attendance/'.$student
                                ['id']) ?>" class="btn btn-blue p-1">Report</a>
                			</td>
                			<td class="text-center">
                				<a href="<?php echo set_url('student/exam/'.$student['id']); ?>" class="btn btn-blue p-1">Report</a>
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