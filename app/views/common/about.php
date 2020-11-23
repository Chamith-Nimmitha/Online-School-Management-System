
<div class="col-12 fs-15 bg-darkblue  m-0 p-0  " >
	<div class="col-10 hmpg ">
		<ul>
			
  				<li class="float-left d-block p-3 "><a href="<?php echo set_url('homepage') ?>">Home</a></li>
  				<li class="float-left d-block p-3"><a href="<?php echo set_url('school/contact') ?>">Contact us</a></li>
  				<li class="hmpgactive float-left d-block p-3"><a href="<?php echo set_url('school/about') ?>">About</a></li>
  		
		</ul>
	</div>

</div>


<div class="bg-white mt-1 p-2 border b-rad">

<div class="m-1 p-2">
<h2>Brief history</h2>
</div>

<div class="text-justify border b-rad b-white m-2 p-2">
	<p><?php if(!empty($header)){echo $header['brief_history'];} ?></p>
</div>
</div>