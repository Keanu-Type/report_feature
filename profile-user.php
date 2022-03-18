<?php
  require "navbar.php";
  include_once 'indexphp/PHPBASEuserprofile.inc.php';

  $SimCardNumber = $_SESSION['UserNumber'] ;
  $LastName      = $_SESSION['UserLast']  ;
  $FirstName     = $_SESSION['UserFirst']  ;
  $Gender        = $_SESSION['UserGender']  ;
  $Birthdate     = $_SESSION['UserBirthdate'];
  $Address       = $_SESSION['UserAddress']  ;
  $Nationality   = $_SESSION['UserNationality'];
  $TypeofUser    = $_SESSION['UserType'] ;
  $DateofRegist  = $_SESSION['UserDatReg'];
  $TimeofReg     = $_SESSION['UserTimeReg'];
  $RegSite       = $_SESSION['UserRegSite'] ;
  $SimCard       = $_SESSION['UserSimCard']  ;
?>


<!-- BODY PART -->
<div class="container">
  <?php
    if (isset($_GET['reportPage'])) {
      echo " <div class='row header'>
      <h2>Report a malicious number</h2>
    </div>
    <div class='row'>
      <div class='col-md-6 iconn'>
        <!-- COLUMN 1 -->
        <form class='' id='form' action='userprofile/BackEnd_Report.php' method='post' enctype='multipart/form-data'>
          <div class='infodiv1'>
            <p class='labelings'>Name</p>
            <input type='text' name='VictName' value='$FirstName $LastName' id='usernamee' class='form-control' required>

          </div>

          <div class='infodiv1'>
            <p class='labelings'>Your Mobile Number</p>
            <input type='tel' name='VictimNumber' value='$SimCardNumber' id='yourNumber' class='form-control' placeholder='' required>

          </div>

          <div class='infodiv1'>
            <p class='labelings'>Mobile Number to be reported</p>
            <input type='tel' name='ReportedNumber' value='' id='reportedMobilenumber' class='form-control' placeholder='Enter number that need to be reported here' required>

          </div>
            <button type='submit' name='reportbutton' class='send-btn'>Send</button>
        <!-- </form> -->


      </div>
      <div class='col-md-6 textclass'>
        <!-- TEXTAREA COLUMN 2 -->

          <div class='infodiv1'>
            <p class='labelings'>Remarks</p>
            <textarea id='textArea' class='form-control' name='Remarks' rows='9' cols='80' required></textarea>
          </div>

            <button type='submit' name='submit' class='ss-btn upload-btn-wrapper'>
              <input type='file' name='file'>Submit Screenshot of Message</button>                       <!-- SUBMIT BUTTON FOR SCREENSHOT -->

        <!-- </form> -->
        </div>

        </form>

    </div>
    ";
    $fulUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if (strpos($fulUrl,"profile-user.php?reportPage&ReportStatus=InvalidFormat") == true){
        echo "<p class= 'errormessage' style='color:#FF0000'> Incorrect Phone Number Format. please use +63 format and enter phone number only</p>";
    }elseif(strpos($fulUrl,"profile-user.php?reportPage&ReportStatus=empty") == true){
        echo "<p class= 'errormessage' style='color:#FF0000'> Empty fields detected. please fill up all fields!</p>";
    }elseif(strpos($fulUrl,"profile-user.php?reportPage&ReportStatus=empty") == true){
        echo "<p class= 'errormessage' style='color:#FF0000'> Empty fields detected. please fill up all fields!</p>";
    };
  ;
  } else {

//REPORT PAGE
    echo "
    <form class='' id='form' action='userprofile/Back_End_User_Profile.php' method='POST'>
    <div class='row'>

      <div class='col-md-4 infocol1'>
        <!-- INFO COLUMN 1 -->

        <div class='infodiv'>
          <p class='labelings'>Name</p>
          <p class='information'>$FirstName  $LastName</p>
        </div>

        <div class='infodiv'>
          <p class='labelings'>Gender</p>
          <p class='information'>$Gender</p>
        </div>

        <div class='infodiv'>
          <p class='labelings'>Birthdate</p>
          <p class='information'>$Birthdate</p>
        </div>

        <div class='infodiv'>
          <p class='labelings'>Address</p>
          <p class='information'>$Address</p>
        </div>



        <div class='infodiv'>
          <p class='labelings'>Nationality</p>
          <p class='information'>$Nationality</p>
        </div>

      </div>

      <div class='col-md-4 infocol2'>
        <!-- INFO COLUMN 2 -->
        <div class='infodiv'>
          <p class='labelings'>Sim Card Number</p>
          <p class='information'>$SimCardNumber</p>
        </div>

        <div class='infodiv'>
          <p class='labelings'>Type of User</p>
          <p class='information'>$TypeofUser</p>
        </div>

        <div class='infodiv'>
          <p class='labelings'>Date of Registration</p>
          <p class='information'>$DateofRegist</p>
        </div>

        <div class='infodiv'>
          <p class='labelings'>Time of Registration</p>
          <p class='information'>$TimeofReg</p>
        </div>

        <div class='infodiv'>
          <p class='labelings'>Registration Site</p>
          <p class='information'>$RegSite</p>
        </div>
      </div>

      <div class='col-md-4 infocol3'>
        <div class='infodiv'>
          <p class='labelings'>Sim Card</p>
          <p class='information'>$SimCard</p>
        </div>
      </div>
    </div>
    </form>";
  }
  ?>

</div>

<!-- end of body -->
<!--if (isset($_GET[''])){
  //BACK END FOR report page
}else{
  $data = "+639014940000";  //SESSION DATA
  $sql = "SELECT * FROM register WHERE simnum =?;";
  $stmt = mysqli_stmt_init($conn);

  //connection error
  if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "SQL STATEMENT FAILED! try again later";
  }else{
    mysqli_stmt_bind_param($stmt,"s",$data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($result)){
//   Variable Name        Name of Column
//   in this website      in Database
      $FirstName     =  $row['firstname'];
      $LastName      =  $row['lastname'];
      $MiddleName    =  $row['middlename'];
      $Gender        =  $row['gender'];
      $Birthdate     =  $row['datebirth'];
      $Address       =  $row['address'];
      $Nationality   =  $row['nationality'];
      $SimCardNumber =  $row['simnum'];
      $TypeofUser    =  $row['nationality'];
      $TimeofReg     =  $row['time'];
      $DateofRegist  =  $row['dateofregis'];
      $RegSite       =  $row['regisite'];
      $SimCard       =  $row['simcard'];

    }
  }

}
-->
  </body>
</html>
