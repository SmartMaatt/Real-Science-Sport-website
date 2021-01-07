<?php
	session_start();
	
	//Czy sesja istnieje, jeśli nie do logowania
	 if (!isset($_SESSION['id_klienta'])){
		 header('Location: logowanie.php');
	 }
	 
	//Czy wyświetlić error
	$error_msg = "";	
	if(isset($_SESSION['error'])){
		$error_msg = "onload=\"".$_SESSION['error']."\"";
		unset($_SESSION['error']);
	}
	
	require_once 'rozchodniaczki/connect.php';
	
	 // if(isset($_POST['global_date']))
	 // {
		 // $_SESSION['data'] = $_POST['global_date'];
	 // }
	
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
	if($id_podopcji == 11)
	{
		$page_info = "Profil użytkownika";
		$page_header = "Profil - RSS admin";
		$page_location = "szablony/uzytkownik/panel_profil.php";
	}
	elseif($id_podopcji == 12)
	{
		$page_info = "Profil użytkownika";
		$page_header = "Profil - RSS admin";
		$page_location = "szablony/uzytkownik/panel_profil.php";
		$error_msg = 'onload="loadToast(\'0\',\'Przekierowanie do profilu\',\'Panel ustawień oraz profilu zostały tymczasowo połączone ze względu na poprawienie przejrzystości strony.\')"';
	}
	elseif($id_podopcji == 13)
	{
		$page_info = "Kontakt";
		$page_header = "Kontakt - RSS admin";
		$page_location = "szablony/uzytkownik/panel_kontakt.php";
	}
	elseif($id_opcji  == 1)
	{
		$page_info = "Biofeedback EEG";
		$page_header = "Biofeedback EEG - RSS admin";
		$page_location = "szablony/admin/dodaj_biofeedback_eeg.php";
	}
	elseif($id_opcji  == 2) 
	{
		$page_info = "Analiza składu ciała";
		$page_header = "Analiza składu ciała - RSS admin";
		$page_location = "szablony/admin/dodaj_analiza_skladu_ciala.php";
	}
	elseif($id_opcji  == 3) 
	{
		if($_SESSION['id_podopcji'] == 1)
		{
			$page_info = "Test szybkości";
			$page_header = "Test szybkości - RSS admin";
			$page_location = "szablony/admin/dodaj_test_szybkosci.php";
		}
		elseif($_SESSION['id_podopcji'] == 2)
		{
			$page_info = "Rast test";
			$page_header = "Rast test - RSS admin";
			$page_location = "szablony/admin/dodaj_rast_test.php";
		}
		else
		{
			$page_info = "Prowadzenie piłki";
			$page_header = "Prowadzenie piłki - RSS admin";
			$page_location = "szablony/admin/dodaj_prowadzenie_pilki.php";
		}
	}
	elseif($id_opcji  == 4)
	{
		$page_info = "Analizator kwasu mlekowego";
		$page_header = "Analizator kwasu mlekowego - RSS admin";
		$page_location = "szablony/admin/dodaj_analizator_kwasu_mlekowego.php";
	}
	elseif($id_opcji  == 5)
	{
		$page_info = "Wzrostomierz";
		$page_header = "Wzrostomierz - RSS admin";
		$page_location = "szablony/admin/dodaj_wzrostomierz.php";
	}
	elseif($id_opcji  == 6)
	{
		$page_info = "Beep test";
		$page_header = "Beep test - RSS admin";
		$page_location = "szablony/admin/dodaj_deep_test.php";
	}
	elseif($id_opcji  == 7)
	{
		$page_info = "Opto jump next";
		$page_header = "Opto jump next - RSS admin";
		$page_location = "szablony/admin/dodaj_opto_jump_next.php";
	}
	elseif($id_opcji  == 101)
	{
		$page_info = "Wyświetl klientów";
		$page_header = "Klienci - RSS admin";
		$page_location = "szablony/admin/pokaz_klientow.php";
	}

	//Podświetlanie aktualnie wybranej karty w bocznym menu
	function activateMenu($opcja, $podopcja) {
		
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

	if (isset($_SESSION['id_admina'])) {
		
		include('szablony/admin/szablon_admina.php');
	}
	else
		header('Location: logowanie.php');
	?>

	<!-- GŁÓWNY KONTENER -->
  <div class="app-content content">
    <div class="content-wrapper">
	
		<!-- TU KONTENT AKTUALNEJ STRONY WEDŁUG SESJI -->
	<?php
		include($page_location);
	?>

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
  
  <script>var dane_badania = 
	<?php
		if(isset($dane_badania) && $id_badania != -1){
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