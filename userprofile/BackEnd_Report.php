<?php
include_once "PHPBASEreported.inc.php";

if(isset($_POST['reportbutton'])){

  $Reported_Num   = mysqli_real_escape_string($conn, $_POST['ReportedNumber']);
  $Message        = mysqli_real_escape_string($conn, $_POST['Remarks']);


  ///////////////////////////////// GETTING END USER INFORMATION USING SESSION /////////////////////////////////
  session_start();
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

  $Victim_Name       = $LastName.$FirstName;
  $Victim_Image_Name = $LastName."-".$FirstName;
  $Victim_Num        = $SimCardNumber;
   ///////////////////////////////// GETTING IMAGE DETAILS  /////////////////////////////////
  //getting the file information into $file Array
  $file = $_FILES['file'];
  //getting file details
  $fileName =$file["name"];
  $fileType =$file["type"];
  $fileTempName =$file["tmp_name"]; //temporary name = current name of the file when uploaded to a website
  $fileError =$file["error"]; //if the file is working or not
  $fileSize =$file["size"];

  $allowed = array("jpg","jpeg","png");
  $fileExt = explode(".",$fileName); //getting file Extension and saving to $fileExt Array. file extension name is at the end of array
  $fileActualExt = strtolower(end($fileExt)); ////changing file extension name at the end of array, to lower case


 /////////////////////////////////////////////////// ERROR HANDLERS ////////////////////////////////////////
                             //////////////////////  TEXT ERRORS   /////////////////////
          if(empty($Reported_Num)){  //ERROR 404 for empty number
            header("Location: ../profile-user.php?reportPage&ReportStatus=empty");
            exit();
          }
          if(!preg_match("/[a-zA-Z +-]/",$Reported_Num)){   //ERROR 404 for lack of + plus
              header("Location:../profile-user.php?reportPage&ReportStatus=InvalidFormat");
              exit();
          }else{
              $zeroReported_Num = str_replace("+","",$Reported_Num); //remove "+"
              if(preg_match("/^[a-zA-Z_ -]*$/", $zeroReported_Num)){ // ERROR 404 for not being number
                  header("Location:../profile-user.php?reportPage&ReportStatus=InvalidFormat");
                  exit();
              }else{
                            //////////////////////  IMAGE ERRORS  /////////////////////
/*FOR */         if($fileSize==0){   //ERROR 404 for no file added
/*IMAGES*/           header("Location:../profile-user.php?reportPage&ReportStatus=imageempty");
                     exit();
                   }else{
                     if(in_array($fileActualExt,$allowed)){   //IF FILE IS JPG,PNG,JPEG
                       if($fileError === 0){                  //IF FILE HAS A PROBLEM
                         if($fileSize<20000000){              // IF FILE SIZE IS NOT LARGE

//////////////////////////////////////// INITIALIZING THE INPUTS TO DATABASE  ////////////////////////////////////////
                           //Check how many items are there in Database
                           $sql  = "SELECT * FROM report_detail;";
                           $stmt = mysqli_stmt_init($conn);
                           if(!mysqli_stmt_prepare($stmt,$sql)){  //ERROR 404 for connection database error
                                header("Location:../profile-user.php?reportPage&report=imagedatabaseerror");
                              }else{
                                mysqli_stmt_execute($stmt); //execute
                                $result   = mysqli_stmt_get_result($stmt);
                                //Getting Database Row Information
                                $rowCount = mysqli_num_rows($result);
                                $setImageOrder   = $rowCount + 1;  //getting how many rows and adding +1. that would be the for the image report

                                //////Reconfiguring Image File and Format////////
                                $Name_ReportImage = $Victim_Image_Name."."."ReportNumber_".$setImageOrder; //New File Name of the Image - example of format: TanishaBrown.ReportNumber_1
                                $ImageFullName    = $Name_ReportImage.".".$fileActualExt;                  //Complete Fille Name of the Image - example of format: TanishaBrown.ReportNumber_1.jpg
                                $fileDestination  = "../Image_Report_Database/".$ImageFullName;            //Build up file destination 

                                //Preparing Query for the Data
                                $sql = "INSERT INTO report_detail(user_mobile_num, user_name, reported_number, remarks, Report_Screenshot, Report_ScreenshotName, Report_count)
                                        VALUES(?,?,?,?,?,?,?);";

                                if(!mysqli_stmt_prepare($stmt,$sql)){
                                  header("Location:../profile-user.php?reportPage&report=uploaderror");
                                }else{
                                  //uploading the Data
                                  mysqli_stmt_bind_param($stmt,"sssssss",$Victim_Num,$Victim_Name,$Reported_Num,$Message,$ImageFullName,$Name_ReportImage,$rowCount);
                                  mysqli_stmt_execute($stmt);
                                  move_uploaded_file($fileTempName,$fileDestination);
                                  header("Location:../profile-user.php?reportPage&report=success");
                                }
                              }
                            }else{
                              header("Location:../profile-user.php?reportPage&report=imagelarge");
                              exit();
                            }
                          }else{
                            header("Location:../profile-user.php?reportPage&report=imageerror");
                            exit();
                          }
                     }else{
                         header("Location:../profile-user.php?reportPage&report=imageformaterror");
                       exit();
                     }
                   } //line 60 end
                 } //line 55 end
               } //line 51 end
             } //line 46 end
            //line 42 end
         //line 9 end
/*QUERY TO SEND DETAILS TO SQL
$sql  = "INSERT INTO report_details(user_mobile_num, user_name, reported_number,remarks) VALUES(?,?,?,?);";
$stmt = Mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    echo "Database Error. Please Try Again Later";
    exit();
}else{
     mysqli_stmt_bind_param($stmt,"ssss",$Victim_Num,$Victim_Name,$Reported_Num,$Message);
     mysqli_stmt_execute($stmt);
     header("Location:../profile-user.php?reportPage&ReportStatus=Success");
     exit();
} */

?>
