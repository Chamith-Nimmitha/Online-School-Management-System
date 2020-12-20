
<?php 
 
 ?>
<div id="content" class="col-9 flex-col align-items-center justify-content-start fs-14">

<h2>Student Details</h2>

<div class="container mt-5 col-12 table table-strip-dark text-center">

<table class="w-100">
  <thead>
  <tr class="bg-navyblue1">
    <th>ID</th>
    <th>Student Name</th>
    <th>Grade</th>
    <th>Class</th>
  </tr>
</thead>
  <tr>
    <td><?php if(isset($result['id'])){echo $result['id'];}else{ echo "160012";} ?></td>
    <td><?php if(isset($result['name_with_initials'])){echo $result['name_with_initials'];}else{ echo "David Morris";} ?></td>
    <td><?php if(isset($result['grade'])){echo $result['grade'];}else{ echo "8";} ?></td>
    <td><?php if(isset($result['class'])){echo $result['class'];}else{ echo "A";} ?></td>
  </tr>
</table>

</div>

<div class="mt-5">

<h2>Student Exam Report</h2>

</div>

  <table  class="w-100 mt-5 table table-strip-dark text-center">

    <thead class="bg-navyblue1 fs-white">

      <tr>
      	<td colspan="9">Student Report Card</td>
      </tr>

      <tr>
        <td colspan="3">Subject </td>
        <td colspan="2"> First Term </td>
        <td colspan="2"> Second Term </td>
        <td colspan="2"> Third Term </td>
      </tr>

      <tr>
        <td>Code </td>
        <td colspan="2"> Name </td>
        <td > Marks </td>
        <td > Grade </td>
        <td > Marks </td>
        <td > Grade </td>
        <td > Marks </td>
        <td > Grade </td>
      </tr>
    </thead>
    
    <tbody>

      <tr>
        <td>MAT12</td>
        <td colspan="2">Mathematics </td>
        <td>86</td>
        <td>A</td>
        <td>78</td>
        <td>A</td>
        <td>65</td>
        <td>B</td>
      </tr>

      <tr>
        <td>PHY12</td>
        <td colspan="2">Physics </td>
        <td>62</td>
        <td>C</td>
        <td>69</td>
        <td>B</td>
        <td>72</td>
        <td>B</td>
      </tr>

      <tr>
        <td>CHE12</td>
        <td colspan="2">Chemistry </td>
        <td>72</td>
        <td>B</td>
        <td>78</td>
        <td>A</td>
        <td>80</td>
        <td>A</td>
      </tr>

      <tr>
        <td>HT12</td>
        <td colspan="2">History </td>
        <td>62</td>
        <td>C</td>
        <td>69</td>
        <td>B</td>
        <td>72</td>
        <td>B</td>
      </tr>

      <tr>
        <td>BIO12</td>
        <td colspan="2">Biology </td>
        <td>62</td>
        <td>C</td>
        <td>69</td>
        <td>B</td>
        <td>72</td>
        <td>B</td>
      </tr>

      <tr>
        <td>ICT12</td>
        <td colspan="2">Information Technology</td>
        <td>72</td>
        <td>B</td>
        <td>78</td>
        <td>A</td>
        <td>80</td>
        <td>A</td>
      </tr>


    </tbody>


    <tfoot class="bg-darkslategray fs-white">

      <tr>
        <td colspan="3" class="footer">Total</td>
        <td colspan="2"> 15.0 </td>
        <td colspan="2"> 15.0 </td>
        <td colspan="2">55.95 </td>
      </tr>

      <tr>
        <td colspan="3" class="footer">Average</td>
        <td colspan="2">72.34</td>
        <td colspan="2">67.89</td>
        <td colspan="2">74.32</td>
      </tr>

      <tr>
        <td colspan="3" class="footer">Rank</td>
        <td colspan="2">7</td>
        <td colspan="2">10</td>
        <td colspan="2">6</td>
      </tr>

  </table>



  		<div class="form-group">

      <div class="row justify-content-end align-items-end fs-16">

        <div>
            <a class="btn btn-blue" onClick="window.print()">Download as a PDF</a>
		    </div>

		  </div>

      </div>
</div>