<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

    <?php 

        if(isset($info) && !empty($info)){
            echo "<p class='w-75 bg-green p-2 text-center'>";
            echo $info;
            echo "</p>";
        }
        if(isset($error) && !empty($error)){
            echo "<p class='w-75 bg-red p-2 text-center'>";
            echo $error;
            echo "</p>";
        }
     ?>

    <div class="mt-5  w-75 d-flex flex-col align-items-center">
        <?php if(isset($result) && !empty($result)){ ?>
            <h2 class="pt-3 pb-3">Classroom Update Form</h2>
        <?php }else{ ?>
            <h2 class="pt-3 pb-3">Classroom Registration Form</h2>
        <?php } ?>
        <hr class="topic-hr w-100">
    </div>

    <form  method="post" action="<?php if(isset($result)){echo set_url('classroom/update/'.$result['id']);}else{echo set_url('classroom/registration');} ?>" class="col-6">
        <fieldset class="p-4">
            <div class="form-group mt-1">
                <label>Section</label>
                <select name="section" id="section" required="required" onchange="get_classroom_grades(this,'grade')"  <?php if(isset($result) && !empty($result)){echo "disabled='disabled'"; }?>>
                    <option value="">select</option>
                    <?php 
                        if(isset($categories) && !empty($categories)){
                            foreach ($categories as $category) {
                     ?>
                     <option value="<?php echo $category['category'] ?>" <?php if(isset($result) && $result['category'] == $category['category']){echo "selected='selected'";} ?>><?php echo $category['category']; ?></option>
                    <?php 
                        }
                    } ?>
                </select> 
            </div>

            <div class="form-group mt-1">
                <label>Grade</label>
                <select name="grade" id="grade" required="required" <?php if(isset($result) && !empty($result)){echo "disabled='disabled'"; }?>>
                    <option value="">select</option>
                    <?php 
                    if(isset($sections) && !empty($sections)){
                        foreach ($sections as $section) { ?>
                            <option value="<?php echo $section['id']; ?>" <?php if(isset($result) && $result['section_id'] === $section['id']){echo "selected='selected'";} ?>><?php echo $section['grade']; ?></option>
                    <?php } }?>
                </select> 
            </div>
                
            <div class="form-group mt-1">
                <label>Class</label>
                <input type="text" name="class" value="<?php if(isset($result)){echo $result['class'];} ?>" required="required" <?php if(isset($result) && !empty($result)){echo "disabled='disabled'"; }?>>
            </div>


            <div class="form-group mt-1">
                <label>Class Teacher</label>
                <select name="class_teacher" id="class_teacher">
                    <option value="">select</option>
                    <?php foreach ($teachers as $teacher) { ?>
                        <option value="<?php echo $teacher['id']; ?>" <?php if(isset($result) && $result['class_teacher_id'] === $teacher['id']){echo "selected='selected'";} ?>><?php echo $teacher['name_with_initials']; ?></option>
                    <?php } ?>
                </select> 
            </div>
            <div class="form-group w-90">
                <label for="description">Description</label>
                <textarea name="description" id="description"  class="w-100" rows="10"><?php if(isset($result)){echo $result['description'];} ?></textarea>
            </div>

            <div class="w-100 p-1"></div>

            <?php 
                if(isset($result)){
                    echo '<div class="form-group d-flex w-100 flex-row justify-content-end">
                            <button type="submit" name="update" class="btn btn-blue w-auto m-1">Update</button>
                            </div>';
                }else{
                    echo '<div class="form-group d-flex w-100 flex-row justify-content-end">
                            <button type="submit" name="submit" class="btn btn-blue w-auto m-1">SAVE</button>
                            </div>';
                }
             ?>
        </fieldset>
    </form>

    <form  id="upload_classrooms" class="col-12 d-flex justify-content-center" method="POST" enctype="multipart/form-data" action="<?php echo set_url("classroom/registration");?>">
    <?php 
        if($_SESSION['role']=='admin'){
            echo '<div class="d-flex flex-row w-75 justify-content-center align-items-center">';
            echo '<label></b>Upload Classroomss&nbsp&nbsp&nbsp</b></label>';
            echo '<input type="file" name="file" id="file">';
            echo '<input type="submit" name="upload" id="upload" onclick="//mark_classroom_attendance()" class="btn btn-blue m-1">';
            echo '</div>';
        }
    ?>
    </form>
</div>  
