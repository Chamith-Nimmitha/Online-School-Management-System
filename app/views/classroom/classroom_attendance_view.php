<?php
    $con = mysqli_connect("localhost", "root", "", "sms-final");

	$result_set = mysqli_query($con, "SELECT * FROM attendance");
?>

<?php require_once("../templates/header.php") ;?>
<?php require_once("../templates/aside.php"); ?>
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
    <div class="d-flex justify-content-center align-items-center">
        <form action="<?php echo set_url('pages/student_list.php'); ?>" method="get" class="d-flex align-items-center col-12">
            <div class="d-flex col-12 align-items-center justify-content-center">
                <div class="mt-5">
                    <input type="reset" class="btn btn-blue" onclick="reset_form(this)" value="reset">
                </div>
                <div class="ml-5">
                    <label for="studebt-id">Student ID</label>
                    <input type="text" name="student-id" id="student-id" placeholder="Student ID" value="<?php if(isset($_GET['student-id'])){echo $_GET['student-id'];} ?>">
                </div>
                <div class="ml-5 d-flex flex-col">
                    <label for="date">Date</label>
                    <input type="date" name="date" id="date" placeholder="Student ID" value="<?php if(isset($_GET['date'])){echo $_GET['date'];} ?>">
                </div>
                <input type="submit" class="btn btn-blue ml-3 mt-5" value="Show">
            </div>
        </form>
    </div>
    <form action="" method="POST" class="col-12 d-flex justify-content-center">
        <div class="col-8 flex-col" style="overflow-x: scroll;overflow-y: hidden;">  
            <table class="table-strip-dark">
                <caption class="p-5"><b>Attendance Sheet <br>2020-10-10 <br>Class 12-B</b></caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Attendance</th>
                            <th>View Attendance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                Raj Shekhar
                                <input type="hidden" name="student_name[]" value="Raj Shekhar" />
                            </td>
                            <td>
                                <label for="present0">
                                    <input type="radio" id="present0" name="attendance_status[0]" value="Present"> Present
                                </label>
                                <label for="absent0">
                                    <input type="radio" id="absent0" name="attendance_status[0]" value="Absent"> Absent
                                </label>
                            </td>
                            <td class="text-center">
                                <div>
                                    <a class="btn btn-blue" href="<?php echo set_url('pages/student_attendance_view.php'); ?>" >VIEW REPORT</a>
                                 </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                Pankaj Kumar
                                <input type="hidden" name="student_name[]" value="Pankaj Kumar" />
                            </td>
                            <td>
                                <label for="present1">
                                    <input type="radio" id="present1" name="attendance_status[1]" value="Present"> Present
                                </label>
                                <label for="absent1">
                                    <input type="radio" id="absent1" name="attendance_status[1]" value="Absent"> Absent
                                </label>
                            </td>
                            <td class="text-center">
                                <div>
                                    <a class="btn btn-blue" href="<?php echo set_url('pages/student_attendance_view.php'); ?>" >VIEW REPORT</a>
                                 </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>
                                Amit Singh
                                <input type="hidden" name="student_name[]" value="Amit Singh" />
                            </td>
                            <td>
                                <label for="present2">
                                    <input type="radio" id="present2" name="attendance_status[2]" value="Present"> Present
                                </label>
                                <label for="absent2">
                                    <input type="radio" id="absent2" name="attendance_status[2]" value="Absent"> Absent
                                </label>
                            </td>
                            <td class="text-center">
                                <div>
                                    <a class="btn btn-blue" href="<?php echo set_url('pages/student_attendance_view.php'); ?>" >VIEW REPORT</a>
                                 </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>
                                Arjun Kumar
                                <input type="hidden" name="student_name[]" value="Arjun Kumar" />
                            </td>
                            <td>
                                <label for="present3">
                                    <input type="radio" id="present3" name="attendance_status[3]" value="Present"> Present
                                </label>
                                <label for="absent3">
                                    <input type="radio" id="absent3" name="attendance_status[3]" value="Absent"> Absent
                                </label>
                            </td>
                            <td class="text-center">
                                <div>
                                    <a class="btn btn-blue" href="<?php echo set_url('pages/student_attendance_view.php'); ?>" >VIEW REPORT</a>
                                 </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>
                                Amit Kumar
                                <input type="hidden" name="student_name[]" value="Amit Kumar" />
                            </td>
                            <td>
                                <label for="present4">
                                    <input type="radio" id="present4" name="attendance_status[4]" value="Present"> Present
                                </label>
                                <label for="absent4">
                                    <input type="radio" id="absent4" name="attendance_status[4]" value="Absent"> Absent
                                </label>
                            </td>
                            <td class="text-center">
                                <div>
                                    <a class="btn btn-blue" href="<?php echo set_url('pages/student_attendance_view.php'); ?>" >VIEW REPORT</a>
                                 </div>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>
                                Suraj Tiwari
                                <input type="hidden" name="student_name[]" value="Suraj Tiwari" />
                            </td>
                            <td>
                                <label for="present5">
                                    <input type="radio" id="present5" name="attendance_status[5]" value="Present"> Present
                                </label>
                                <label for="absent5">
                                    <input type="radio" id="absent5" name="attendance_status[5]" value="Absent"> Absent
                                </label>
                            </td>
                            <td class="text-center">
                                <div>
                                    <a class="btn btn-blue" href="<?php echo set_url('pages/student_attendance_view.php'); ?>" >VIEW REPORT</a>
                                 </div>
                            </td>
                        </tr>
                    </tbody>
            </table>
        </div>
        <div class="d-flex flex-row w-75 justify-content-end">
            <button type="submit" name="submit" class="btn btn-blue m-1">Mark Attendance</button>
        </div>
    </form>
</div>

<?php require_once("../templates/footer.php") ;?>
