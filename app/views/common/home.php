
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
        <img src="<?php if(!empty($header)){echo set_url('public/assets/img/').$header['image'];} ?>" alt="school1" width=430px height=200px>
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
            <p>Our badge</p>
          </div>

          <div class="row justify-content-center align-items-center mt-1">
            <img src="<?php if(!empty($header)){echo set_url('public/assets/img/').$header['badge'];} ?>" alt="scl" width=100px height=100px>
          </div>
        </div>

        <div class="col-5 border b-rad p-3 m-2">
          <div class="row justify-content-center align-items-center bg-navyblue1 fs-white">
            <p>Our Flag</p>
          </div>

          <div class=" row justify-content-center align-items-center mt-1 ">
            <img src="<?php if(!empty($header)){echo set_url('public/assets/img/').$header['flag'];} ?>" alt="flag" width=100px height=100px>
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
      
      <div class="notice-board col-12 h-40 border b-rad bg-navyblue1 ">

        <div class="row justify-content-center align-items-start fs-white">
          <h3>Notice Board</h3>
        </div>

          <?php
            if($rls_set){
              foreach ($rls_set as $data1) {
                $notice[$data1['id']."_text"] = $data1['text'];
                $notice[$data1['id']."_image"] = $data1['image'];
                $notice[$data1['id']."_reference"] = $data1['reference'];
              }
            }

            for ($x = 1; $x <= $notice["1000_text"]; $x++) {
              echo '        
              <div class="row notices h-30 ">
                <div class="row">
                  <div class="col-6 h-30 fs-12 border b-rad bg-white ">
                    <div class="align-items-start justify-content-start text-justify" >
                       <p>';if(!empty($notice[$x."_text"])){echo $notice[$x."_text"];} echo '<br><br</p>
                    </div>

                    <div class="row align-items-end justify-content-end d-block" >
                      <p>Reference :&nbsp<a href=';if(!empty($notice[$x."_reference"])){echo $notice[$x."_reference"];} echo '>';if(!empty($notice[$x."_reference"])){echo $notice[$x."_reference"];} echo '</a></p>
                    </div>

                  </div>

                  <div class="col-6 h-30 fs-12 border b-rad bg-white  ">
                    <img src="'.set_url('public/assets/img/notice_images/'); if(!empty($notice[$x."_image"])){echo $notice[$x."_image"];}  echo '" alt="imgg" width=200px height=285px>

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
                  for ($x = 1; $x <= $notice["1000_text"]; $x++) {
                      echo '<span class="dot m-2" onclick="currentNotice('.$x.')"></span>';
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
