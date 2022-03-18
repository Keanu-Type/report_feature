<?php
include_once '../indexphp/PHPBASEuserprofile.inc.php';
if (isset($_GET[''])){
  //BACK END FOR report page
}else{
  $data = "+639214942811";
  $sql = "SELECT * FROM register WHERE simnum =?;";
  $stmt = mysqli_stmt_init($conn);

  //connection error
  if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "SQL STATEMENT FAILED! try again later";
  }else{
    mysqli_stmt_bind_param($stmt,"s",$data);

    while($row = mysqli_fetch_assoc($result)){
//   Variable Name        Name of Column
//   in this website      in Database
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

    }
  }

}

?>
