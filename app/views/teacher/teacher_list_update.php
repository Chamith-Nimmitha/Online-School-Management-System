
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
        <?php 
        
        if(isset($error) && !empty($error)){
            echo "<p class='mt-5 w-75 bg-red p-5 text-center'>";
            echo $error;
            echo "</p>";
        }

        if(isset($info) && !empty($info)){
            echo "<p class='mt-5 w-75 bg-green p-5 text-center'>";
            echo $info;
            echo "</p>";
        }

     ?>


<div class="mt-5  w-75 d-flex flex-col align-items-center">
    <h2 class="pt-3 pb-3">Teacher Update</h2>
    <hr class="topic-hr w-100">
</div>

<form method="POST" class="col-10" action="<?php echo set_url('teacher/update/'.$data['id'].''); ?>">
    
    <div class="form-group mt-1">
        <label>NAME</label>
        <input type="text" name="name_with_initials" value="<?php echo $data['name_with_initials'] ?>" oninput="validate_user_input(this,0,50,1)" >
        <?php 
        if(isset($field_errors['name_with_initials'])){
            echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["name_with_initials"].'</p>';
        }else{
            echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
         }
        ?>
    </div>

    <div class="form-group mt-1">
        <label>FIRST NAME</label>
        <input type="text" name="first_name" value="<?php echo $data['first_name'] ?>" oninput="validate_user_input(this,0,20,1)" >
        <?php 
        if(isset($field_errors['first_name'])){
            echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["first_name"].'</p>';
        }else{
            echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
         }
        ?>
    </div>

    <div class="form-group mt-1">
        <label>MIDDLE NAME</label>
        <input type="text" name="middle_name" value="<?php echo $data['middle_name'] ?>" oninput="validate_user_input(this,0,50,0)" >
        <?php 
        if(isset($field_errors['middle_name'])){
            echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["middle_name"].'</p>';
        }else{
            echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
         }
        ?>

    </div>

    <div class="form-group mt-1">
        <label>LAST NAME</label>
        <input type="text" name="last_name" value="<?php echo $data['last_name'] ?>" oninput="validate_user_input(this,0,20,1)"  >
        <?php 
        if(isset($field_errors['last_name'])){
            echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["last_name"].'</p>';
        }else{
            echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
         }
        ?>
    </div>
    
    <div>
        <label>GENDER</label>
            <select name="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        <?php 
        if(isset($field_errors['gender'])){
            echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["gender"].'</p>';
        }else{
            echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
         }
        ?>
    </div>

    <div class="form-group mt-1">
        <label>DATE OF BIRTH</label>
        <input type="date" name="dob"  value="<?php echo $data['dob'] ?>" onchange="validate_birthday(this,20)" >
        <?php 
        if(isset($field_errors['dob'])){
            echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["dob"].'</p>';
        }else{
            echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
         }
        ?>
    </div>

    <div class="form-group mt-1">
        <label>ADDRESS</label>
        <input type="text" name="address"  value="<?php echo $data['address'] ?>" oninput="validate_user_input(this,0,100,1)" >
        <?php 
        if(isset($field_errors['address'])){
            echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["address"].'</p>';
        }else{
            echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
         }
        ?>
    </div>

    <div class="form-group mt-1">
        <label>EMAIL</label>
        <input type="text" name="email"  value="<?php echo $data['email'] ?>" oninput="validate_email(this,0,100,1)" >
        <?php 
        if(isset($field_errors['email'])){
            echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["email"].'</p>';
        }else{
            echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
         }
        ?>
    </div>

    <div class="form-group mt-1">
        <label>CONTACT NUMBER</label>
        <input type="text" name="contact_number"  value="<?php echo $data['contact_number'] ?>" oninput="validate_contact_number(this)" >
        <?php 
        if(isset($field_errors['contact_number'])){
            echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["contact_number"].'</p>';
        }else{
            echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
         }
        ?>
    </div>

    <div class="form-group mt-1">
        <label>NIC</label>
        <input type="text" name="nic"  value="<?php echo $data['nic'] ?>" oninput="validate_user_input(this,10,12,1)" >
        <?php 
        if(isset($field_errors['nic'])){
            echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["nic"].'</p>';
        }else{
            echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
         }
        ?>
    </div>
<!--
    <div class="form-group mt-1">
        <label>IS DELETED</label>
        <input type="number" name="is_deleted"  value="<?php echo $data['is_deleted'] ?>" required>
    </div> 

    <div class="form-group mt-1">
        <label>INTERVIEW PANEL ID</label>
        <input type="number" name="interview_panel_id"  value="<?php echo $data['interview_panel_id'] ?>" required>
    </div> -->    

    <div class="w-100 p-1"></div>

        <div class="form-group d-flex flex-row w-auto float-right">
            <button type="submit" name="update" class="btn btn-blue w-auto m-1">UPDATE</button>
        </div>

    
</form>

</div>

<?php //require_once("../templates/footer.php") ;?>