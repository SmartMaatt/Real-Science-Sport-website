<?php
	/*SECURED*/
	session_start();
	
	function jump_to_page($mode,$top,$bottom) {
		$_SESSION['error'] = 'loadToast(\''.$mode.'\',\''.$top.'\',\''.$bottom.'\')';
    }

	//[#1] Pliki przekazane do wysyłki
	if(!empty($_FILES)){
		
		//Odczyt parametrów
		$file = $_FILES['file'];
		$fileName = $_FILES['file']['name'];
		$fileTmpName = $_FILES['file']['tmp_name'];
		$fileSize = $_FILES['file']['size'];
		$fileError = $_FILES['file']['error'];
		$fileType = $_FILES['file']['type'];
		 
		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));
		$allowed = array('xlsx');
	 
		//Sprawdzenie poprawności
		if(in_array($fileActualExt, $allowed)){
			
			if($fileError === 0){
				
				if($fileSize < 500000){
					
					$fileNameNew = uniqid('', true).'.'.$fileActualExt;
					$fileDestination = '../../excel/tmp/'.$fileNameNew;
					$fileDestinationForExcel = 'tmp/'.$fileNameNew;
					
					$_SESSION['excel_plik'] = $fileDestinationForExcel;
					jump_to_page('0', 'Plik '.$fileName.' został przesłany!',''); 
					
					move_uploaded_file($fileTmpName,$fileDestination);
				}
				//Zabezpieczenie przed wielkością pliku
				else {
					jump_to_page('3', 'Bez przesady! Plik '.$fileName.' ma ponad 500Mb!',''); 
				}
			}
			//Wystąpił błąd podczas wysyłania pliku
			else {
				jump_to_page('3', 'Wysyłanie pliku '.$fileName.' nie powiodło się!',''); 
			}
		}
		//Podano plik inny niż excel
		else{
			jump_to_page('3', 'Plik nie posiada rozszerzenia .xlsx !',''); 
		}
	 
	}
	//[2] Pliki przygotowane, wysyłka do algorytmu
	elseif(isset($_SESSION['excel_plik']))
	{
		if(isset($_POST['badanie'])){
			
			echo $_POST['badanie'];
			echo $_SESSION['excel_plik'];
			header('Location: ../../excel/excel_'.$_POST['badanie'].'.php');
		}
		else{
			//Plik wywołany z nieznanego punktu
			jump_to_page('3','Nieupoważnione wejście do pliku upload_excel.php!',''); 
			header('Location: ../../panel_admina.php');	
		}
	}
	//Podczas przetwarzania plików nastąpił błąd
	elseif(isset($_SESSION['error'])){
		
		header('Location: ../../panel_admina.php');
	}
	else{	
	
		jump_to_page('3', 'Sprawdź czy wrzucany plik jest zamknięty!',''); 
		header('Location: ../../panel_admina.php');
	}
?>