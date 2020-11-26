<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

<h2 class="fs-30">UPDATE TEACHERS</h2>

<form method="POST" class="col-10">
    
    <div class="form-group mt-1">
        <label>NAME</label>
        <input type="text" name="name_with_initials" value="<?php echo $data['name_with_initials'] ?>" required>
    </div>

    <div class="form-group mt-1">
        <label>FIRST NAME</label>
        <input type="text" name="first_name" value="<?php echo $data['first_name'] ?>" required>
    </div>

    <div class="form-group mt-1">
        <label>MIDDLE NAME</label>
        <input type="text" name="middle_name" value="<?php echo $data['middle_name'] ?>" required>
    </div>

    <div class="form-group mt-1">
        <label>LAST NAME</label>
        <input type="text" name="last_name" value="<?php echo $data['last_name'] ?>" required>
    </div>
    
    <div>
        <label>GENDER</label>
            <select name="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
    </div>

    <div class="form-group mt-1">
        <label>DATE OF BIRTH</label>
        <input type="date" name="dob"  value="<?php echo $data['dob'] ?>" required>
    </div>

    <div class="form-group mt-1">
        <label>ADDRESS</label>
        <input type="text" name="address"  value="<?php echo $data['address'] ?>" required>
    </div>

    <div class="form-group mt-1">
        <label>EMAIL</label>
        <input type="text" name="email"  value="<?php echo $data['email'] ?>" required>
    </div>

    <div class="form-group mt-1">
        <label>CONTACT NUMBER</label>
        <input type="number" name="contact_number"  value="<?php echo $data['contact_number'] ?>" required>
    </div>

    <div class="form-group mt-1">
        <label>NIC</label>
        <input type="text" name="nic"  value="<?php echo $data['nic'] ?>" required>
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

