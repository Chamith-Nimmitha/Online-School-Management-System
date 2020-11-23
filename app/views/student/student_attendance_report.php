<?php require_once("../php/database.php") ?>
<?php require_once("../php/common.php") ?>
<?php require_once("../templates/header.php") ?>
<?php require_once("../templates/aside.php") ?>

<div id="content" class="col-9 flex-col align-items-center justify-content-start fs-14">

<form action="student_attendance_report.php" method="post" enctype="multipart/form-data" >
		<fieldset class="col-12">
			<legend>Attendance Report</legend>

				<div class="form-group">
					<label for="exam">Select The Month</label>
					<select name="exam" id="">
						<option value="January">January</option>
						<option value="February">February</option>
						<option value="March">March</option>
						<option value="April">April</option>
						<option value="May">May</option>
						<option value="June">June</option>
						<option value="July">July</option>
						<option value="August">August</option>
						<option value="September">September</option>
						<option value="October">October</option>
						<option value="November">November</option>
						<option value="December">December</option>

					</select>
				</div>
				<div class="form-group ">
					<div class="row justify-content-center align-items-center">
					<input type="submit" value="Show" name="Show" class="m-2 btn btn-blue">
				</div>
				</div>


		</fieldset>
	</form>

<?php 
if(isset($_POST['Show']))
echo'
<div class="container mt-5 col-12 table table-strip-dark text-center">
<table style="width:1010px">
  <thead>
  <tr class="bg-navyblue1">
    <th>ID</th>
    <th>Student Name</th>
    <th>Grade</th>
    <th>Class Teacher</th>
  </tr>
</thead>
  <tr>
    <td>160012</td>
    <th>David Morris</th>
    <th>8</th>
    <th>Kevin Alex</th>
  </tr>
</table>
</div>



<div class="mt-5">
<h1>Attendance Report</h1>
</div>

<div class="border b-rad bg-lightgreen">
<div class="row">

<div class="col-4 align-items-center justify-content-center">
  <div class="bg-red1 border ">
  <input type="checkbox" disabled >
  </div>
  <p >-Absent</p>
</div>

<div class="col-4 align-items-center justify-content-center" >
  <div class="bg-gray1 square border" >
    
  </div>
  <label >-Holiday</label>
</div>

<div class="col-4 align-items-center justify-content-center ">
  <div class="border">
    <input type="checkbox" checked disabled >
  </div>
  <label >-Present</label>
</div>

</div>

<div class="container col-12 table table-strip-dark text-center">
<table style="width:1000px">
  <thead>
    <tr>
      <th class="name-col">Month</th>
      <th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th><th>11</th><th>12</th><th>13</th><th>14</th><th>15</th><th>16</th><th>17</th><th>18</th><th>19</th><th>20</th><th>21</th><th>22</th><th>23</th><th>24</th><th>25</th><th>26</th><th>27</th><th>28</th><th>29</th><th>30</th><th>31</th>
      <!--<th class="missed-col">Days</th>-->
    </tr>
  </thead>
  <tbody class="">
    <tr class="student">
      <td class="name-col">January</td>
      <td class="attend-col"><input type="checkbox" checked disabled ></td>
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col" style="background-color: #808080">
      <td class="attend-col" style="background-color: #808080">
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col" style="background-color: #FF0000"><input type="checkbox" disabled></td>
      <td class="attend-col" style="background-color: #FF0000"><input type="checkbox" disabled></td>
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col" style="background-color: #808080">
      <td class="attend-col" style="background-color: #808080">
      <td class="attend-col" style="background-color: #FF0000"><input type="checkbox" disabled></td>
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col" style="background-color: #808080">
      <td class="attend-col" style="background-color: #808080">
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col" style="background-color: #FF0000"><input type="checkbox" disabled></td>
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col" style="background-color: #808080">
      <td class="attend-col" style="background-color: #808080">
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col"><input type="checkbox" checked disabled></td>
      <td class="attend-col"><input type="checkbox" checked disabled></td>
    </tr>
    <tr>
      <td class="name-col" >February</td>
      <td colspan="31"></td>
    </tr>
    <tr>
      <td class="name-col">March</td>
      <td colspan="31"></td>
    </tr>
    <tr>
      <td class="name-col">April</td>
      <td colspan="31"></td>
    </tr>
    <tr>
      <td class="name-col">May</td>
      <td colspan="31"></td>
    </tr>
    <tr>
      <td class="name-col">June</td>
      <td colspan="31"></td>
    </tr>
    <tr>
      <td class="name-col">July</td>
      <td colspan="31"></td>
    </tr>
    <tr>
      <td class="name-col">August</td>
      <td colspan="31"></td>
    </tr>
    <tr>
      <td class="name-col">September</td>
      <td colspan="31"></td>
    </tr>
    <tr>
      <td class="name-col">October</td>
      <td colspan="31"></td>
    </tr>
    <tr>
      <td class="name-col">November</td>
      <td colspan="31"></td>
    </tr>
    <tr>
      <td class="name-col">December</td>
      <td colspan="31"></td>
    </tr>
<!--    <tr class="student">
      <td class="">February</td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class="">0</td>
    </tr>
    <tr class="student">
      <td class="">March</td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class="">0</td>
    </tr>
    <tr class="student">
      <td class="">April</td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class="">0</td>
    </tr>
    <tr class="student">
      <td class="">May</td>    
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class="">0</td>
    </tr>
    <tr class="student">
      <td class="">June</td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class="">0</td>
    </tr>
    <tr class="student">
      <td class="">July</td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class="">0</td>
    </tr>
    <tr class="student">
      <td class="">August</td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class="">0</td>
    </tr>
    <tr class="student">
      <td class="">September</td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class="">0</td>
    </tr>
    <tr class="student">
      <td class="">October</td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class="">0</td>
    </tr>
    <tr class="student">
      <td class="">November</td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class="">0</td>
    </tr>
    <tr class="student">
      <td class="">December</td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class=""><input type="checkbox"></td>
      <td class="">0</td>
    </tr>-->
  </tbody>
</table>

<div class="row mt-5 justify-content-center align-items-center ">
	<form>
		<fieldset class="col-12 bg-navyblue1 fs-white">
		<div class="row justify-content-center align-items-center bg-white fs-navyblue border b-rad">	
		<h3>January</h3>
		</div>

    
		<div class="form-group ">
		<!--<p ><b>Number of School days:  18</b></p>
		<p><b>Number of Present days: 16</b></p>
		<p><b>Number of Absent days:  2</b></p>
    <p><b>Attendance Percentage:  88%</b></p>-->
    <table style="width:300px" class="bg-darkslategray fs-white">
      <thead class="bg-darkslategray fs-white">
      <tr>
        <th>Number of School days</th>
        <th>18</th>
      </tr>
      <tr>
        <th>Number of Present days</th>
        <th>16</th>
      </tr>
      <tr>
        <th>Number of Absent days</th>
        <th>18</th>
      </tr>
      <tr>
        <th>Attendance Percentage</th>
        <th>88%</th>
      </tr>
    </thead>
    </table>
		</div>
</div>
  </div>

	</form>


</div>

				<div class="form-group">
          <div class="row justify-content-end align-items-end fs-16">
					<input type="submit" value="Download as PDF" class="m-2 btn btn-blue">
				</div>
        </div>
</div>
</div>
';
?>



<?php require_once("../templates/footer.php") ?>