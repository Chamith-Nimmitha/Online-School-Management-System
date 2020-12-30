<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<div class="col-12 flex-col justify-content-center align-items-center">
        <div id="attendance-statistics" class="col-12  justify-content-center ">
    		<h2 class="text-center p-5">Attendance Statistics</h2>
    		<div class="statistics-flex justify-content-center">	
    			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
    				<h3 class="bb pb-1 text-center">Total Days</h3>
    				<span class="pt-1">100</span>
    			</div> 
    			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
    				<h3 class="bb pb-1 text-center">Absent Days</h3>
    				<span class="pt-1">10</span>
    			</div> 
    			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
    				<h3 class="bb pb-1  text-center">Present Days</h3>
    				<span class="pt-1">90</span>
    			</div> 
    			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
    				<h3 class="bb pb-1  text-center">Presentage</h3>
    				<span class="pt-1">90%</span>
    			</div>
    			
    			
    		</div>
    	</div>
        <div class="col-12 justify-content-center align-items-center">
            <div class="d-flex justify-content-center align-items-center">
                <form id="student_attendance_filter" method="post" class="d-flex align-items-center col-12">
                    <input type="hidden" name="student_id" value="<?php if(isset($student_id)){echo $student_id;} ?>">
                    <div class="d-flex col-12 align-items-center justify-content-center">
                        <div class="mt-5">
                            <input type="reset" class="btn btn-blue" onclick="reset_form('student_attendance_filter')" value="reset">
                        </div>
                        <div class="ml-5 d-flex flex-col">
                            <label for="year">Year</label>
                            <select name="year">
                                <option value="this">This</option>
                                <option value="2020">2020</option>
                                <option value="2019">2019</option>
                            </select>
                        </div>
                        <div class="ml-5 d-flex flex-col">
                            <label for="month">Month</label>
                            <select name="month">
                                <option value="this">This</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">Semtember</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="ml-5 d-flex flex-col">
                            <label for="week">Week</label>
                            <select name="week">
                                <option value="this">This</option>
                                <option value="1">Week-01</option>
                                <option value="2">Week-02</option>
                                <option value="3">Week-03</option>
                                <option value="4">Week-04</option>
                                <option value="4">Week-05</option>
                            </select>
                        </div>
                        <button type="button" onclick="student_attendance_filter()" class="btn btn-blue ml-3 mt-5">Filter</button>

                        <a href="<?php echo set_url('student/attendance/report') ?>" class="btn btn-green-outline ml-2 mt-5 p-1" value="Show">View This year attendance</a>
                    </div>
                </form>
            </div>
            <div class="col-8 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
    		    <table class="table-strip-dark text-center">
    			    <caption class="p-5"><b>Recent 10 Attendance</b></caption>
    			    <thead>
    				    <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>ATTENDANCE</th>
    				    </tr>
    			    </thead>  
                    <tbody id="tbody">
                        <?php 
                            if(isset($result_set) && !empty($result_set)){
                                for ($i=0; $i < count($result_set); $i++) { 
                         ?>
                            <tr>
                                <td><?php echo $i+1; ?></td>
                                <td><?php echo $result_set[$i]['date']; ?></td>
                                <td class="d-flex flex-col align-items-center">
                                    <label>
                                        <input type="radio" value="1" <?php if(isset($result_set[$i]['attendance']) && $result_set[$i]['attendance'] === 1){echo "checked='checked'";} ?> > Present
                                    </label>
                                    <label>
                                        <input type="radio" value="0" <?php if(isset($result_set[$i]['attendance']) && $result_set[$i]['attendance'] === 0){echo "checked='checked'";} ?> > Absent
                                    </label>
                                </td>
                            </tr>    
                        <?php 
                                }
                            }
                         ?>
                    </tbody>
                </table>
                <div class="w-100 p-1"></div>
    		</div>
        </div>

        <!-- student attendance overview-->

        <div class="col-10 mt-5">
            <div class="col-12 mt-5 justify-content-center">
                <h3>Student Attendance Overview</h3>
            </div>
            <form id="student_attendance_overview" class="col-12">
                <input type="hidden" name="student_id_bar" value="<?php if(isset($student_id)){echo $student_id;} ?>">
                <div class="col-12 justify-content-center align-items-center mt-5">
                    <input type="reset" class="btn btn-blue mr-2 mt-5 p-2" onclick="reset_form('student_attendance_overview')" value="reset">
                    <div class="d-flex flex-col align-items-center pr-5" style="width: 150px;">
                        <label class="pr-2" for="year_bar">Year: </label>
                        <select name="year_bar" id="year_bar">
                            <option value="this">This</option>
                            <option value="2020">2020</option>
                            <option value="2019">2019</option>
                        </select>
                    </div>
                    <div class="d-flex flex-col align-items-center" style="width: 150px;">
                        <label class="pr-2" for="month_bar">Month: </label>
                        <select name="month_bar" id="month_bar">
                            <option value="0">None</option>
                            <option value="this">This</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">Semtember</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <button type="button" onclick="student_attendance_overview_bar()" class="btn btn-blue ml-2 mt-5 p-2">Filter</button>
                </div>
            </form>            
        </div>
        <div class="mt-5 col-12 d-flex justify-content-center align-items-center">
            <div class="bg-white p-5">
                <canvas id="student_attendance_overview_bar" width="800" height="500"></canvas>
            </div>
        </div>

        <div class="form-group d-flex flex-row w-90 justify-content-end">
	        <button type="button" name="submit" onclick="window.print()" class="btn btn-blue w-auto m-1">Download as pdf</button>
        </div>

    </div>