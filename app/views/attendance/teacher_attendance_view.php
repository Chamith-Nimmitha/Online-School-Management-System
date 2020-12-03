<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<div class="col-12 flex-col justify-content-center align-items-center">
        <div id="attendance-statistics" class="col-12  justify-content-center ">
    		<h2 class="text-center p-5">Attendance Statistics</h2>
    		<div class="statistics-flex justify-content-center">	
    			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
    				<h3 class="bb pb-1 text-center">Total Holidays for the year</h3>
    				<span class="pt-1"></span>
    			</div> 
    			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
    				<h3 class="bb pb-1 text-center">Holidays Taken</h3>
    				<span class="pt-1"></span>
    			</div> 
    			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
    				<h3 class="bb pb-1  text-center">Holidays Remaining</h3>
    				<span class="pt-1"></span>
    			</div> 
    			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
    				<h3 class="bb pb-1  text-center">Short Leaves</h3>
    				<span class="pt-1"></span>
    			</div>
    			
    			
    		</div>
    	</div>

        <form action="" method="POST" class="col-12 d-flex flex-col align-items-center">
            <div class="d-flex justify-content-center align-items-center">
                <form action="<?php echo set_url('pages/student_list.php'); ?>" method="get" class="d-flex align-items-center col-12">
                    <div class="d-flex col-12 align-items-center justify-content-center">
                        <div class="mt-5">
                            <input type="reset" class="btn btn-blue" onclick="reset_form(this)" value="reset">
                        </div>
                        <div class="ml-5 d-flex flex-col">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" placeholder="Student ID" value="<?php if(isset($_GET['date'])){echo $_GET['date'];} ?>">
                        </div>
                        <div class="ml-5 d-flex flex-col">
                            <label for="month">Month</label>
                            <select name="month">
                                <option value="None">None</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="Semtember">Semtember</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                        <div class="ml-5 d-flex flex-col">
                            <label for="month">Week</label>
                            <select name="month">
                                <option value="None">None</option>
                                <option value="Week-01">Week-01</option>
                                <option value="Week-02">Week-02</option>
                                <option value="Week-03">Week-03</option>
                                <option value="Week-04">Week-04</option>
                            </select>
                        </div>
                        <input type="submit" class="btn btn-blue ml-3 mt-5" value="Show">
                    </div>
                </form>
            </div>
            <div class="col-8 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
    		    <table class="table-strip-dark">
    			    <caption class="p-5"><b>Recent 10 Attendance</b></caption>
    			    <thead>
    				    <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>ATTENDANCE</th>
    				    </tr>
    			    </thead>  
                    <tbody>
                        <?php for($i=0; $i< 10; $i++) { ?>
                            <tr>
                                <td class="text-center"><?php echo $i+1; ?></td>
                                <td class="text-center"><?php echo "2020/11/".(16-$i);?></td>
                                <td class="text-center">
                                    <label for="present0">
                                        <input type="radio" name="attendance_status[<?php echo $i; ?>]" value="Present" <?php if($i %3 ===0){echo "checked";} ?> disabled="disabled"> Present
                                    </label>
                                    <label for="absent0">
                                        <input type="radio"  name="attendance_status[<?php echo $i; ?>]" value="Absent" <?php if($i % 3 ===2){echo "checked";} ?> disabled="disabled"> Absent
                                    </label>
                                    <label for="present0">
                                        <input type="radio" name="attendance_status[<?php echo $i; ?>]" value="Half" <?php if($i %3 ===1){echo "checked";} ?> disabled="disabled"> Half
                                    </label>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="w-100 p-1"></div>
    		</div>
            <div class="form-group d-flex flex-row w-90 justify-content-end">
    	        <button type="submit" name="submit" class="btn btn-blue w-auto m-1">Download as pdf</button>
            </div>
        </form>
    </div>
</div>