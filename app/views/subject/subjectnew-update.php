<?php //include_once("session.php"); ?>
<?php //require_once("../templates/header.php") ;?>
<?php //require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">


<?php
//require_once("../php/database.php");

$con = mysqli_connect("localhost", "root", "", "sms-final");



$sub_id = $_GET['id'];

$qry = mysqli_query($con, "SELECT * FROM subject WHERE id = $sub_id");

$data = mysqli_fetch_array($qry);

if(isset($_POST['update']))
{
    //$grade = $_POST['grade'];
    $medium = $_POST['medium'];
    $sub_name = $_POST['sub_name'];
   
    $sub_des = $_POST['sub_des'];
/*
	$result = $sub_name;                                                                                       
    //$sub_code = ($grade) . strtoupper(substr($result, 0, 3));
    $sub_code = strtoupper(substr($medium, 0, 1)) . ($grade) . strtoupper(substr($result, 0, 3));

    $update = mysqli_query($con, "update subject set grade='$grade', medium='$medium', name='$sub_name', code='$sub_code', description='$sub_des' where id='$sub_id'");

    if($update)
    {
        echo "UPDATED";
        mysqli_close($con);

    }
    else
    {
        echo "ERROR";
    }
}*/


if(!empty($grade) || !empty($medium) || !empty($sub_name) || !empty($sub_code))
        {
            $con = mysqli_connect("localhost", "root", "", "sms-final");

            $SELECT = "SELECT code FROM subject WHERE code = ? LIMIT 1";

		    $result = $sub_name;                                                                                       
            $sub_code = strtoupper(substr($medium, 0, 1)) . ($data['grade']) . strtoupper(substr($result, 0, 3));
            
        //$INSERT = "INSERT INTO subject (grade, medium, name, code, description) VALUES (?,?,?,?,?)";
        
       // $update = mysqli_query($con, "update subject set grade='$grade', medium='$medium', name='$sub_name', code='$sub_code', description='$sub_des' where id='$sub_id'");

            $stmt = $con->prepare($SELECT);
                $stmt->bind_param("s", $sub_code);
                $stmt->execute();
                $stmt->bind_result($sub_code);
                $stmt->store_result();
                $rnum = $stmt->num_rows();

                if($rnum == 0)
                {
                    $stmt->close();

                    $update = mysqli_query($con, "update subject set medium='$medium', name='$sub_name', code='$sub_code', description='$sub_des' where id='$sub_id'");

                  //  $stmt = $con->prepare($update);
                  //  $stmt->bind_param("issss", $grade, $medium, $sub_name, $sub_code, $sub_des);
                  //  $stmt->execute();
                    echo "SUBJECT UPDATED SUCCESSFULLY";
                }
                else
                {
                    echo "ALREADY REGISTERED SUBJECT";
                }
                

               // $stmt->close();
                $con->close();
            
        }
    }



?>

<h2 class="fs-30">UPDATE SUBJECTS</h2>

<form method="POST">

    <div>
        <label><b>GRADE</b></label>
            <?php /*
                $con = mysqli_connect("localhost", "root", "", "sms-final");

                $query = "SELECT DISTINCT(grade) as grade FROM section";
                    
                if($r_set = $con->query($query))
                {
                    //echo "<SELECT id=s1 name=grade><option value = '' >".$data['grade']. "</option>";
                    
                    echo "<SELECT id=s1 name=grade><option value='" . $data['grade'] . "'>".$data['grade']."</option>";
                    //echo "<option value='" . $row['id'] . "-".$row['grade']."'>".$row['grade']."</option>";

                    while($row = $r_set->fetch_assoc())
                    {
                        echo "<option value=$row[grade]>$row[grade]</option>";
                    
                    }
                    
                    echo "</select>";
                }
                    
                else
                {
                    echo $con->error;
                }
           */ ?>

            <?php echo "<strong>" . $data['grade'] . "</strong>"?>
           <?php //<type="text" name="grade" value="<?php echo $data['grade'] ?>
    </div>

    <div>
        <label>SUBJECT MEDIUM</label>
         
            <select name="medium">
                <option value="<?php echo $data['medium'] ?>"><?php echo $data['medium'] ?></option>
                <option value="Sinhala">Sinhala</option>
                <option value="English">English</option>
                <option value="Tamil">Tamil</option>
            </select>
        
        <?php
         /*   $grade = $data['grade'];
            $query2 = "SELECT DISTINCT(medium) as s_medium FROM subject WHERE grade = $grade, name = $sub_name";

            if($r_set2 = $con->query($query2))
            {
                echo "<SELECT id=s2 name=medium><option value='" . $data['medium'] . "'>". $data['medium']."</option>";

                while($row2 = $r_set2->fetch_assoc())
                {
                    echo "<option value=$row2[medium]>$row2[medium]</option>";
                }

                echo "</select>";
            }*/
        ?> 
    </div>

    <div>
        <label>SUBJECT NAME</label>
        <input type="text" name="sub_name" value="<?php echo $data['name'] ?>" required>
    </div>

    

    <div class="form-group mt-1">
        <label>SUBJECT DESCRIPTION </label>
        <textarea  rows="10" cols="150" name="sub_des" value="<?php echo $data['description'] ?>" required>
            
            
        </textarea>
    </div>

    

    <div class="w-100 p-1"></div>

        <div class="form-group d-flex flex-row w-auto float-right">
            <button type="submit" name="update" class="btn btn-blue w-auto m-1">UPDATE</button>
            
            <button><a  class="btn btn-blue" href="subjectnew-view.php">VIEW</a></button>
		</div>

    
</form>

</div>

<?php //require_once("../templates/footer.php") ;?>