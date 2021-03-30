
<div class="bg-white">

  <div class="row fs-15 bg-darkblue " >
    <div class="col-10 hmpg ">
      <ul>
          <li class="hmpgactive float-left d-block p-3 "><a href="<?php echo set_url('./index.php') ?>">Home</a></li>
          <li class="float-left d-block p-3"><a href="<?php echo set_url('school/contact') ?>">Contact us</a></li>
          <li class="float-left d-block p-3"><a href="<?php echo set_url('school/about') ?>">About</a></li>
      
      </ul>
    </div>
  </div>

  <img src="<?php if(!empty($header)){echo set_url('public/assets/img/').$header['background'];} ?>" alt="school" width=100% height=600px>



  <div class="row align-items-center justify-content-center m-3 t-20">

    <div class="col-11 p-1 justify-content-center align-items-end t-300">
      <div class="justify-content-center fs-30 fs-white m-0 p-2 sansserif">
        <h1>WELCOME to <?php if(!empty($header)){echo $header['name'];} ?></h1>
        <br>
      </div>

      <div class="col-9 justify-content-center  p-5 fs-20 border fs-white b-rad b-white text-justify couriernew">
        <p><?php if(!empty($header)){echo $header['welcome_message'];} ?></p>
      </div>

      <div class="col-3 m-2 p-4 border b-rad b-white fs-navyblue text-justify">
        <p class="fs-20"><b><u>Our Vision</u></b><br></p>
        <p class="fs-white"><br><?php if(!empty($header)){echo $header['vision'];} ?><br><br><br></p>
      </div>

      <div class="col-3  m-2 p-4  border b-rad b-white fs-navyblue text-justify">
        <p class="fs-20"><b><u>Our Mission</u></b><br></p>
        <p class="fs-white"><?php if(!empty($header)){echo $header['mission'];} ?><br><br></p>
      </div>

    </div>

  </div>


  <div class="row h-60 justify-content-center align-items-center">

    <div class="col-4 h-60 justify-content-center align-items-start bg-white hmpg-b-right">

      <div class="justify-content-center align-items-center sansserif">
        <h3>About <?php if(!empty($header)){echo $header['name'];} ?></h3>
      </div>
      
      <div class="justify-content-center align-items-center">
        <img src="<?php if(!empty($header)){echo set_url('public/assets/img/').$header['image'];} ?>" alt="school1" width=430px height=200px onClick="open_image_viewer(this)">
      </div>

      <div class="text-justify fs-14">
        <p><?php if(!empty($header)){echo $header['description'];} ?></p>
      </div>

    </div>


    <div class="col-4 h-60 d-block justify-content-center align-items-center bg-white hmpg-b-right">

      <div class="row justify-content-center align-items-center sansserif">
        <h3>Identity</h3>
      </div>

      <div class="row justify-content-center align-items-center ">
        <div class="col-5 border b-rad p-3 m-2">

          <div class="row justify-content-center align-items-center bg-navyblue1 fs-white">
            <p>School Badge</p>
          </div>

          <div class="row justify-content-center align-items-center mt-1">
            <img src="<?php if(!empty($header)){echo set_url('public/assets/img/').$header['badge'];} ?>" alt="scl" width=100px height=100px onClick="open_image_viewer(this)">
          </div>
        </div>

        <div class="col-5 border b-rad p-3 m-2">
          <div class="row justify-content-center align-items-center bg-navyblue1 fs-white">
            <p>School Flag</p>
          </div>

          <div class=" row justify-content-center align-items-center mt-1 ">
            <img src="<?php if(!empty($header)){echo set_url('public/assets/img/').$header['flag'];} ?>" alt="flag" width=100px height=100px onClick="open_image_viewer(this)">
          </div>
        </div>

        <div  class="d-block">
          <div class=" sansserif">
            <h3>Principal Message</h3>
          </div>

          <div class="d-block text-justify">
            <p><?php if(!empty($header)){echo $header['principal_message'];} ?></p>
          </div>
        </div>

      </div> 
    </div>

    <div class="col-4 h-60 justify-content-start align-items-start bg-white">
      
      <!-- ADD A NEW NOTICE -->
      <div id="add_new_school_notice" class="d-none">
        <div id="noticeboard_title" class="w-100">
          <!-- <button type="button" class="btn btn-blue p-1 ml-5" onclick="show_available_notice('add_new_classroom_notice','classroom_notice_board')">Back</button> -->
          <button type="button" class="btn btn-blue p-1 ml-5" onclick="location.reload()">Back</button>
          <h3>ADD NEW NOTICE</h3>
        </div>
        <div class="form-wrapper">
          <form method="POST" onSubmit="add_new_school_notice(this)">
            <p class="text-center" id="form_state"></p>
            <div class="form-group">
              <label for="text">Text</label>
              <textarea type="text" name="text" id="text" placeholder="Text"></textarea>
            </div>
            <div class="form-group">
              <label for="img">Image</label>
              <input type="file" name="img" id="img" placeholder="Image">
            </div>
            <div class="form-group">
              <label for="reference">Reference</label>
              <textarea name="reference" id="reference" class="w-100 p-2"  rows="2"></textarea>
            </div>
            <div class="w-100 d-flex justify-content-end">
              <input type="submit" value="Save" class="btn btn-blue">
            </div>
          </form>
        </div>
      </div>
      <!-- END OF ADD A NEW NOTICE -->

      <!-- UPDATE NOTICE -->
      <div id="update_school_notice" class="d-none">
        <div id="noticeboard_title" class="w-100">
          <!-- <button type="button" class="btn btn-blue p-1 ml-5" onclick="show_available_notice('update_classroom_notice','classroom_notice_board')">Back</button> -->
          <button type="button" class="btn btn-blue p-1 ml-5" onclick="location.reload()">Back</button>
          <h3>UPDATE NOTICE</h3>
          <a href="" class="btn btn-blue p-0 pr-2 pl-2 mr-2 mr-2" onclick="delete_school_notice(this,'Delete Message','Are you sure?')">Del</a>
        </div>
        <div class="form-wrapper">
          <form action="" method="POST" data-notice="" onSubmit="update_school_notice(this)">
            <p class="text-center" id="form_state"></p>
            <div class="form-group p-0 pr-2 pl-2">
              <label for="text">Text</label>
              <input type="text" name="text" id="text" placeholder="Text">
            </div>
            <div class="form-group  p-0 pr-2 pl-2">
              <label for="img">Image</label>
              <input type="file" name="img" id="img" placeholder="Image">
            </div>
            <div class="form-group  p-0 pr-2 pl-2">
              <label for="reference">Reference</label>
              <textarea name="reference" id="reference" class="w-100 p-2"  rows="2"></textarea>
            </div>
            <div class="w-100 d-flex justify-content-end">
              <input type="submit" value="Save" class="btn btn-blue">
            </div>
          </form>
        </div>
      </div>
      <!--END OF UPDATE NOTICE -->

      <div id="school_noticeboard" class="notice-board col-12 h-40 border b-rad bg-navyblue1 ">

        <div class="row justify-content-around align-items-start fs-white">
          <h3>School Notice Board</h3>
          <?php if($_SESSION['role'] == 'admin'){ ?>
            <div>
              <button class="btn btn-blue" onclick="add_new_school_notice_form('school_noticeboard','add_new_school_notice')">Add</button>
              <button class="btn btn-blue" onclick="update_school_notice_form('school_noticeboard','update_school_notice')">Update</button>
            </div>
          <?php } ?>
        </div>

          <?php

            for ($x = 0; $x < count($notices); $x++) {
              echo '        
              <div class="row notices h-30 " data-notice="'.$notices[$x]["id"].'">
                <div class="row">
                  <div class="col-6 h-30 fs-12 border b-rad bg-white ">
                    <div class="align-items-start justify-content-start text-justify" >
                       <p>';if(!empty($notices[$x]["text"])){echo $notices[$x]["text"];} echo '<br><br</p>
                    </div>

                    <div class="row align-items-end justify-content-end d-block" >
                      <p>Reference :&nbsp<a href=';if(!empty($notices[$x]["reference"])){echo $notices[$x]["reference"];} echo '>';if(!empty($notices[$x]["reference"])){echo $notices[$x]["reference"];} echo '</a></p>
                    </div>

                  </div>

                  <div class="col-6 h-30 fs-12 border b-rad bg-white  ">
                    <img src="'.set_url('public/assets/img/notice_images/'); if(!empty($notices[$x]["image"])){echo $notices[$x]["image"];}  echo '" alt="imgg" width=200px height=285px onClick="open_image_viewer(this)">

                  </div>

                </div>
              </div>';
            }
          ?>

          <div class="d-flex col-12 justify-content-between fs-white">
            <div class="p-2  "><a class="prev" onclick="plusNotices(-1)">&#10094;</a></div>

              <div class="p-2 ">
                <div class="row justify-content-center">

                  <?php
                  for ($x = 0; $x < count($notices); $x++) {
                      echo '<span class="dot m-2" onclick="currentNotice('.($x+1).')"></span>';
                      }
                  ?>
            </div>
            </div>

            <div class="p-2 "><a class="next" onclick="plusNotices(1)">&#10095;</a></div>
          </div>


        

        </div>


        <div class="row justify-content-center align-items-center sansserif">
        <h3><br><br>Follow Us On</h3>
      </div>

      <div class="row justify-content-center align-items-center">
      <div class="justify-content-left align-items-start">
        <a href="<?php if(!empty($header)){echo $header['fb_id'];} ?>"><img src="<?php echo set_url('public/assets/img/fb.png') ?>" alt="flag" width=40px height=40px></a>
        </div>

        <div class="justify-content-left align-items-start">
        <a href="<?php if(!empty($header)){echo $header['twitter_id'];} ?>"><img src="<?php echo set_url('public/assets/img/tw.png') ?>" alt="flag" width=40px height=40px></a>
        </div>

        <div class="justify-content-left align-items-start">
        <a href="<?php if(!empty($header)){echo $header['insta_id'];} ?>"><img src="<?php echo set_url('public/assets/img/in.png') ?>" alt="flag" width=40px height=40px></a>
        </div>

        <div class="justify-content-left align-items-start">
        <a href="<?php if(!empty($header)){echo $header['linkedin_id'];} ?>"><img src="<?php echo set_url('public/assets/img/li.png') ?>" alt="flag" width=40px height=40px></a>
        </div>

      </div>
<script type="text/javascript" src="<?php echo set_url('public/assets/js/noticeboard.js') ?>"></script>
    
      

      </div>

    </div>


</div>



</div>
