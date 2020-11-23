<?php include_once("session.php"); ?>
<?php

        $con = mysqli_connect("localhost", "root", "", "sms-final");

        $sub_id = $_GET['id'];

        $del = mysqli_query($con, "DELETE FROM subject WHERE id = '$sub_id'");

        if($del)
        {
            mysqli_close($con);
            header("location:subjectnew-view.php");
            exit;
        }
        else
        {
            echo "Error";
        }

?>
<?php