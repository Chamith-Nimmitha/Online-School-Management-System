<?php include_once("session.php"); ?>
<?php

$con = mysqli_connect("localhost", "root", "", "sms-final");

$class_id = $_GET['id'];

$del = mysqli_query($con, "DELETE FROM classroom WHERE id = '$class_id'");

if($del)
{
    mysqli_close($con);
    header("location:classroomsnew-view.php");
    exit;
}
else
{
    echo "Error";
}

?>

