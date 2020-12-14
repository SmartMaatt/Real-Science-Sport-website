<!DOCTYPE html>
<html class="loading" lang="pl" data-textdirection="ltr">
<?php
	session_start();

	$page_info="Page info undefined";

	 if (!isset($_SESSION['id_klienta'])) 
	 {
		 header('Location: logowanie.php');
	 }
	
	 // if(isset($_POST['global_date']))
	 // {
		 // $_SESSION['data'] = $_POST['global_date'];
	 // }
	 
	if($_SESSION['id_opcji'] == 1) $page_info = "Info karta 1";
	elseif($_SESSION['id_opcji'] == 2) $page_info = "Info karta 2";
	elseif($_SESSION['id_opcji'] == 3) $page_info = "Info karta 3";
	elseif($_SESSION['id_opcji'] == 3) $page_info = "Info karta 4";
	elseif($_SESSION['id_opcji'] == 3) $page_info = "Info karta 5";
	elseif($_SESSION['id_opcji'] == 3) $page_info = "Info karta 6";
	elseif($_SESSION['id_opcji'] == 3) $page_info = "Info karta 7";
 
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
   <meta name="author" content="DeVision303" />
  <meta name="description" content="Official website of Real Science Sport" />
  
  <!--TUTAJ PHP!!! -->
  <title>Rezerwacje - Wysokiej klasy kręgielnia</title>
  
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
   
</head>


<body 
	class="vertical-layout vertical-menu-modern 2-columns menu-expanded fixed-navbar" 
	data-open="click" 
	data-menu="vertical-menu-modern" 
	data-col="2-columns" 
	<?php
		if (isset($_SESSION['correct_reservation']))
		{
			if($_SESSION['correct_reservation'])
			{
				echo "onload=\"infoCardDataBase('Dokonano rezerwacji', ".$_SESSION['correct_reservation'].")\"";
			}
			else
			{
				echo "onload=\"infoCardDataBase('Nie udało się dokonać rezerwacji', ".$_SESSION['correct_reservation'].")\"";
			}
			unset($_SESSION['correct_reservation']);
		}
	?>
