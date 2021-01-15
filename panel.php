<?php
	session_start();
	
	//Czy sesja istnieje, jeśli nie do logowania
	if (!isset($_SESSION['id_klienta'])){
		header('Location: logowanie.php');
		exit(0);
	}
	 
	//Czy wyświetlić error
	$error_msg = "";	
	if(isset($_SESSION['error'])){
		$error_msg = "onload=\"".$_SESSION['error']."\"";
		unset($_SESSION['error']);
	}
	
	//Zmienne w zależności od id_opcji i id_podopcji
	$page_info="Page info undefined";
	$page_header="Page info undefined";
	$page_location ="";
	
	//Odczyt opcji i podopcji z sesji
	$id_opcji = $_SESSION['id_opcji']; 
	$id_podopcji = $_SESSION['id_podopcji']; 
	$id_badania = $_SESSION['id_badania'];
	$badanie = "";
	
	//Przypisanie do zmiennych informacyjnych odpowiednich treści
	switch($id_podopcji){
		
		case 11:
			$page_info = "Profil użytkownika";
			$page_header = "Profil - RSS panel";
			$page_location = "szablony/uzytkownik/panel_profil.php";
		break;
		
		case 12:
			$page_info = "Profil użytkownika";
			$page_header = "Profil - RSS panel";
			$page_location = "szablony/uzytkownik/panel_profil.php";
			$error_msg = 'onload="loadToast(\'0\',\'Przekierowanie do profilu\',\'Panel ustawień oraz profilu zostały tymczasowo połączone ze względu na poprawienie przejrzystości strony.\')"';
		break;
		
		case 13:
			$page_info = "Kontakt";
			$page_header = "Kontakt - RSS panel";
			$page_location = "szablony/uzytkownik/panel_kontakt.php";
		break;
	
		case 14:
			$page_info = "Historia wagi";
			$page_header = "Waga - RSS panel";
			$page_location = "szablony/uzytkownik/wykres_wagi.php";
		break;
	
		case 15:
			$page_info = "Historia wzrostu";
			$page_header = "Wzrost - RSS panel";
			$page_location = "szablony/uzytkownik/wykres_wzrostu.php";
		break;
	
		default:
			switch ($id_opcji){
				
			case 1:
				$page_info = "Biofeedback EEG";
				$page_header = "Biofeedback EEG - RSS panel";
				$page_location = "szablony/uzytkownik/badanie.php";
				$badanie = "biofeedback_eeg";
				break;
				
			case 2: 
				$page_info = "Analiza składu ciała";
				$page_header = "Analiza składu ciała - RSS panel";
				$page_location = "szablony/uzytkownik/badanie.php";
				$badanie= "analiza_skladu_ciala";
				break;
				
			case 3: 
				if($_SESSION['id_podopcji'] == 1){
					
					$page_info = "Test szybkości";
					$page_header = "Test szybkości - RSS panel";
					$page_location = "szablony/uzytkownik/badanie.php";
					$badanie = "test_szybkosci";
				}
				elseif($_SESSION['id_podopcji'] == 2){
					
					$page_info = "Rast test";
					$page_header = "Rast test - RSS panel";
					$page_location = "szablony/uzytkownik/badanie.php";
					$badanie = "rast_test";
				}
				else{
					
					$page_info = "Prowadzenie piłki";
					$page_header = "Prowadzenie piłki - RSS panel";
					$page_location = "szablony/uzytkownik/badanie.php";
					$badanie = "prowadzenie_pilki";
				}
				break;
				
			case 4:
				$page_info = "Analizator kwasu mlekowego";
				$page_header = "Analizator kwasu mlekowego - RSS panel";
				$page_location = "szablony/uzytkownik/badanie.php";
				$badanie = "analizator_kwasu_mlekowego";
				break;
				
			case 5:
				$page_info = "Wzrostomierz";
				$page_header = "Wzrostomierz - RSS panel";
				$page_location = "szablony/uzytkownik/badanie.php";
				$badanie = "wzrostomierz";
				break;
				
			case 6:
				$page_info = "Beep test";
				$page_header = "Beep test - RSS panel";
				$page_location = "szablony/uzytkownik/badanie.php";
				$badanie = "beep_test";
				break;
				
			case 7:
				$page_info = "Opto jump next";
				$page_header = "Opto jump next - RSS panel";
				$page_location = "szablony/uzytkownik/badanie.php";
				$badanie = "opto_jump_next";
				break;
				
			default:
				$page_info = "How did we get here? Error 404";
				$page_header = "Error 404 - RSS panel";
				$page_location = "szablony/error_404.php";
			}
	}
	
	if($id_badania != -1){
		$page_location = "szablony/uzytkownik/szczegoly_".$badanie.".php";
	}
	
	//Podświetlanie aktualnie wybranej karty w bocznym menu
	function activateMenu($opcja, $podopcja){
		
		if($podopcja == "0"){
			if($opcja == $_SESSION['id_opcji']){
				
				if($opcja == 3){
					echo "open";
				}
				else{
					echo "open active";
				}
			}
		}
		elseif($podopcja == $_SESSION['id_podopcji']){
			if($opcja == $_SESSION['id_opcji']){
				echo "active";
			}
		}
	}
