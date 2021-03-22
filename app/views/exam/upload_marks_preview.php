<script >
function showDiv() {
   document.getElementById('report').style.display = "";
}
</script>
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
    <div id="marks_notification" class="d-none w-75">
        <p style="background: #eee;" class="w-100 p-2 text-center fg-red"> </p>
    </div>
    <div class="mt-5  w-75 d-flex flex-col align-items-center">
        <h2 class="pt-3 pb-3">Exam Results Upload Preview</h2>
        <hr class="topic-hr w-100">
    </div>
    <form  id="upload_marks" class="col-12 d-flex justify-content-center" method="POST" action="<?php echo set_url("marks/upload");?>">
        <div class="align-items-center justify-content-center bg-green">
            <h2>Preview for the Marksheet</h2>
        </div>
        <div class="col-10 flex-col" style="overflow-x: scroll;overflow-y: hidden;"> 
            <table class="table-strip-dark">
                <caption class="p-5"><b>Student Marks<br><?php if(isset($classroom_data['grade'])){echo 'Grade-'.$classroom_data['grade'].$classroom_data['class']; }?><br><?php if(isset($y)){echo 'Year-'.$y; }?><br><?php if(isset($t)){echo 'Term-'.$t; }?><br></b></caption>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            	<?php 
                            		foreach ($subject_list as $subject) {
                            	?>
                            				<th width='6%'><?php echo substr($subject['name'],0,3);?></th>
                            	<?php
                            		}
                            	?>

                        </tr>
                    </thead>
                    <tbody id="tbody" class="p-1">
                        <?php 
                            if(isset($student_list) && !empty($student_list)){
                                foreach ($student_list as $student) {
                         ?>
                         <tr>
                            <td><?php echo $student['id']; ?></td>
                            <td><?php echo $student['name_with_initials']; ?></td>
                            	<?php 
                            		foreach ($subject_list as $subject) {
                            	?>
                            		<td><input type="text" name="<?php echo $student['id'].'-'.$subject['id']; ?>" id="<?php echo $student['id'].'-'.$subject['id']; ?>" placeholder="" value="<?php if(isset($std_marks[$student['id'].'-'.$subject['id']])){echo $std_marks[$student['id'].'-'.$subject['id']];} ?>" maxlength="3" disabled></td>
                            	<?php 
                            	}

		                        ?>
                        </tr> 
                        <?php 
                                }
                            }else{
                                echo "<tr><td colspan=10 class='text-center bg-red'>Student not found...</td></tr>";
                            }
                         ?>                                   
                    </tbody>
            </table>
            <br>
            <div class="align-items-center justify-content-end">

        	</div>	
        </div>
        <div class="d-flex flex-row w-75 justify-content-center align-items-center">
                <label>Do you want to Upload this Marksheet ? &nbsp</label>
            	<input type="submit" name="accept" id="accept" value="Accept" onclick="//mark_classroom_attendance()" class="btn btn-green m-1">
                <input type="submit" name="cancel" id="cancel" value="Cancel" onclick="//mark_classroom_attendance()" class="btn btn-red m-1">
        </div>
    </form>

</div>

