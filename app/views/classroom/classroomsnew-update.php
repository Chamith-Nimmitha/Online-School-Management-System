<?php// include_once("session.php"); ?>
<?php// require_once("../php/common.php"); ?>
<?php// require_once("../php/database.php"); ?>


<?php require_once("../templates/header.php") ;?>
<?php require_once("../templates/aside.php"); ?>
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

<?php
   require_once("../php/database.php");

   $con = mysqli_connect("localhost", "root", "", "sms-final");
   
   @$class_id = $_GET['id'];
   
   //$qry = mysqli_query($con, "SELECT * FROM classroom WHERE id = '$class_id'");

   $qry = mysqli_query($con, "SELECT * FROM classroom WHERE id = '$class_id'");
   
   $result = mysqli_fetch_array($qry);

   // $class_id = $_GET['id'];

   // $con = mysqli_connect("localhost", "root", "", "sms-final");
   // $qry = mysqli_query($con, "SELECT * FROM classroom WHERE id = $class_id");

   // $result = mysqli_fetch_array($qry);

    if(isset($_POST['update']))
    {
    	$data = explode("-", $_POST['grade']);
        $category = $_POST['category'];
        $section_id = $data[0];
        $grade = $data[1];
        $class = $_POST['class'];
        $class_teacher = $_POST['class_teacher'];
        $timetable = $_POST['timetable'];
        //$class_code = $_POST['class_code'];
        //echo $grade;
        if(!empty($category) || !empty($grade) || !empty($class))
        {
            $con = mysqli_connect("localhost", "root", "", "sms-final");

            //$result = $sub_name;                                                                                       
            //$class_code = ($grade) . ($class);

            $SELECT = "SELECT section_id,class FROM classroom WHERE section_id = ? && class = ? LIMIT 1";

            //$INSERT = "INSERT INTO classroom (section_id, class) VALUES (?,?)";
            //$UPDATE = mysqli_query($con, "update classroom set section_id='$section_id', class='$class' where id='$class_id'");

            	//echo $section_id;
            	//echo $class;
            	//echo $class_teacher;
                $stmt = $con->prepare($SELECT);
                $stmt->bind_param("is", $section_id, $class);
                $stmt->execute();
                $stmt->bind_result($section_id, $class);
                $stmt->store_result();
                $rnum = $stmt->num_rows();

                if($rnum == 0)
                {
                    $stmt->close();

                    $UPDATE = mysqli_query($con, "update classroom set section_id='$section_id', class='$class' where id='$class_id'");
                    //$stmt = $conn->prepare($UPDATE);
                    // echo $grade;

                    //$stmt->bind_param("is", $section_id, $class);

                   // $stmt->execute();
                    echo "New Classroom updated successfully";
                    if($con->errno){
                    	echo $con->error;
                    }
                
                }
                else
                {
                    echo "Already registered class";
                }
                

                //$stmt->close();
                $con->close();
            
        }
    }

?>
<?php// require_once("../templates/header.php") ;?>
<?php// require_once("../templates/aside.php"); ?>
<?php /*
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
*/?>

<h2 class="fs-30">UPDATE CLASSROOMS</h2>
		
<hr class="w-100">

<form  method="post" action="classroomsnew-update.php">

<div class="form-group mt-1">
    <label>SECTION</label>
<?php
    
    // @$cat=$_GET['cat']; 
    // echo "<br>Status<br>";
     $con = mysqli_connect("localhost", "root", "", "sms-final");
 
     $query = "SELECT DISTINCT (category) as category  FROM section";

    // $query4 = "SELECT * FROM section WHERE id = $result[section_id]";
      //  $q = mysqli_query($con, $query4);
       // $r = mysqli_fetch_array($q);
 
     if($r_set = $con->query($query))
     {

        

         echo "<SELECT id=s1 onChange='reload()' name=category><option value = '" . $result['id'] . "' required>".$result['id']."</option>";
         //echo "<SELECT id=s1 onChange='reload()' name=category><option value = '' required>SELECT</option>";
 
         while($row = $r_set->fetch_assoc())
         {
             //echo "<option value=$row[section]>$row[section]</option>";
 		echo "<option value='" . $row['category'] . "'>".$row['category']."</option>";
         }
 
         echo "</select>";
     }
 
     else
     {
         echo $con->error;
     }
 
 
     //echo "<br>Grades<br>";
?>
    <label>GRADE</label>
<?php
 
     @$cat = $_GET['cat'];
     
     $query2 = "SELECT id, grade FROM section WHERE category = ?";
 
    //$result2 = mysqli_query($con, $query2);
    //$data2 = mysqli_fetch_assoc($result2);

    $qry2 = mysqli_query($con, "SELECT * FROM section WHERE id = '");
   
   //$result2 = mysqli_fetch_array($qry2);

     if($stmt = $con->prepare($query2))
     {
         $stmt->bind_param('s', $cat);
         $stmt->execute();
         $r_set = $stmt->get_result();

 
        echo "<SELECT id=s2 name=grade><option value='" . $result['id'] . "'>B</option>";
         //echo "<SELECT id=s2 name=grade><option value=''></option>";
 
         while($row = $r_set->fetch_assoc())
         {
            // echo "<option value=$row[id]>$row[grade]</option>";
 		echo "<option value='" . $row['id'] . "-".$row['grade']."'>".$row['grade']."</option>";
         }
 
         echo "</select>";
     }
 
     else
     {
         echo $con->error;
     }
 
 
 ?>
 
     <script>
 
         function reload()
         {
             var v1 = document.getElementById('s1').value;
             //document.write(v1);
             self.location = 'classroomsnew-update.php?cat=' + v1;
         }
 
     </script>
 
 
</div>
        

    <div class="form-group mt-1">
        <label>CLASS</label>
        <input type="text" name="class"  value="<?php echo $result['class'] ?>" >
    </div>

    <?php /*
    <div class="form-group mt-1">
        <label>CLASS TEACHER</label>
        <input type="text" name="class_teacher"  value="" required>
    </div>
*/ ?>


<div class="form-group mt-1">
        <label>CLASS TEACHER</label>

        <?php

            $query3 = "SELECT id, name_with_initials FROM teacher";
    
            if($r_set = $con->query($query3))
            {
                echo "<SELECT id=s3 name=class_teacher><option value = ''>--SELECT--</option>";

                while($row = $r_set->fetch_assoc())
                {
                    //echo "<option value=$row[section]>$row[section]</option>";
                echo "<option value='" . $row['id'] . "'>".$row['name_with_initials']."</option>";
                }

                echo "</select>";
            }

            else
            {
                echo $con->error;
            }


        ?>

        <?php //<input type="text" name="class_teacher"  value="" required> ?>
    </div>


    <div class="form-group mt-1">
        <label>TIMETABLE</label>
        <input type="number" name="timetable"  value="">
    </div>
    <div class="w-100 p-1"></div>

    <div class="form-group d-flex flex-row w-auto float-right">
			
        <button type="submit" name="update" class="btn btn-blue w-auto m-1">UPDATE</button>
        
        <button><a  class="btn btn-blue" href="classroomsnew-view.php">VIEW</a></button>
    </div>

</form>
 
<?php //</div> ?> 

</div>

<?php require_once("../templates/footer.php") ;?>
