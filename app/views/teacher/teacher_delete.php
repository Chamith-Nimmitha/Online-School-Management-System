<?php include_once("session.php"); ?>
<?php

        $con = mysqli_connect("localhost", "root", "", "sms-final");

        $tid = $_GET['id'];

        $del = mysqli_query($con, "DELETE FROM teacher WHERE id = '$tid'");

        if($del)
        {
            mysqli_close($con);
            header("location:teacher-all.php");
            exit;
        }
        else
        {
            echo "Error";
        }

?>
<?php