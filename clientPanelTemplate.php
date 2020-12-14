

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
		<li class="nav-item <?php activateMenu("1","0"); ?>">
			<a href="#" onclick="nowaOpcja(1,0)">
				<i class="fas fa-brain"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Biofeedback EEG</span>
			</a>
        </li>
		<li class="nav-item <?php activateMenu("2","0"); ?>">
			<a href="#" onclick="nowaOpcja(2,0)">
				<i class="fas fa-weight"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Analiza składu ciała</span>
			</a>
        </li>
	   <li class="nav-item has-sub <?php activateMenu("3","0"); ?>"><a href="#"><i class="la la-rocket"></i><span class="menu-title" data-i18n="nav.event_calendars.main">Fotokomórki</span></a>
          <ul class="menu-content" style="height: 122.297px; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px; overflow: hidden;">
            <ul class="menu-content" style="">
			<li class='is-shown <?php activateMenu("3","1"); ?>'><a onclick="nowaOpcja(3,1)" class='menu-item' href='#'>Test szybkości</a></li>
			<li class='is-shown <?php activateMenu("3","2"); ?>'><a onclick="nowaOpcja(3,2)" class='menu-item' href='#'>Rast test</a></li>
			<li class='is-shown <?php activateMenu("3","3"); ?>'><a onclick="nowaOpcja(3,3)" class='menu-item' href='#'>Prowadzenia piłki</a></li>
            </ul>
          </ul>
        </li>
		<li class="nav-item <?php activateMenu("4","0"); ?>">
			<a href="#" onclick="nowaOpcja(4,0)">
				<i class="ft-bar-chart"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Analizator kwasu mlekowego</span>
			</a>
        </li>
		<li class="nav-item <?php activateMenu("5","0"); ?>">
			<a href="#" onclick="nowaOpcja(5,0)">
				<i class="fas fa-ruler-vertical"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Wzrostomierz</span>
			</a>
        </li>
		<li class="nav-item <?php activateMenu("6","0"); ?>">
			<a href="#" onclick="nowaOpcja(6,0)">
				<i class="ft-activity"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Beep test</span>
			</a>
        </li>
		<li class="nav-item <?php activateMenu("7","0"); ?>">
			<a href="#" onclick="nowaOpcja(7,0)">
				<i class="fas fa-stopwatch-20"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Opto jump next</span>
			</a>
        </li>
		
		
		
		<!--DOSTĘPNE BADANIA -->
		<li class="navigation-header">
          <span data-i18n="nav.category.ui">Dostępne badania</span><i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Dostępne badania"></i>
        </li>
		<li class="nav-item <?php activateMenu("1","0"); ?>">
			<a href="#" onclick="nowaOpcja(1,0)">
				<i class="fas fa-brain"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Biofeedback EEG</span>
			</a>
        </li>
		<li class="nav-item <?php activateMenu("2","0"); ?>">
			<a href="#" onclick="nowaOpcja(2,0)">
				<i class="fas fa-weight"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Analiza składu ciała</span>
			</a>
        </li>
	   <li class="nav-item has-sub <?php activateMenu("3","0"); ?>"><a href="#"><i class="la la-rocket"></i><span class="menu-title" data-i18n="nav.event_calendars.main">Fotokomórki</span></a>
          <ul class="menu-content" style="height: 122.297px; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px; overflow: hidden;">
            <ul class="menu-content" style="">
			<li class='is-shown <?php activateMenu("3","1"); ?>'><a onclick="nowaOpcja(3,1)" class='menu-item' href='#'>Test szybkości</a></li>
			<li class='is-shown <?php activateMenu("3","2"); ?>'><a onclick="nowaOpcja(3,2)" class='menu-item' href='#'>Rast test</a></li>
			<li class='is-shown <?php activateMenu("3","3"); ?>'><a onclick="nowaOpcja(3,3)" class='menu-item' href='#'>Prowadzenia piłki</a></li>
            </ul>
          </ul>
        </li>
		<li class="nav-item <?php activateMenu("4","0"); ?>">
			<a href="#" onclick="nowaOpcja(4,0)">
				<i class="ft-bar-chart"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Analizator kwasu mlekowego</span>
			</a>
        </li>
		<li class="nav-item <?php activateMenu("5","0"); ?>">
			<a href="#" onclick="nowaOpcja(5,0)">
				<i class="fas fa-ruler-vertical"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Wzrostomierz</span>
			</a>
        </li>
		<li class="nav-item <?php activateMenu("6","0"); ?>">
			<a href="#" onclick="nowaOpcja(6,0)">
				<i class="ft-activity"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Beep test</span>
			</a>
        </li>
		<li class="nav-item <?php activateMenu("7","0"); ?>">
			<a href="#" onclick="nowaOpcja(7,0)">
				<i class="fas fa-stopwatch-20"></i>
				<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Opto jump next</span>
			</a>
        </li>
      </ul>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