?>

<!DOCTYPE html>
<html class="loading" lang="pl" data-textdirection="ltr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="author" content="DeVision303" />
  <meta name="description" content="Official website of Real Science Sport" />
  
  <title><?php echo $page_header; ?></title>
  
  <!-- Ikony i animacje -->
  <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/logoCard.png">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700" rel="stylesheet">
  <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/ModernAdminCss/vendors.css">
  
  <!-- BEGIN MODERN CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/ModernAdminCss/app.css">

  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/ModernAdminCss/vertical-menu-modern.css">
  <link rel="stylesheet" type="text/css" href="app-assets/ModernAdminCss/palette-gradient.css">
  
  <!-- WŁASNE STYLE CSS -->
   <link rel="stylesheet" type="text/css" href="app-assets/ownCss.css">
   
   <!-- TOASTR PLUGIN -->
  <link rel="stylesheet" type="text/css" href="app-assets/ModernAdminCss/plugins/toastr.css">
  
  <!-- CHART.JS -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">
   
</head>


<body 
	class="vertical-layout vertical-menu-modern 2-columns menu-expanded fixed-navbar" 
	data-open="click" 
	data-menu="vertical-menu-modern" 
	data-col="2-columns"
	<?php echo $error_msg;?>	
>

	<?php
		//Dołączenie menu górnego i bocznego
		if (isset($_SESSION['id_klienta'])){
			include('szablony/uzytkownik/szablon_uzytkownika.php');
		}
		else{
			header('Location: logowanie.php');
		}
		
		//Wyświetlenie podglądu dla admina
		if(isset($_SESSION['id_admina'])){
			if(isset($_SESSION['imie_klienta']) && isset($_SESSION['nazwisko_klienta'])){
				echo '  
					<div class="admin_powrot">
						<h3>Przeglądasz jako:</br><b>'.$_SESSION['imie_klienta'].' '.$_SESSION['nazwisko_klienta'].'</b></h3>
						<a href="rozchodniaczki/admin/podglad_admina.php?wyjscie" class="btn btn-info btn-min-width">Powrót do panelu admina</a>
					</div>';
			}
		}
	?>

	<!-- GŁÓWNY KONTENER -->
	<div class="app-content content">
		<div class="content-wrapper">
			<!-- TU KONTENT AKTUALNEJ STRONY WEDŁUG SESJI -->
			<?php include($page_location);?>
		</div>
	</div>

	<!-- ////////////////////////////////////////////////////////////////////////////-->
  
	<!-- STOPKA -->
	<footer class="footer footer-static footer-light navbar-border navbar-shadow">
		<p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
		  <span class="float-md-left d-block d-md-inline-block">DeVision303 coding company</span>
		  <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block">Zaprojektowane i zakodowane z <i class="ft-heart pink"></i></span>
		</p>
	</footer>
  
	<script>
		var dane_badania = 
		<?php
			if(isset($dane_badania)){
				echo json_encode($dane_badania);}
			else{
				echo '\'nope\'';
			}
		?>;
	</script>
  
	<!-- BEGIN VENDOR JS-->
	<script src="app-assets/ModernAdminJs/vendors.min.js" type="text/javascript"></script>
	  
	<!-- BEGIN PAGE VENDOR JS-->
	<script src="app-assets/ModernAdminJs/moment.min.js" type="text/javascript"></script>

	<!-- BEGIN MODERN JS-->
	<script src="app-assets/ModernAdminJs/app-menu.js" type="text/javascript"></script>
	<script src="app-assets/ModernAdminJs/app.js" type="text/javascript"></script>
	<script src="app-assets/ModernAdminJs/customizer.js" type="text/javascript"></script>

	<!-- CHART.JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

	<!-- WŁASNE SKRYPTY JS-->
	<script src="app-assets/ownJs.js" type="text/javascript"></script>
	<script src="app-assets/charts.js" type="text/javascript"></script>
	<script src="https://kit.fontawesome.com/9b863fbae2.js"></script>
	  
	<!-- TOASTR PLUGIN -->
	<script src="app-assets/ModernAdminJs/toastrConfig.js" type="text/javascript"></script>
	<script src="app-assets/ModernAdminJs/toastrPlugin.js" type="text/javascript"></script>
  
</body>
</html>