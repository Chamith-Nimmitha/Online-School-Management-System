
<?php require_once("../templates/header.php"); ?>

<div class="col-12 fs-15 bg-darkblue  m-0 p-0  " >
	<div class="col-10 hmpg ">
		<ul>
			
  				<li class="float-left d-block p-3 "><a href="<?php echo set_url('index.php') ?>">Home</a></li>
  				<li class="hmpgactive float-left d-block p-3"><a href="<?php echo set_url('pages/contact.php') ?>">Contact us</a></li>
  				<li class="float-left d-block p-3"><a href="<?php echo set_url('pages/about.php') ?>">About</a></li>
  		
		</ul>
	</div>
</div>

<div class="border b-rad mt-1 p-2 bg-white ">
<div class="col-12">
	<img src="../img/<?php if(!empty($header)){echo $header['map'];} ?>" alt="map1" width=1340px height=400px>
</div>

<div class="row justify-content-center align-items-center">
<div class=" col-2 border b-rad m-3 p-3 text-justify fs-15 ">
	    <div class="justify-content-center align-items-center d-block">
    		<img src="../img/location.png" alt="location" width=40px height=40px>
        </div>
     <div class="d-block justify-content-center align-items-center">   
	<p><br><?php if(!empty($header)){echo $header['address'];} ?></p>
	</div>
</div>

<div class="col-2 border b-rad m-3 p-3 text-justify fs-15">
	    <div class="justify-content-center align-items-center">
    		<img src="../img/telephone.png" alt="telephone" width=40px height=40px>
        </div>
         <div class="d-block justify-content-center align-items-center">
	<p><br><?php if(!empty($header)){echo$header['contact_number'];} ?></p>
		</div>
</div>

<div class="col-3 border b-rad m-3 p-3 text-justify fs-15">
	    <div class="justify-content-left align-items-start d-block">
    		<img src="../img/email.png" alt="email" width=40px height=40px>
        </div>

        <div class="d-block justify-content-center align-items-center">
			<p><br><?php if(!empty($header)){echo $header['email'];} ?></p>
		</div>
</div>

<div class="col-3 border b-rad m-3 p-3 text-justify fs-15">
	    <div class="justify-content-left align-items-start d-block">
    		<img src="../img/web.png" alt="web" width=40px height=40px>
        </div>

        <div class="d-block justify-content-center align-items-center">
			<p><br><?php if(!empty($header)){echo $header['website'];} ?></p>
		</div>
</div>

</div>




<div class="row d-block bg-white">

<div class="row align-items-center justify-content-center">
<h2>Have some Questions?</h2>
</div>

<div class="col-12 align-items-center justify-content-center">



<div class="d-block bg-darkslategray fs-white border b-rad">
<form>
	<fieldset>
	<div class="form-group d-block">
	<label for="your-name">Your Name</label>
	<input type="text" name="your-name">
	</div>

	<div class="form-group d-block">
	<label for="your-email">Your Email</label>
	<input type="text" name="your-email">
	</div>

	<div class="form-group d-block">
	<label for="your-comments">Your Comments</label>
	<textarea rows="10" cols="50"></textarea>
	</div>

	<div class="form-group">
	<input type="submit" name="send" value="send" class="m-2 btn btn-blue">
	</div>
</fieldset>

</form>
</div>

</div>
</div>
</div>


<?php require_once("../templates/footer.php"); ?>