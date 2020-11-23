<?php
/*

<?php require_once("../templates/header.php") ;?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">


<?php



if(isset($_POST['register']))
{
    $section = $_POST['category'];
    $grade = $_POST['grade']; 

    if(!empty($section) || !empty($grade))
    {
        $con = mysqli_connect("localhost", "root", "", "sms-final");

        
        $insert = mysqli_query($con, "INSERT INTO section (category, grade) VALUES ('$section','$grade')");

        if($insert)
        {
            echo "New Grade registered successfully";

            mysqli_close($con);
        }   
        
        else
        {
            echo "Error";
		echo $section;
            	echo $grade;

            if($con)
            {
                echo "Success";
            }
            else
            {
                echo "fail";
            }
        }

    }
}

?>



<h2 class="fs-30">REGISTER GRADES</h2>
		
	<hr class="w-100">

    <form  method="post">

        <div class="form-group mt-1">
            <label>SECTION</label>
                <select name="category">
                    <option value="select">--SELECT--</option>
                    <option value="Primary">Primary</option>
                    <option value="Secondary">6 to 9</option>
                    <option value="O/L">Ordinary Level</option>
                    <option value="A/L">Advanced Level</option>
                </select>
        </div>

        

        <div class="form-group mt-1">
            <label>GRADE</label>
            <input type="text" name="grade"  value="" required>  
        </div>

        <div class="w-100 p-1"></div>

		<div class="form-group d-flex flex-row w-auto float-right">
			<button type="submit" name="register" class="btn btn-blue w-auto m-1">REGISTER</button>
		</div>

    </form>

</div>

<?php require_once("../templates/footer.php") ;?>

*/
?>

<?php require_once("../templates/header.php") ;?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">


<?php



if(isset($_POST['register']))
{
    $category = $_POST['category'];
    $grade = $_POST['grade']; 

    if(!empty($category) || !empty($grade))
    {
        $con = mysqli_connect("localhost", "root", "", "sms-final");
        
        $insert = mysqli_query($con, "INSERT INTO section (category, grade) VALUES ('$category','$grade')");

        if($insert)
        {
            echo "New Grade registered successfully";

            mysqli_close($con);
        }   
        
        else
        {
            echo "Error";
        }

    }
}

?>



<h2 class="fs-30">REGISTER GRADES</h2>
		
	<hr class="w-100">

    <form  method="post">

        <div class="form-group mt-1">
            <label>SECTION</label>
                <select name="category">
                    <option value="select">--SELECT--</option>
                    <option value="Primary">Primary</option>
                    <option value="Secondary">6 to 9</option>
                    <option value="O/L">Ordinary Level</option>
                    <option value="A/L">Advanced Level</option>
                </select>
        </div>

        

        <div class="form-group mt-1">
            <label>GRADE</label>
            <input type="number" name="grade"  value="" required>  
        </div>

        <div class="w-100 p-1"></div>

		<div class="form-group d-flex flex-row w-auto float-right">
			<button type="submit" name="register" class="btn btn-blue w-auto m-1">REGISTER</button>
		</div>

    </form>

</div>

<?php require_once("../templates/footer.php") ;?>

*/
?>

<?php require_once("../templates/header.php") ;?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">


<?php



if(isset($_POST['register']))
{
    $category = $_POST['category'];
    $grade = $_POST['grade']; 

    if(!empty($category) || !empty($grade))
    {
        $con = mysqli_connect("localhost", "root", "", "sms-final");

        
        $insert = mysqli_query($con, "INSERT INTO section (category, grade) VALUES ('$category','$grade')");

        if($insert)
        {
            echo "New Grade registered successfully";

            mysqli_close($con);
        }   
        
        else
        {
            echo "Error";
        }

    }
}

?>



<h2 class="fs-30">REGISTER GRADES</h2>
		
	<hr class="w-100">

    <form  method="post">

        <div class="form-group mt-1">
            <label>SECTION</label>
                <select name="category">
                    <option value="select">--SELECT--</option>
                    <option value="Primary">Primary</option>
                    <option value="Secondary">6 to 9</option>
                    <option value="O/L">Ordinary Level</option>
                    <option value="A/L">Advanced Level</option>
                </select>
        </div>

        

        <div class="form-group mt-1">
            <label>GRADE</label>
            <input type="number" name="grade"  value="" required>  
        </div>

        <div class="w-100 p-1"></div>

		<div class="form-group d-flex flex-row w-auto float-right">
			<button type="submit" name="register" class="btn btn-blue w-auto m-1">REGISTER</button>
		</div>

    </form>

</div>

<?php require_once("../templates/footer.php") ;?>