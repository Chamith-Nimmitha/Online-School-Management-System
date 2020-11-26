

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

<h2 class="fs-30">TEACHER-REGISTRATION FORM</h2>
		
<hr class="w-100 mt-5 mb-5">

<form  method="post" action="teacher_registration_form.php" class="col-8">
    <fieldset class="p-5">
        <legend>Registration form</legend>
        <div class="form-group mt-1">
            <label>NAME WITH INITIALS</label>
            <input type="text" name="name_with_initials"  value="" oninput="validate_user_input(this,0,50,1)" placeholder="Name With initials">
            <p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
        </div>

        <div class="form-group mt-1">
            <label>FIRST NAME</label>
            <input type="text" name="first_name"  placeholder="First Name" value="" oninput="validate_user_input(this,0,20,1)">
            <p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
        </div>

        <div class="form-group mt-1">
            <label>MIDDLE NAME</label>
            <input type="text" name="middle_name" placeholder="Middle Name" value="" oninput="validate_user_input(this,0,50,0)" >
            <p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
        </div>

        <div class="form-group mt-1">
            <label>LAST NAME</label>
            <input type="text" name="last_name"  value="" placeholder="Last Name" oninput="validate_user_input(this,0,20,1)">
            <p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
        </div>

        <div class="form-group">
            <label>GENDER</label>
            <select name="gender" style="width: 100px;">
                <option value="male">MALE</option>
                <option value="female">FEMALE</option>
            </select>
        </div>

        <div class="form-group mt-1">
            <label for="dob">DATE OF BIRTH</label>
            <input type="date" name="dob" id="dob" onchange="validate_birthday(this,20)">
            <p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
        </div>

        <div class="form-group mt-1">
            <label>ADDRESS</label>
            <input type="text" name="address" placeholder="Address"  value="" oninput="validate_user_input(this,0,100,1)">
            <p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
        </div>

        <div class="form-group mt-1">
            <label>EMAIL</label>
            <input type="text" name="email" placeholder="Email" value="" oninput="validate_email(this,0,100,1)">
            <p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
        </div>

        <div class="form-group mt-1">
            <label>CONTACT NUMBER</label>
            <input type="text" name="contact_number" placeholder="Contact Number" value="" oninput="validate_contact_number(this)">
            <p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
        </div>

        <div class="form-group mt-1">
            <label>NIC</label>
            <input type="text" name="nic" placeholder="NIC" value="" oninput="validate_user_input(this,10,12,1)">
            <p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
        </div>
                
        <div class="w-100 p-1"></div>

        <div class="form-group d-flex flex-row w-auto float-right">
    			
    		<button type="submit" name="submit" class="btn btn-blue w-auto m-1">REGISTER</button>
        </div>
    </fieldset>
</form>
 
<?php //</div> ?> 

 </div>
 
 