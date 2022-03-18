<?php
if(isset($_POST['submitscreenshot'])){


  //getting the file
  $file = $_FILES['file'];

  //getting file details
  $fileName =$file["name"];
  $fileType =$file["type"];
  $fileTempName =$file["tmp_name"];
  $fileError =$file["error"];
  $fileSize =$file["reportimagesize"];

  //get file extension detail (Exp: .jpg, .jpeg, .png)
  $fileExt = explode(".",$fileName); //note that this variable will become index. containing "file name" and "file type";
  $fileActualExt = strtolower(end($fileExt)); //end() grab last index in array.

  //set what are the allowed file format
  $allowed = array("jpg","jpeg","png");

  //ERROR HANDLERS
  //error type: if the extension is jpg, jpeg or png
  if(in_array($fileActualExt,$allowed)){
      //check if there is an error in file
      if($fileError === 0){
        //check if the file size is larger than 20Mb
        if($fileSize<20000){
          //image saving at Database
          $imageFullName = $newFileName.".".uniqid("",true).".".$fileActualExt; //wrapping up! ex: "Filename.randnumbers.jpg"
          $fileDestination = "../Image_Report_Database/".$imageFullName; //saving the file

          include_once "dbh.inc.ph";

        }
      }
  }

}
