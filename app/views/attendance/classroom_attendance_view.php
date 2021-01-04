<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
    <div id="attendance_notification" class="d-none w-75">
        <p style="background: #eee;" class="w-100 p-2 text-center fg-red"> </p>
    </div>
    <div class="d-flex justify-content-center align-items-center">
        <form id="attendance_filter" class="d-flex align-items-center col-12">
            <div class="d-flex col-12 align-items-center justify-content-center">
                <input type="hidden" name="classroom_id" class="btn btn-blue" value="<?php echo $classroom_data['id']; ?>">
                <div class="mt-5">
                    <input type="reset" class="btn btn-blue" onclick="reset_form('attendance_filter')" value="reset">
                </div>
                <div class="ml-5">
                    <label for="studebt-id">Student ID</label>
                    <input type="text" name="student-id" id="student-id" placeholder="Student ID" value="<?php if(isset($_GET['student-id'])){echo $_GET['student-id'];} ?>" oninput="classroom_attendance_search()">
                </div>
                <div class="ml-5 d-flex flex-col">
                    <label for="date">Date</label>
                    <input type="date" name="date" id="date" placeholder="Student ID" value="<?php if(isset($_GET['date'])){echo $_GET['date'];} ?>">
                </div>
                <button  class="btn btn-blue ml-3 mt-5" name="filter" onclick="classroom_attendance_search()" value="Show">Filter</button>
            </div>
        </form>
    </div>
    <form  id="mark_attendance" class="col-12 d-flex justify-content-center">
        <div class="col-10 flex-col" style="overflow-x: scroll;overflow-y: hidden;">  
            <input type="hidden" name="classroom_id_hidden" class="btn btn-blue" value="<?php echo $classroom_data['id']; ?>">
            <input type="hidden" name="date_hidden" id="date_hidden" value="<?php if(isset($date)){echo $date;}else{echo date("Y-m-d");} ?>">
            <table class="table-strip-dark">
                <caption class="p-5"><b>Attendance Sheet <br><span id="attendance_date"><?php if(isset($date)){echo $date;}else{echo date("Y-m-d");} ?></span> <br>Class <?php echo $classroom_data['grade']."-".$classroom_data['class']; ?></b></caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Date</th>
                            <th>Attendance</th>
                            <th>Note</th>
                            <th>View Attendance</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php 
                            if(isset($student_list) && !empty($student_list)){
                                foreach ($student_list as $student) {
                         ?>
                         <tr>
                            <td><?php echo $student['id']; ?></td>
                            <td><?php echo $student['name_with_initials']; ?></td>
                            <td><?php if(isset($student['date'])){echo $student['date'];}else{echo date("Y-m-d");}; ?></td>
                            <td class="d-flex flex-col">
                                <label for="present-<?php echo $student['id']; ?>">
                                    <input type="radio" id="present-<?php echo $student['id']; ?>" name="attendance-<?php echo $student['id']; ?>" value="1" <?php if(isset($student['attendance']) && $student['attendance'] === 1){echo "checked='checked'";} ?> > Present
                                </label>
                                <label for="absent-<?php echo $student['id']; ?>">
                                    <input type="radio" id="absent-<?php echo $student['id']; ?>" name="attendance-<?php echo $student['id']; ?>" value="0" <?php if(isset($student['attendance']) && $student['attendance'] === 0){echo "checked='checked'";} ?> > Absent
                                </label>
                            </td>
                            <td><input type="text" name="note-<?php echo $student['id']; ?>" value="<?php if(isset($student['note'])) {echo $student['note'];} ?>"></td>
                            <td> <a href="<?php echo set_url("student/attendance/".$student['id']) ?>" class="btn btn-blue">View Report</a></td>

                         </tr>
                            
                        <?php 
                                }
                            }else{
                                echo "<tr><td colspan=8 class='text-center bg-red'>Student not found...</td></tr>";
                            }
                         ?>                                    
                    </tbody>
            </table>
        </div>
        <div class="d-flex flex-row w-75 justify-content-end">
            <button type="submit" name="submit" onclick="mark_classroom_attendance()" class="btn btn-blue m-1">Mark Attendance</button>
        </div>
    </form>
</div>