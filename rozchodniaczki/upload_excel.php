<?php
	/*SECURED*/
    session_start();
	
	 function jump_to_page($mode,$top,$bottom) {
		echo $mode.' '.$top.' '.$bottom;
		$_SESSION['error'] = 'loadToast(\''.$mode.'\',\''.$top.'\',\''.$bottom.'\')';
		header('Location: ../panel_admina.php');
    }
	
	$folder_name = '../excel/';

	if(!empty($_FILES))
	{
	 $temp_file = $_FILES['file']['tmp_name'];
	 $location = $folder_name.$_FILES['file']['name'];
	 move_uploaded_file($temp_file, $location);
	}
?>