<?php include_once("session.php"); ?>
<?php require_once("../templates/header.php") ;?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

<?php //<div class="col-7 flex-col" style="overflow-x: scroll;overflow-y: hidden;">?>

<?php
    
    $tid = '';
    $name = '';
    $fname = '';
    $midname = '';
    $lname = '';
    $gender = '';
    $birthday = '';
    $Address = '';
    $Email = '';
    $mobile = '';
    $Nic = '';
    $active = '';
    $Interview = '';
    $profile = '';


    $required_fields = array();
	$required_fields['name-with-initials']=50;
	$required_fields['first-name']=20;
	$required_fields['middle-name']=50;
	$required_fields['last-name']=20;
	$required_fields['gender']=6;
	$required_fields['dob']=Null;
	$required_fields['address']=100;
    $required_fields['email']=100;
    $required_fields['nic']=12;

    if(isset($_POST['submit']))
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

        if(!empty($name) && !empty($fname) && !empty($lname) && !empty($gender) && !empty($birthday) && !empty($Address) && !empty($Email) && !empty($mobile) && !empty($Nic))
        {
            $con = mysqli_connect("localhost", "root", "", "sms-final");

            $SELECT = "SELECT `id` FROM teacher WHERE email = ? LIMIT 1";

		    
		$INSERT = "INSERT INTO teacher (name_with_initials, first_name, middle_name, last_name, gender, dob, address, email, contact_number, nic) VALUES (?,?,?,?,?,?,?,?,?,?)";

               $stmt = $con->prepare($SELECT);
                $stmt->bind_param("s", $Email);
                $stmt->execute();
                $stmt->bind_result($tid);
                $stmt->store_result();
                $rnum = $stmt->num_rows();
                if($rnum === 0)
                {
                    $stmt->close();
                    $stmt = $con->prepare($INSERT);
                    $stmt->bind_param("ssssssssss",$name, $fname, $midname, $lname, $gender, $birthday, $Address, $Email, $mobile, $Nic);
                    $stmt->execute();
                    $USER = "INSERT INTO user (email, role) VALUES (?,?)";
                    $stmt2 = $con->prepare($USER);
                    $role = "teacher";
                    $stmt2->bind_param("ss",$Email,$role);
                    $stmt2->execute();
                    echo "<p class='w-75 bg-green fg-white p-2 text-center'>";
                    echo "Registration successful.";
                    echo "</p>";
                }
                else
                {
                    echo "<p class='w-75 bg-red fg-white p-2 text-center'>";
                    echo "Already registered.";
                    echo "</p>";
                }
                $stmt->close();
                $con->close();
        }else{
            echo "<p class='w-75 bg-red fg-white p-2 text-center'>";
            echo "Please fill all fields.";
            echo "</p>";
        }
    }
?>

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
 
 <?php require_once("../templates/footer.php") ;?>