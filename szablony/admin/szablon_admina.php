<?php
	/*SECURED*/
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}
	else{
		if(!isset($_SESSION['id_admina'])){
			header('Location: ../../logowanie.php');
		}
	}
?>

  <!-- BIAŁY MENU BAR -->
  <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
          <li class="nav-item mr-auto">
            <a class="navbar-brand" href="index.php">
              <img class="sideBar-logo-revieved admin_bar" alt="Real Science Sport logo" src="app-assets/images/logoWhite-admin.png">
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
              <a class="dropdown-toggle nav-link dropdown-user-link surNavBar" href="#">
                <span>Witaj,
                  <span class="text-bold-700"><?php  echo $_SESSION['imie']." ".$_SESSION['nazwisko']; ?></span>
                </span>
              </a>
            </li>
			
			<li class="dropdown dropdown-notification nav-item">
              <a class="dropdown-toggle nav-link dropdown-user-link nav-link-label iconsRss-admin" href="#" data-toggle="dropdown">
				<i class="ficon ft-user"></i>
              </a>
			  <div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item" href="rozchodniaczki/id_opcji.php?o=<?php echo $_SESSION['id_podopcji'];?>&p=11&b=-1"><i class="ft-user"></i>Pokaż profil</a>
				<a class="dropdown-item" href="rozchodniaczki/id_opcji.php?o=<?php echo $_SESSION['id_podopcji'];?>&p=12&b=-1"><i class="ft-settings"></i>Ustawienia</a>
                <div class="dropdown-divider"></div>
				<a class="dropdown-item" href="rozchodniaczki/wyloguj.php"><i class="ft-power"></i> Wyloguj</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  <!-- 	BOCZNE MENU -->
  <div class="main-menu main-menu-admin menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
	  
		<!--DODAJ BADANIA -->
		<li class="navigation-header">
          <span class="side_menu_divider" data-i18n="nav.category.ui">Dodaj wyniki badań</span><i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Dodaj wyniki badań"></i>
        </li>
		<li class="nav-item <?php echo activateMenu(1,0); ?>">
			<a href="rozchodniaczki/id_opcji.php?o=1&p=0&b=-1">
				<i class="fas fa-brain"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Biofeedback EEG</span>
			</a>
		</li>
		<li class="nav-item <?php echo activateMenu(2,0); ?>">
			<a href="rozchodniaczki/id_opcji.php?o=2&p=0&b=-1"">
				<i class="fas fa-weight"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Analiza składu ciała</span>
			</a>
		</li>
		<li class="nav-item has-sub"><a href="#"><i class="la la-rocket"></i><span class="menu-title" data-i18n="nav.event_calendars.main">Fotokomórki</span></a>
		  <ul class="menu-content" style="height: 120px; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px; overflow: hidden;">
			<ul class="menu-content" style="">
			
			<li class='is-shown <?php echo activateMenu(3,1); ?>'><a class='menu-item' href='rozchodniaczki/id_opcji.php?o=3&p=1&b=-1'>Test szybkości</a></li>
			
				<li class='is-shown <?php echo activateMenu(3,2); ?>'><a class='menu-item' href='rozchodniaczki/id_opcji.php?o=3&p=2&b=-1'>Rast test</a></li>
			
				<li class='is-shown <?php echo activateMenu(3,3); ?>'><a class='menu-item' href='rozchodniaczki/id_opcji.php?o=3&p=3&b=-1'>Prowadzenia piłki</a></li>
			</ul>
		  </ul>
		</li>

		<li class="nav-item <?php echo activateMenu(4,0); ?>">
			<a href="rozchodniaczki/id_opcji.php?o=4&p=0&b=-1">
				<i class="ft-bar-chart"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Analizator kwasu mlekowego</span>
			</a>
		</li>
		<li class="nav-item <?php echo activateMenu(5,0); ?>">
			<a href="rozchodniaczki/id_opcji.php?o=5&p=0&b=-1">
				<i class="fas fa-ruler-vertical"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Wzrostomierz</span>
			</a>
		</li>
		<li class="nav-item <?php echo activateMenu(6,0); ?>">
			<a href="rozchodniaczki/id_opcji.php?o=6&p=0&b=-1">
				<i class="ft-activity"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Beep test</span>
			</a>
		</li>
		<li class="nav-item <?php echo activateMenu(7,0); ?>">
			<a href="rozchodniaczki/id_opcji.php?o=7&p=0&b=-1">
				<i class="fas fa-stopwatch-20"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Opto jump next</span>
			</a>
		</li>
		<!--KLIENCI-->
		<li class="navigation-header">
          <span class="side_menu_divider" data-i18n="nav.category.ui">Zarządzaj klientami</span><i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Zarządzaj klientami"></i>
        </li>
		<li class="nav-item <?php echo activateMenu(101,0); ?>">
			<a href="rozchodniaczki/id_opcji.php?o=101&p=0&b=-1">
				<i class="ft-user"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Klienci</span>
			</a>
		</li>
		<li class="nav-item <?php echo activateMenu(102,0); ?>">
			<a href="rozchodniaczki/id_opcji.php?o=102&p=0&b=-1">
				<i class="ft-users"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Kluby</span>
			</a>
		</li>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
