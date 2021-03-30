
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
        <?php 
        
        if(isset($error) && !empty($error)){
            echo "<p class='mt-5 w-75 bg-red fg-white p-5 text-center'>";
            echo $error;
            echo "</p>";
        }

        if(isset($info) && !empty($info)){
            echo "<p class='mt-5 w-75 bg-green fg-white p-5 text-center'>";
            echo $info;
            echo "</p>";
        }

     ?>
    <div class="mt-5  w-75 d-flex flex-col align-items-center">
        <h2 class="pt-3 pb-3">Teacher Registration Form</h2>
        <hr class="topic-hr w-100">
    </div>

    <form  method="post" action="<?php echo set_url("teacher/registration");?>" class="col-8">
        <fieldset class="p-5">
            <legend>Registration form</legend>
            <div class="form-group mt-1">
                <label>NAME WITH INITIALS (<code title="required"> * </code>)</label>
                <input type="text" name="name_with_initials"  value="<?php if(isset($_POST['name_with_initials'])){echo $_POST['name_with_initials'];} ?>" oninput="validate_user_input(this,0,50,1)" placeholder="Name With initials">
                <?php 
                if(isset($field_errors['name_with_initials'])){
                    echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["name_with_initials"].'</p>';
                }else{
                    echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
                }
                ?>
            </div>

            <div class="form-group mt-1">
                <label>FIRST NAME (<code title="required"> * </code>)</label>
                <input type="text" name="first_name"  placeholder="First Name" value="<?php if(isset($_POST['first_name'])){echo $_POST['first_name'];} ?>" oninput="validate_user_input(this,0,20,1)">
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
                <input type="text" name="middle_name" placeholder="Middle Name" value="<?php if(isset($_POST['middle_name'])){echo $_POST['middle_name'];} ?>" oninput="validate_user_input(this,0,50,0)" >
                <?php 
                if(isset($field_errors['middle_name'])){
                    echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["middle_name"].'</p>';
                }else{
                    echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
                }
                ?>
            </div>

            <div class="form-group mt-1">
                <label>LAST NAME (<code title="required"> * </code>)</label>
                <input type="text" name="last_name"  value="<?php if(isset($_POST['last_name'])){echo $_POST['last_name'];} ?>" placeholder="Last Name" oninput="validate_user_input(this,0,20,1)">
                <?php 
                if(isset($field_errors['last_name'])){
                    echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["last_name"].'</p>';
                }else{
                    echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
                }
                ?>
            </div>

            <div class="form-group">
                <label>GENDER (<code title="required"> * </code>)</label>
                <select name="gender" style="width: 100px;">
                    <option value="male" <?php if(isset($_POST['gender']) && $_POST['gender']== 'male'){echo "selected='selected'";} ?>>MALE</option>
                    <option value="female" <?php if(isset($_POST['gender']) && $_POST['gender']== 'female'){echo "selected='selected'";} ?>>FEMALE</option>
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
                <label for="dob">DATE OF BIRTH (<code title="required"> * </code>)</label>
                <input type="date" name="dob" id="dob" value="<?php if(isset($_POST['dob'])){echo $_POST['dob'];} ?>" onchange="validate_birthday(this,20)">
                <?php 
                if(isset($field_errors['dob'])){
                    echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["dob"].'</p>';
                }else{
                    echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
                }
                ?>
            </div>

            <div class="form-group mt-1">
                <label>ADDRESS (<code title="required"> * </code>)</label>
                <input type="text" name="address" placeholder="Address"  value="<?php if(isset($_POST['address'])){echo $_POST['address'];} ?>" oninput="validate_user_input(this,0,100,1)">
                <?php 
                if(isset($field_errors['address'])){
                    echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["address"].'</p>';
                }else{
                    echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
                }
                ?>
            </div>

            <div class="form-group mt-1">
                <label>EMAIL (<code title="required"> * </code>)</label>
                <input type="text" name="email" placeholder="Email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" oninput="validate_email(this,0,100,1)">
                <?php 
                if(isset($field_errors['email'])){
                    echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["email"].'</p>';
                }else{
                    echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
                }
                ?>
            </div>

            <div class="form-group mt-1">
                <label>CONTACT NUMBER (<code title="required"> * </code>)</label>
                <input type="text" name="contact_number" placeholder="Contact Number" value="<?php if(isset($_POST['contact_number'])){echo $_POST['contact_number'];} ?>" oninput="validate_contact_number(this)">
                <?php 
                if(isset($field_errors['contact_number'])){
                    echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["contact_number"].'</p>';
                }else{
                    echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
                }
                ?>
            </div>

            <div class="form-group mt-1">
                <label>NIC (<code title="required"> * </code>)</label>
                <input type="text" name="nic" placeholder="NIC" value="<?php if(isset($_POST['nic'])){echo $_POST['nic'];} ?>" oninput="validate_user_input(this,10,12,1)">
                <?php 
                if(isset($field_errors['nic'])){
                    echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["nic"].'</p>';
                }else{
                    echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
                }
                ?>
            </div>
                    
            <div class="w-100 p-1"></div>

            <div class="form-group d-flex flex-row w-auto float-right">
        			
        		<button type="submit" name="submit" class="btn btn-blue w-auto m-1">REGISTER</button>
            </div>
        </fieldset>
    </form>
  
 </div>
 