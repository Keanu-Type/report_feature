<?php
include_once "PHPBASEreported.inc.php";

if(isset($_POST['reportbutton'])){
  //FOR USER DETAILS
  //$Reporter_FName = mysqli_real_escape_string($conn, $_POST["$FirstName"]);
  //$Reporter_LName = mysqli_real_escape_string($conn, $_POST["$LastName"]);
  //$Reporter_MName = mysqli_real_escape_string($conn, $_POST["$MiddleName"]);
  $Reported_Num   = mysqli_real_escape_string($conn, $_POST['ReportedNumber']);
  $Message        = mysqli_real_escape_string($conn, $_POST['Remarks']);
  $Victim_Num     = mysqli_real_escape_string($conn, $_POST['VictimNumber']);
  //$Victim_Name    = $Reporter_FName . " ". $ReporterLName." ".$MName;
  $Victim_Name    = mysqli_real_escape_string($conn,$_POST['VictName']);


  //FOR IMAGE/SCREENSHOT DETAILS
  //getting the file
  $file = $_FILES['file'];
  //getting file details
  $fileName =$file["name"];
  $fileType =$file["type"];
  $fileTempName =$file["tmp_name"];
  $fileError =$file["error"];
  $fileSize =$file["size"];
  $Victim_Image_Name = str_replace(" ","-",$Victim_Name);

 //getting file E
  $fileExt = explode(".",$fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array("jpg","jpeg","png");


  if(empty($Victim_Name)||empty($Message)||empty($Reported_Num)||empty($Victim_Num)){
     header("Location: ../profile-user.php?reportPage&ReportStatus=empty"); //ERROR FOR EMPTY(ALL)
      exit();
     //NEEED TO FIND A WAY TO RECOGNIZE THIS AS CORRECT WITH A SPACE BETWEEN NAME
  }else{
    if(!preg_match("/^[a-zA-Z_ -]*$/", $Victim_Name)){
          header("Location:../profile-user.php?reportPage&ReportStatus=NameError");  //ERROR FOR INVALID NAMES (NAMES)
          exit();
     }else{
       //||!preg_match('/^[+]/',$Reported_Num)       //||!preg_match('/^[a-zA-Z]*$/',$VictimNum)      //!preg_match('/^[a-zA-Z]*$/',$Reported_Num)
          if(!preg_match("/[a-zA-Z +-]/",$Reported_Num)){   //ERROR FOR INVALID FORMAT(PHONE NUMBER)
              header("Location:../profile-user.php?reportPage&ReportStatus=InvalidFormat");  //ERROR FOR INVALID FORMAT(NUMBER)
              exit();
          }else{
              if(preg_match("/^[a-zA-Z_ -]*$/", $Reported_Num)){
                  header("Location:../profile-user.php?reportPage&ReportStatus=InvalidFormat");  //ERROR FOR INVALID FORMAT(NUMBER)
                  exit();
              }else{
/*ERROR*/
/*FOR */         if($fileSize==0){
/*IMAGES*/           header("Location:../profile-user.php?reportPage&ReportStatus=imageempty");  //ERROR FOR INVALID FORMAT(NUMBER)
                     exit();
                   }else{
                     if(in_array($fileActualExt,$allowed)){
                       if($fileError === 0){
                         if($fileSize<20000000){
                           //CHECKING HOW MANY ITEMS IN THE IMAGE DATABASE
                           $sql  = "SELECT * FROM report_detail;";
                           $stmt = mysqli_stmt_init($conn);
                           if(!mysqli_stmt_prepare($stmt,$sql)){
                                echo "SQL statement failed!";
                              }else{

                                mysqli_stmt_execute($stmt);
                                $result   = mysqli_stmt_get_result($stmt);
                                //Getting Database Row Information
                                $rowCount = mysqli_num_rows($result);
                                $setImageOrder   = $rowCount + 1;
                                //Reconfiguring Image File and Format;
                                $Name_ReportImage = $Victim_Image_Name."."."ReportNumber_".$setImageOrder; //example of format: TanishaBrown.ReportNumber_1
                                $ImageFullName    = $Name_ReportImage.".".$fileActualExt;             //example of format: TanishaBrown.ReportNumber_1.jpg
                                $fileDestination  = "../Image_Report_Database/".$ImageFullName;      //Save Location

                                //Preparing Query for the Data
                                $sql = "INSERT INTO report_detail(user_mobile_num, user_name, reported_number, remarks, Report_Screenshot, Report_ScreenshotName, Report_count)
                                        VALUES(?,?,?,?,?,?,?);";

                                if(!mysqli_stmt_prepare($stmt,$sql)){
                                  echo "SQL ERROR Line 79";
                                }else{
                                  //uploading the Data
                                  mysqli_stmt_bind_param($stmt,"sssssss",$Victim_Num,$Victim_Name,$Reported_Num,$Message,$ImageFullName,$Name_ReportImage,$rowCount);
                                  mysqli_stmt_execute($stmt);
                                  move_uploaded_file($fileTempName,$fileDestination);
                                  header("Location:../profile-user.php?reportPage&report=success");
                                }
                              }
                            }else{
                              echo "File is too large";
                              exit();
                            }
                          }else{
                            echo "an error occure when uploading ";
                            exit();
                          }
                     }else{
                       echo "Upload jpg/jpeg/png image only!";
                       exit();
                     }
                   } //line 60 end
                 } //line 55 end
               } //line 51 end
             } //line 46 end
           } //line 42 end
         }//line 9 end
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
