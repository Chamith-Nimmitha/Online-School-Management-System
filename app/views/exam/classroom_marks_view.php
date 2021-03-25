<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
    <div class="mt-5  w-75 d-flex flex-col align-items-center">
        <h2 class="pt-3 pb-3">Classroom Marks View</h2>
        <hr class="topic-hr w-100">
    </div>
    <div id="marks_notification" class="d-none w-75">
        <p style="background: #eee;" class="w-100 p-2 text-center fg-red"> </p>
    </div>
    <div class="d-flex justify-content-center align-items-center">
        <form id="marks_filter" class="d-flex align-items-center col-12" method="POST" action="<?php echo set_url("marks/classroom/result/view/$student_id/$t");?>">
            <div class="d-flex col-12 align-items-center justify-content-center">
                
                <div class="mt-5">
                    <input type="reset" class="btn btn-blue" onclick="//reset_form('attendance_filter')" value="reset">
                </div>

                <div class="ml-5">
                    <label for="term">Term</label>
                    <select name="term" id="term">
                        <option value="0">Select Term</option>
                        <option value="1">1st Term</option>
                        <option value="2">2nd Term</option>
                        <option value="3">3rd Term</option>
                    </select>
                </div>

                <button  class="btn btn-blue ml-3 mt-5" name="filter" onclick="//classroom_attendance_search()" value="Show">Filter</button>

            </div>
        </form>
    </div>
    <form  id="mark_view" class="col-12 d-flex justify-content-center" method="POST" action="<?php echo set_url("marks/classroom/result/view/$student_id/$t");?>">
        <div class="col-10 flex-col" style="overflow-x: scroll;overflow-y: hidden;">  
            <input type="hidden" name="classroom_id_hidden" class="btn btn-blue" value="<?php echo $classroom_data['id']; ?>">
            <input type="hidden" name="date_hidden" id="date_hidden" value="<?php if(isset($date)){echo $date;}else{echo date("Y-m-d");} ?>">
            <table class="table-strip-dark">
                <caption class="p-5"><b>Student Marks-<?php echo $grade.$class;
                echo "<br>";echo 'Term-'.$t; ?></b></caption>
                    <thead>
                        <tr>
                            <th width='20%'>Student ID</th>
                            <th width='20%'>Student Name</th>
                            <th width='20%'>Average</th>
                            <th width='20%'>Rank</th>
                        </tr>
                    </thead>
                    <tbody id="tbody" class="p-1">
                        <?php 
                            if(isset($student_list) && !empty($student_list)){
                                foreach ($student_list as $student) {
                         ?>
                         <tr>
                            <td <?php if($student['id']==$student_id){echo 'style="background-color:#00FF00"';} ?>><?php echo $student['id']; ?></td>
                            <td <?php if($student['id']==$student_id){echo 'style="background-color:#00FF00"';} ?>><?php echo $student['name_with_initials']; ?></td>
                            <td <?php if($student['id']==$student_id){echo 'style="background-color:#00FF00"';} ?>><?php if(isset($marks_average[$student['id'].'-'.$t])){echo $marks_average[$student['id'].'-'.$t];} ?></td>
                            <td <?php if($student['id']==$student_id){echo 'style="background-color:#00FF00"';} ?>><?php if(isset($student_rank[$student['id'].$t.'-term'])){echo $student_rank[$student['id'].$t.'-term'];} ?></td>
                        </tr> 
                        <?php 
                                }
                            }else{
                                echo "<tr><td colspan=10 class='text-center bg-red'>Student not found...</td></tr>";
                            }
                         ?>              
                    </tbody>
            </table>
                    <div class=" d-flex justify-content-center align-items-center">
                         <a class="btn btn-blue" href="<?php echo set_url('student/marks/report/'.$student_id); ?>">View My Report</a>
                    </div>
        </div>

    </form>
</div>