
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
    <?php 
        if(isset($info) && !empty($info)){
            echo "<p class='w-75 bg-green p-2 text-center'>";
            echo $info;
            echo "</p>";
        }
        if(isset($errors) && !empty($errors)){
            echo "<p class='w-75 bg-red p-2 text-center'>";
            foreach ($errors as $err) {
                echo $err."<br/>";
            }
            echo "</p>";

        }
        if(isset($error) && !empty($error)){
            echo "<p class='w-75 bg-red p-2 text-center'>";
            echo $error;
            echo "</p>";
        }
     ?>
    <h2 class="fs-30 mt-5 mb-5">ADD SUBJECTS</h2>		
    <hr class="w-100">

    <form  method="post" action="<?php set_url("subject/registration") ?>">

        <div class="ml-5 align-items-center">
            <label for="medium" class="mr-3 d-normal">Medium:</label>
            <select name="medium" id="medium">
                <option value="" <?php if(!isset($medium)){echo 'selected="selected"';} ?> >Select</option>
                <option value="sinhala" <?php if(isset($medium) && ($medium == "sinhala")){echo 'selected="selected"';} ?> >Sinhala</option>
                <option value="english" <?php if(isset($medium) && ($medium == "english")){echo 'selected="selected"';} ?> >English</option>
                <option value="tamil" <?php if(isset($medium) && ($medium == "tamil")){echo 'selected="selected"';} ?> >Tamil</option>
            </select>               
        </div>

        <div  class="ml-5 align-items-center">
            <label for="grade" class="mr-3 d-normal">Grade : </label>
            <select name="grade" id="grade" style="width: 100px">
                <option value="" <?php if(!isset($grade)){echo 'selected="selected"';} ?>>Select</option>
                <option value="1" <?php if(isset($grade) && ($grade == "1")){echo 'selected="selected"';} ?> >1</option>
                <option value="2" <?php if(isset($grade) && ($grade == "2")){echo 'selected="selected"';} ?> >2</option>
                <option value="3" <?php if(isset($grade) && ($grade == "3")){echo 'selected="selected"';} ?> >3</option>
                <option value="4" <?php if(isset($grade) && ($grade == "4")){echo 'selected="selected"';} ?> >4</option>
                <option value="5" <?php if(isset($grade) && ($grade == "5")){echo 'selected="selected"';} ?> >5</option>
                <option value="6" <?php if(isset($grade) && ($grade == "6")){echo 'selected="selected"';} ?> >6</option>
                <option value="7" <?php if(isset($grade) && ($grade == "7")){echo 'selected="selected"';} ?> >7</option>
                <option value="8" <?php if(isset($grade) && ($grade == "8")){echo 'selected="selected"';} ?> >8</option>
                <option value="9" <?php if(isset($grade) && ($grade == "9")){echo 'selected="selected"';} ?> >9</option>
                <option value="10" <?php if(isset($grade) && ($grade == "10")){echo 'selected="selected"';} ?> >10</option>
                <option value="11" <?php if(isset($grade) && ($grade == "11")){echo 'selected="selected"';} ?> >11</option>
                <option value="12" <?php if(isset($grade) && ($grade == "12")){echo 'selected="selected"';} ?> >12</option>
                <option value="13" <?php if(isset($grade) && ($grade == "13")){echo 'selected="selected"';} ?> >13</option>
            </select>
        </div>
        <div>
            <label for="name">SUBJECT NAME</label>
            <input type="text" id="name" name="name" oninput="create_subject_code(this)"  value="<?php if(isset($name)){echo $name;} ?>" required>
        </div>

        <div>
            <label>SUBJECT CODE</label>
            <input type="text" id="dis_code" value="<?php if(isset($code)){echo $code;} ?>" disabled="disabled">
        </div>
            <input type="hidden" id="code" name="code"  value="<?php if(isset($code)){echo $code;} ?>">
        <div  class="form-group mt-1">
            <label for="description">SUBJECT DESCRIPTION</label>
            <textarea  class="col-12 p-3" name="description" id="description" placeholder="-----ENTER DESCRIPTION HERE.....-----" required="required"><?php if(isset($description)){echo $description;} ?></textarea>
        </div>

        <div class="w-100 p-1"></div>

        <div class="form-group d-flex flex-row w-auto float-right">
        <?php 
            if(isset($oparation) && $oparation === "update"){
                echo '<button type="submit" name="update" class="btn btn-blue">Update</button>';
            }else{
                echo '<button type="submit" name="submit" class="btn btn-blue">Register</button>';
            }
         ?>
        </div>
    </form>
 </div>
 