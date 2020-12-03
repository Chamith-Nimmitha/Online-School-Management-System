<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
    <div>
        <h2 class="fs-30">ADD CLASSROOMS</h2>
    </div>	
    <hr class="w-100">

    <form  method="post" action="<?php if(isset($result)){echo set_url('classroom/update/'.$result['id']);}else{echo set_url('classroom/registration');} ?>" class="col-6">
        <div class="form-group mt-1">
            <label>SECTION</label>
            <select name="section" id="section" required="required">
                <option value="">select</option>
                <option value="primary" <?php if(isset($result) && $result['category'] == "primary"){echo "selected='selected'";} ?>>Primary</option>
                <option value="secondary" <?php if(isset($result) && $result['category'] == "secondary"){echo "selected='selected'";} ?>>Secondary</option>
            </select> 
        </div>

         <div class="form-group mt-1">
            <label>Grade</label>
            <select name="grade" id="grade" required="required">
                <option value="">select</option>
                <?php foreach ($sections as $section) { ?>
                    <option value="<?php echo $section['grade']; ?>" <?php if(isset($result) && $result['grade'] === $section['grade']){echo "selected='selected'";} ?>><?php echo $section['grade']; ?></option>
                <?php } ?>
            </select> 
        </div>
            
        <div class="form-group mt-1">
            <label>CLASS</label>
            <input type="text" name="class" value="<?php if(isset($result)){echo $result['class'];} ?>" required="required">
        </div>


        <div class="form-group mt-1">
            <label>CLASS TEACHER</label>
            <select name="class_teacher" id="class_teacher">
                <option value="">select</option>
                <?php foreach ($teachers as $teacher) { ?>
                    <option value="<?php echo $teacher['id']; ?>" <?php if(isset($result) && $result['class_teacher_id'] === $teacher['id']){echo "selected='selected'";} ?>><?php echo $teacher['name_with_initials']; ?></option>
                <?php } ?>
            </select> 
        </div>
        <div class="form-group w-90">
            <label for="description">Description</label>
            <textarea name="description" id="description" value="<?php if(isset($result)){echo $result['description'];} ?>" class="w-100" rows="10"></textarea>
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
    </form>
</div>  
