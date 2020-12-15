<?php

	//Target directory
	$file_dir= "";
	
   if(isset($_FILES['fileUpload'])){
	   
	  //Array of errors 
      $errors= array();
	  
	  //Target directory
	  $file_dir= "upload";
	  
	  //The uploaded file in the temporary directory on the web server
      $file_name = $_FILES['fileUpload']['name'];
	  
	  //The actual name of the uploaded file
      $file_size = $_FILES['fileUpload']['size'];
	  
	  //The size in bytes of the uploaded file
      $file_tmp = $_FILES['fileUpload']['tmp_name'];
	  
	  //The MIME type of the uploaded file
      $file_type = $_FILES['fileUpload']['type'];
	  
	  //Pull the file extension
      $file_ext=strtolower(end(explode('.',$_FILES['fileUpload']['name'])));
      
	  //Array of correct extensions
      $extensions= array("jpeg","jpg","png");
      
	  //Check if extension of file is in array, if not return error
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
	  //Return error if file to big
      if($file_size > 2097152) {
         $errors[]='File size must be excately 2 MB';
      }
	  
	  //Check if this file alredy exists
	  /*if (file_exists($file_dir.'/'.basename($target_name))) {
		$errors[]='File '.$file_name.' already exist in this catalog!';
	  }*/
      
	  //Upload image if no errors
      if(empty($errors)==true) {
		
		//If folder doesn't exist, then create			
		if (!file_exists($file_dir)) {
			echo("Folder ".$file_dir." created succesfully!");
			mkdir($file_dir, 0777, true);
		}
		 
		 //Uploading method 
         move_uploaded_file($file_tmp,$file_dir."/".$file_name);
		 unset($_POST);
         echo "Success upload file ".$file_name;
      }else{
         print_r($errors);
      }
   }
?>
<html>
   <body>
      
      <form action = "fileUpload.php" method = "POST" enctype = "multipart/form-data">
         <input type = "file" name = "fileUpload" />
         <input type = "submit"/>
			
         <ul>
            <li>Sent file: <?php echo $_FILES['fileUpload']['name'];  ?>
            <li>File size: <?php echo $_FILES['fileUpload']['size'];  ?>
            <li>File type: <?php echo $_FILES['fileUpload']['type'] ?>
         </ul>
		 
		 <?php 
		 
			
			if($file_dir != ""){
				if (is_dir_empty($file_dir)) {
				  echo "<hr><h2>The folder ".$file_dir." is empty</h2>"; 
				}else{
					
					$files = glob($file_dir."/*");

					echo '<hr><h2>Click picture to download it!</h2>';
					foreach($files as $files) {
						echo '<a href="'.$files.'" download><img width="300px" src="'.$files.'" /></a><br /><br />';
					}
				}
			}
			//Check if dir is empty
			function is_dir_empty($dir) {
			  if (!is_readable($dir)) return NULL; 
			  return (count(scandir($dir)) == 2);
			}
		 
			
		 ?>
			
      </form>
      
   </body>
</html>