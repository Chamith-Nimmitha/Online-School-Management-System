<?php include_once("session.php"); ?>
<?php require_once("../templates/header.php") ;?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">


<?php
require_once("../php/database.php");

$con = mysqli_connect("localhost", "root", "", "sms-final");



$tid = $_GET['id'];

$qry = mysqli_query($con, "SELECT * FROM teacher WHERE id = $tid");

$data = mysqli_fetch_array($qry);

if(isset($_POST['update']))
{
        $name = $_POST['name_with_initials'];
        $fname = $_POST['first_name'];
        $midname = $_POST['middle_name'];
        $lname = $_POST['last_name'];
        $gender = $_POST['gender'];
        $birthday = $_POST['dob'];
        $Address = $_POST['address'];
        $Email = $_POST['email'];
        $mobile = $_POST['contact_number'];
        $Nic = $_POST['nic'];
        

    $update = mysqli_query($con, "update teacher set name_with_initials='$name', first_name='$fname', middle_name='$midname', last_name='$lname', gender='$gender', dob='$birthday', address='$Address', email='$Email', contact_number='$mobile', nic='$Nic',  where id='$tid'");

    if($update)
    {
        echo "UPDATED";
        mysqli_close($con);

    }
    else
    {
        echo "ERROR";
    }
}

?>

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

<?php require_once("../templates/footer.php") ;?>