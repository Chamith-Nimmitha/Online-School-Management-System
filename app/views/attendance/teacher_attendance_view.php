<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<div class="col-12 flex-col justify-content-center align-items-center">
        <!-- <div id="attendance-statistics" class="col-12  justify-content-center ">
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
    	</div> -->

        <div  class="d-flex justify-content-center align-items-center">
            <form id="teacher_attendance_filter" class="d-flex align-items-center col-12">
                <div class="d-flex col-12 align-items-center justify-content-center">
                    <input type="hidden" name="teacher_id" value="<?php if(isset($teacher_id)){echo $teacher_id;} ?>">
                    <div class="mt-5">
                        <input type="reset" class="btn btn-blue" value="reset">
                    </div>
                    <div class="ml-5 d-flex flex-col">
                            <label for="year">Year</label>
                            <select name="year">
                                <option value="this">This Year</option>
                                <option value="2020">2020</option>
                                <option value="2019">2019</option>
                            </select>
                        </div>
                        <div class="ml-5 d-flex flex-col">
                            <label for="month">Month</label>
                            <select name="month">
                                <option value="this">This Month</option>
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
                                <option value="this">This Week</option>
                                <option value="1">Week-01</option>
                                <option value="2">Week-02</option>
                                <option value="3">Week-03</option>
                                <option value="4">Week-04</option>
                                <option value="5">Week-05</option>
                                <option value="6">Week-06</option>
                            </select>
                        </div>
                    <button type="button" onclick="teacher_attendance_filter()" class="btn btn-blue ml-3 mt-5">Filter</button>
                </div>
            </form>
        </div>
        <div class="col-8 flex-col" style="position: relative; overflow-x: scroll;overflow-y: hidden;" id="attendance_table">
            <div class="loader hide-loader">
                <div class="col-12">
                    <div id="one"><div></div></div>
                    <div id="two"><div></div></div>
                    <div id="three"><div></div></div>
                    <div id="four"><div></div></div>
                    <div id="five"></div>
                </div>
            </div>
		    <table class="table-strip-dark text-center">
			    <caption class="p-5"><b>Recent 10 Attendance</b></caption>
			    <thead>
				    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>ATTENDANCE</th>
                        <th>NOTE</th>
				    </tr>
			    </thead>  
                <tbody id="tbody">
                    <?php 
                        if(isset($result_set) && !empty($result_set)){
                            for($i=0; $i<count($result_set); $i++){
                     ?>
                     <tr>
                         <td><?php echo $i+1; ?></td>
                         <td><?php echo $result_set[$i]['date']; ?></td>
                         <td><?php if($result_set[$i]['attendance'] == 1){echo 'Present';}else{echo "Absent";} ?></td>
                         <td><?php echo $result_set[$i]['note']; ?></td>
                     </tr>
                     <?php 
                        }
                    } ?>
                </tbody>
            </table>
            <div class="w-100 p-1"></div>
		</div>

        <!-- teacher attendance overview-->
        <div class="col-10 mt-5">
            <div class="col-12 mt-5 justify-content-center">
                <h3>Teacher Attendance Overview</h3>
            </div>
            <form id="teacher_attendance_overview" class="col-12">
                <input type="hidden" name="teacher_id_bar" value="<?php if(isset($teacher_id)){echo $teacher_id;} ?>">
                <div class="col-12 justify-content-center align-items-center mt-5">
                    <input type="reset" class="btn btn-blue mr-2 mt-5 p-2" value="reset">
                    <div class="d-flex flex-col align-items-center pr-5" style="width: 150px;">
                        <label class="pr-2" for="year_bar">Year: </label>
                        <select name="year_bar" id="year_bar">
                            <option value="this">This Year</option>
                            <option value="2020">2020</option>
                            <option value="2019">2019</option>
                        </select>
                    </div>
                    <div class="d-flex flex-col align-items-center" style="width: 150px;">
                        <label class="pr-2" for="month_bar">Month: </label>
                        <select name="month_bar" id="month_bar">
                            <option value="0">None</option>
                            <option value="this">This Month</option>
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
                    <button type="button" onclick="teacher_attendance_overview_bar()" class="btn btn-blue ml-2 mt-5 p-2">Filter</button>
                </div>
            </form>            
        </div>
        <div class="mt-5 col-12 d-flex justify-content-center align-items-center">
            <div class="bg-white p-5" id="attendance_bar" style="position: relative;">
                <div class="loader hide-loader">
                    <div class="col-12">
                        <div id="one"><div></div></div>
                        <div id="two"><div></div></div>
                        <div id="three"><div></div></div>
                        <div id="four"><div></div></div>
                        <div id="five"></div>
                    </div>
                </div>
                <canvas id="teacher_attendance_overview_bar" width="800" height="500"></canvas>
            </div>
        </div>

        <div class="form-group d-flex flex-row w-90 justify-content-end">
            <div>
                <a class="btn btn-blue" onClick="window.print()">Download as a PDF</a>
	        </div>
        </div>
    </div>
</div>