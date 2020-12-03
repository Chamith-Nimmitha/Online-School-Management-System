<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<div class="col-12 flex-col">
        <div class="d-flex justify-content-center align-items-center">
            <form action="<?php echo set_url('pages/student_list.php'); ?>" method="get" class="d-flex align-items-center col-12">
                <div class="d-flex col-12 align-items-center justify-content-center">
                    <div class="mt-5">
                        <input type="reset" class="btn btn-blue" onclick="reset_form(this)" value="reset">
                    </div>
                    <div class="ml-5">
                        <label for="teacher-id">Teacher ID</label>
                        <input type="text" name="teacher-id" id="teacher-id" placeholder="Teacher ID" value="<?php if(isset($_GET['teacher-id'])){echo $_GET['teacher-id'];} ?>">
                    </div>
                    <div class="ml-5 d-flex flex-col">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" placeholder="Student ID" value="<?php if(isset($_GET['date'])){echo $_GET['date'];} ?>">
                    </div>
                    <input type="submit" class="btn btn-blue ml-3 mt-5" value="Show">
                </div>
            </form>
        </div>

        <form action="" method="POST" class="col-12">
            <div class="col-12 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
    		    <table class="table-strip-dark">
    			    <caption class="p-5"><b>Teachers Attendance</b></caption>
    			    <thead>
    				    <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>ATTENDANCE</th>
                            <th>VIEW ATTENDANCE</th>
    				    </tr>
    			    </thead>  
                    <tbody>
                        <?php if($result_set && !empty($result_set)){
                            for($i=0; $i< count($result_set); $i++) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $i+1; ?></td>
                                    <td><?php echo $result_set[$i]['id'] ?></td>
                                    <td><?php echo $result_set[$i]['name_with_initials'] ?></td>
                                    <td class="text-center">
                                        <label for="present0">
                                            <input type="radio" id="present0" name="attendance_status[0]" value="Present"> Present
                                        </label>
                                        <label for="absent0">
                                            <input type="radio" id="absent0" name="attendance_status[0]" value="Absent"> Absent
                                        </label>
                                    </td>
                                    <td class="text-center">
                						<div>
                							<a class="btn btn-blue" href="<?php echo set_url('attendance/teacher/view/'.$result_set[$i]['id']); ?>" >VIEW REPORT</a>
                		    			 </div>
                					</td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
                <div class="w-100 p-1"></div>

    		</div>  
                <div class="form-group d-flex flex-row w-90 justify-content-end">
    		        <button type="submit" name="submit" class="btn btn-blue w-auto m-1">MARK ATTENDANCE</button>
                </div>
        </form>
    </div>
</div>