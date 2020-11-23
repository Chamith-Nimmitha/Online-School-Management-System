<?php include_once("session.php"); ?>
<?php require_once("../templates/header.php") ;?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

<?php //<div class="col-7 flex-col" style="overflow-x: scroll;overflow-y: hidden;">?>

<?php
    $grade = '';
    $medium = '';
    $sub_name = '';
    $sub_code = '';
    $sub_des = '';

    if(isset($_POST['submit']))
    {
        $grade = $_POST['grade'];
        $medium = $_POST['medium'];
        $sub_name = $_POST['sub_name'];
        $sub_code = $_POST['sub_code'];
        $sub_des = $_POST['sub_des'];

        if(!empty($grade) || !empty($medium) || !empty($sub_name) || !empty($sub_code))
        {
            $con = mysqli_connect("localhost", "root", "", "sms-final");

            $SELECT = "SELECT code FROM subject WHERE code = ? LIMIT 1";

		    $result = $sub_name;                                                                                       
            $sub_code = strtoupper(substr($medium, 0, 1)) ."-". ($grade) ."-". strtoupper(substr($result, 0, 3));
            
		$INSERT = "INSERT INTO subject (grade, medium, name, code, description) VALUES (?,?,?,?,?)";

            $stmt = $con->prepare($SELECT);
                $stmt->bind_param("s", $sub_code);
                $stmt->execute();
                $stmt->bind_result($sub_code);
                $stmt->store_result();
                $rnum = $stmt->num_rows();

                if($rnum == 0)
                {
                    $stmt->close();

                    $stmt = $con->prepare($INSERT);
                    $stmt->bind_param("issss", $grade, $medium, $sub_name, $sub_code, $sub_des);
                    $stmt->execute();
                    echo "New subject inserted successfully";
                }
                else
                {
                    echo "Already registered subject code";
                }

                $stmt->close();
                $con->close();
            
        }
    }

?>

<h2 class="fs-30">ADD SUBJECTS</h2>
		
<hr class="w-100">

<form  method="post" action="subjectnew-add.php">
    
    <div>
        <label>GRADE</label>
        
            <?php
                $con = mysqli_connect("localhost", "root", "", "sms-final");

                $query = "SELECT DISTINCT(grade) as grade FROM section";
                
                if($r_set = $con->query($query))
                {
                    echo "<SELECT id=s1 name='grade' required><option>--SELECT--</option>";
                
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
            ?>
        
    </div>

    <div>
        <label>SUBJECT MEDIUM</label>
            <select name="medium" required>
                <option value="">--SELECT--</option>
                <option value="Sinhala">Sinhala</option>
                <option value="English">English</option>
                <option value="Tamil">Tamil</option>
            </select>
    </div>

    <div>
        <label>SUBJECT NAME</label>
        <input type="text" name="sub_name"  value="" required>
    </div>

    <?php
                
        $result = $sub_name;                                                                                    
                
            $sub_code = substr($grade, 6) . strtoupper(substr($result, 0, 3));
            //echo $sub_code;
                
            // $sub_code = $_GET['sub_code'];
    ?> 
    <input type="hidden" name="sub_code" value='<?=$sub_code; ?>'>
            
    <div  class="form-group mt-1">
        <label for="sub_des">SUBJECT DESCRIPTION</label>
        <textarea  rows="10" class="col-12 p-3" name="sub_des" id="sub_des" placeholder="-----ENTER DESCRIPTION HERE.....-----" required="required">
        </textarea>
    </div>

    <div class="w-100 p-1"></div>

    <div class="form-group d-flex flex-row w-auto float-right">
			
        <button type="submit" name="submit" class="btn btn-blue w-auto m-1">SAVE</button>
        
        <button><a  class="btn btn-blue" href="subjectnew-view.php">VIEW</a></button>
    </div>

</form>
 
<?php //</div> ?> 

 </div>
 
 <?php require_once("../templates/footer.php") ;?>