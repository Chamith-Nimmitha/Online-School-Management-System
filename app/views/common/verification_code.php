<div id="content" class="col-12 flex-col align-items-center justify-content-start fs-14">
	<div class="row align-items-center justify-content-center">
		<div class="col-3 align-items-center justify-content-start">
			<?php
				if(isset($error) && !empty($error)){ 
					echo "<p class='w-75 bg-red fg-white p-2 text-center'>";
					echo $error ."<br/>";
					echo "</p>";
				}
			?>

			<form action="" method="post" enctype="multipart/form-data" >
				<fieldset class="col-12 justify-content-center align-items-center">
				<legend>Verification Code</legend>
				<div class="form-group">
					<label for="ver-code">Enter Your Verification Code</label>
					<input type="text" name="ver-code" id="ver-code" placeholder="Verification Code" >
					<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
				</div>

				<div class="form-group ">
					<div class="row justify-content-center align-items-center">
						<input type="submit" value="submit" name="submit" class="m-2 btn btn-blue" size="50">
					</div>
				</div>

				</fieldset>
	
			</form>

		</div>
	</div>
</div>