>

  <!-- BIAŁY MENU BAR -->
  <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
          <li class="nav-item mr-auto">
            <a class="navbar-brand" href="index.php">
              <img class="sideBar-logo-revieved" alt="Real Science Sport logo" src="app-assets/images/logoWhite.png">
            </a>
          </li>
          <li class="nav-item d-none d-md-block float-right"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="toggle-icon ft-toggle-right font-medium-3 white" data-ticon="ft-toggle-right"></i></a></li>
          <li class="nav-item d-md-none">
            <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
          </li>
        </ul>
      </div>
      <div class="navbar-container content">
        <div class="collapse navbar-collapse text-center" id="navbar-mobile">
          <h3 class="content-header-title mb-0 d-inline-block"> 
				<?php echo "$page_info" ?>
			</h3>
          <ul class="nav navbar-nav ml-auto float-right">
            <li class="dropdown dropdown-user nav-item">
              <a class="dropdown-toggle nav-link dropdown-user-link surNavBar" href="#" data-toggle="dropdown">
                <span>Witaj,
                  <span class="text-bold-700"><?php  echo $_SESSION['imie']." ".$_SESSION['nazwisko']; ?></span>
                </span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item" href="#"><i class="ft-user"></i>Pokaż profil</a>
                <div class="dropdown-divider"></div><a class="dropdown-item" href="rozchodniaczki/wyloguj.php"><i class="ft-power"></i> Wyloguj</a>
              </div>
            </li>
            <li class="dropdown dropdown-notification nav-item">
              <a class="nav-link nav-link-label iconsRss" href="ustawienia.php"><i class="ficon ft-settings"></i>
              </a>
            </li>
            <li class="dropdown dropdown-notification nav-item">
              <a class="nav-link nav-link-label iconsRss" href="#" data-toggle="dropdown"><i class="ficon ft-mail"></i></a>
             
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  <!-- 	BOCZNE MENU -->
  <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
	  
		<!--TWOJE BADANIA -->
		<li class="navigation-header">
          <span data-i18n="nav.category.ui">Twoje badania</span><i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Twoje badania"></i>
        </li>
		<li class="nav-item active"><a href="#">
			<i class="fas fa-brain"></i>
			<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Biofeedback EEG</span></a>
        </li>
		<li class="nav-item"><a href="#">
			<i class="fas fa-weight"></i>
			<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Analiza składu ciała</span></a>
        </li>
	   <li class="nav-item has-sub"><a href="#"><i class="la la-rocket"></i><span class="menu-title" data-i18n="nav.event_calendars.main">Fotokomórki</span></a>
          <ul class="menu-content" style="height: 122.297px; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px; overflow: hidden;">
            <ul class="menu-content" style="">
			<li class='is-shown'><a class='menu-item' href='rozchodniaczki/id_opcji1.php'>Test szybkości</a></li>
			<li class='is-shown'><a class='menu-item' href='rozchodniaczki/id_opcji2.php'>Rast test</a></li>
			<li class='is-shown'><a class='menu-item' href='rozchodniaczki/id_opcji3.php'>Prowadzenia piłki</a></li>
            </ul>
          </ul>
        </li>
		<li class="nav-item"><a href="#">
			<i class="ft-bar-chart"></i>
			<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Analizator kwasu mlekowego</span></a>
        </li>
		<li class="nav-item"><a href="#">
			<i class="fas fa-ruler-vertical"></i>
			<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Wzrostomierz</span></a>
        </li>
		<li class="nav-item"><a href="#">
			<i class="ft-activity"></i>
			<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Beep test</span></a>
        </li>
		<li class="nav-item"><a href="#">
			<i class="fas fa-stopwatch-20"></i>
			<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Opto jump next</span></a>
        </li>
		
		
		
		<!--DOSTĘPNE BADANIA -->
		<li class="navigation-header">
          <span data-i18n="nav.category.ui">Dostępne badania</span><i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Dostępne badania"></i>
        </li>
		<li class="nav-item active"><a href="#">
			<i class="fas fa-brain"></i>
			<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Biofeedback EEG</span></a>
        </li>
		<li class="nav-item"><a href="#">
			<i class="fas fa-weight"></i>
			<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Analiza składu ciała</span></a>
        </li>
	   <li class="nav-item has-sub"><a href="#"><i class="la la-rocket"></i><span class="menu-title" data-i18n="nav.event_calendars.main">Fotokomórki</span></a>
          <ul class="menu-content" style="height: 122.297px; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px; overflow: hidden;">
            <ul class="menu-content" style="">
			<li class='is-shown'><a class='menu-item' href='rozchodniaczki/id_opcji1.php'>Test szybkości</a></li>
			<li class='is-shown'><a class='menu-item' href='rozchodniaczki/id_opcji2.php'>Rast test</a></li>
			<li class='is-shown'><a class='menu-item' href='rozchodniaczki/id_opcji3.php'>Prowadzenia piłki</a></li>
            </ul>
          </ul>
        </li>
		<li class="nav-item"><a href="#">
			<i class="ft-bar-chart"></i>
			<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Analizator kwasu mlekowego</span></a>
        </li>
		<li class="nav-item"><a href="#">
			<i class="fas fa-ruler-vertical"></i>
			<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Wzrostomierz</span></a>
        </li>
		<li class="nav-item"><a href="#">
			<i class="ft-activity"></i>
			<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Beep test</span></a>
        </li>
		<li class="nav-item"><a href="#">
			<i class="fas fa-stopwatch-20"></i>
			<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Opto jump next</span></a>
        </li>
      </ul>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  <!-- GŁÓWNY KONTENER -->
  <div class="app-content content">
    <div class="content-wrapper">
      
      </div>
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
  
  <!-- POJEMNIK POWIADOMIEŃ -->
  <div id="ICC">	
  </div>
  
  <!-- BEGIN VENDOR JS-->
  <script src="app-assets/ModernAdminJs/vendors.min.js" type="text/javascript"></script>
  
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="app-assets/ModernAdminJs/moment.min.js" type="text/javascript"></script>

  <!-- BEGIN MODERN JS-->
  <script src="app-assets/ModernAdminJs/app-menu.js" type="text/javascript"></script>
  <script src="app-assets/ModernAdminJs/app.js" type="text/javascript"></script>
  <script src="app-assets/ModernAdminJs/customizer.js" type="text/javascript"></script>

	<!-- WŁASNE SKRYPTY JS-->
  <script src="app-assets/ownJs.js" type="text/javascript"></script>
  <script src="https://kit.fontawesome.com/9b863fbae2.js"></script>
  
</body>
</html>