<?php
	/*SECURED*/
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: logowanie.php');
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
				<?php echo "$page_info"; ?>
			</h3>
			
		<?php
		
			if(isset($_SESSION['id_admina']) && isset($_SESSION['imie_klienta']) && isset($_SESSION['nazwisko_klienta'])){
			
				echo '<ul class="nav navbar-nav ml-auto float-right">
						<li class="dropdown dropdown-user nav-item">
						  <a class="dropdown-toggle nav-link dropdown-user-link surNavBar" href="#">
							<span>Witaj,
							  <span class="text-bold-700">'.$_SESSION['imie_klienta'].' '.$_SESSION['nazwisko_klienta'].'</span>
							</span>
						  </a>
						</li>
						</ul>';
			}
			else {
				echo '
				  <ul class="nav navbar-nav ml-auto float-right">
					<li class="dropdown dropdown-user nav-item">
					  <a class="dropdown-toggle nav-link dropdown-user-link surNavBar" href="#">
						<span>Witaj,
						  <span class="text-bold-700">'.$_SESSION['imie'].' '.$_SESSION['nazwisko'].'</span>
						</span>
					  </a>
					</li>
					
					<li class="dropdown dropdown-notification nav-item">
					  <a class="dropdown-toggle nav-link dropdown-user-link nav-link-label iconsRss" href="#" data-toggle="dropdown">
						<i class="ficon ft-user"></i>
					  </a>
					  <div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="rozchodniaczki/id_opcji.php?o='.$_SESSION['id_podopcji'].'&p=11&b=-1"><i class="ft-user"></i>Pokaż profil</a>
						<a class="dropdown-item" href="rozchodniaczki/id_opcji.php?o='.$_SESSION['id_podopcji'].'&p=12&b=-1"><i class="ft-settings"></i>Ustawienia</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="rozchodniaczki/wyloguj.php"><i class="ft-power"></i> Wyloguj</a>
					  </div>
					</li>
					<li class="dropdown dropdown-notification nav-item">
					  <a class="nav-link nav-link-label iconsRss" href="rozchodniaczki/id_opcji.php?o='.$_SESSION['id_podopcji'].'&p=13&b=-1"><i class="ficon ft-mail"></i></a>
					 
					</li>
				  </ul>';
			}
		?>
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
          <span class="side_menu_divider" data-i18n="nav.category.ui">Twoje badania</span><i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Twoje badania"></i>
        </li>
		<?php
			require_once 'rozchodniaczki/connect.php';
			$connection = @new mysqli($host, $db_user, $db_password, $db_name);

			if (($connection->connect_errno == 0) && (isset($_SESSION['id_klienta']))) 
			{
				$id_klienta = $_SESSION['id_klienta'];
				$sql = "SELECT * FROM wszystkie_badania where id_klienta = '$id_klienta'";
				$result = @$connection->query($sql);
				if($result) 
				{
					$row = $result->fetch_assoc();
					if($row['biofeedback_eeg'])
					{
						echo
							'<li class="nav-item '; activateMenu(1,0); echo'">
								<a href="rozchodniaczki/id_opcji.php?o=1&p=0&b=-1">
									<i class="fas fa-brain"></i>
									<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Biofeedback EEG</span>
								</a>
							</li>';
					}
					if($row['analiza_skladu_ciala'])
					{
						echo
							'<li class="nav-item '; activateMenu(2,0); echo'">
								<a href="rozchodniaczki/id_opcji.php?o=2&p=0&b=-1"">
									<i class="fas fa-weight"></i>
									<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Analiza składu ciała</span>
								</a>
							</li>';
					}
					$wysokosc = 0;
					if($row['test_szybkosci'])
						$wysokosc += 40.0;
					if($row['rast_test'])
						$wysokosc += 40.0;
					if($row['prowadzenie_pilki'])
						$wysokosc += 40.0;
					if($wysokosc)
					{
						echo
							'<li class="nav-item has-sub"><a href="#"><i class="la la-rocket"></i><span class="menu-title" data-i18n="nav.event_calendars.main">Fotokomórki</span></a>
							  <ul class="menu-content" style="height: '.$wysokosc.'px; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px; overflow: hidden;">
								<ul class="menu-content" style="">';
								
								if($row['test_szybkosci']){
									echo "<li class='is-shown "; activateMenu('3','1'); echo "'><a class='menu-item' href='rozchodniaczki/id_opcji.php?o=3&p=1&b=-1'>Test szybkości</a></li>";}
								if($row['rast_test']){
									echo "<li class='is-shown "; activateMenu('3','2'); echo "'><a class='menu-item' href='rozchodniaczki/id_opcji.php?o=3&p=2&b=-1'>Rast test</a></li>";}
								if($row['prowadzenie_pilki']){
									echo "<li class='is-shown "; activateMenu('3','3'); echo "'><a class='menu-item' href='rozchodniaczki/id_opcji.php?o=3&p=3&b=-1'>Prowadzenia piłki</a></li>";}
						echo		
								'</ul>
							  </ul>
							</li>';
					}
					if($row['analizator_kwasu_mlekowego'])
					{
						echo
							'<li class="nav-item '; activateMenu(4,0); echo'">
								<a href="rozchodniaczki/id_opcji.php?o=4&p=0&b=-1">
									<i class="ft-bar-chart"></i>
									<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Analizator kwasu mlekowego</span>
								</a>
							</li>';
					}
					if($row['wzrostomierz'])
					{
						echo
							'<li class="nav-item '; activateMenu(5,0); echo'">
								<a href="rozchodniaczki/id_opcji.php?o=5&p=0&b=-1">
									<i class="fas fa-ruler-vertical"></i>
									<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Wzrostomierz</span>
								</a>
							</li>';
					}
					if($row['beep_test'])
					{
						echo
							'<li class="nav-item '; activateMenu(6,0); echo'">
								<a href="rozchodniaczki/id_opcji.php?o=6&p=0&b=-1">
									<i class="ft-activity"></i>
									<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Beep test</span>
								</a>
							</li>';
					}
					if($row['opto_jump_next'])
					{
						echo
							'<li class="nav-item '; activateMenu(7,0); echo'">
								<a href="rozchodniaczki/id_opcji.php?o=7&p=0&b=-1">
									<i class="fas fa-stopwatch-20"></i>
									<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Opto jump next</span>
								</a>
							</li>';
					}
				}
			}
		?>
		
		<!--DOSTĘPNE BADANIA -->
		<li class="navigation-header">
          <span class="side_menu_divider" data-i18n="nav.category.ui">Dostępne badania</span><i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Dostępne badania"></i>
        </li>
		<?php
			if ($connection->connect_errno == 0) 
			{
				if($result) 
				{
					if(!$row['biofeedback_eeg'])
					{
						echo
							'<li class="nav-item '; activateMenu(1,0); echo'">
								<a href="rozchodniaczki/id_opcji.php?o=1&p=0&b=-1">
									<i class="fas fa-brain"></i>
									<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Biofeedback EEG</span>
								</a>
							</li>';
					}
					if(!$row['analiza_skladu_ciala'])
					{
						echo
							'<li class="nav-item '; activateMenu(2,0); echo'">
								<a href="rozchodniaczki/id_opcji.php?o=2&p=0&b=-1">
									<i class="fas fa-weight"></i>
									<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Analiza składu ciała</span>
								</a>
							</li>';
					}
					$wysokosc = 0;
					if(!$row['test_szybkosci'])
						$wysokosc += 40.0;
					if(!$row['rast_test'])
						$wysokosc += 40.0;
					if(!$row['prowadzenie_pilki'])
						$wysokosc += 40.0;
					if($wysokosc)
					{
						echo
							'<li class="nav-item has-sub"><a href="#"><i class="la la-rocket"></i><span class="menu-title" data-i18n="nav.event_calendars.main">Fotokomórki</span></a>
							  <ul class="menu-content" style="height: '.$wysokosc.'px; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px; overflow: hidden;">
								<ul class="menu-content" style="">';
								
								if(!$row['test_szybkosci']){
									echo "<li class='is-shown "; activateMenu('3','1'); echo "'><a class='menu-item' href='rozchodniaczki/id_opcji.php?o=3&p=1&b=-1'>Test szybkości</a></li>";}
								if(!$row['rast_test']){
									echo "<li class='is-shown "; activateMenu('3','2'); echo "'><a class='menu-item' href='rozchodniaczki/id_opcji.php?o=3&p=2&b=-1'>Rast test</a></li>";}
								if(!$row['prowadzenie_pilki']){
									echo "<li class='is-shown "; activateMenu('3','3'); echo "'><a class='menu-item' href='rozchodniaczki/id_opcji.php?o=3&p=3&b=-1'>Prowadzenia piłki</a></li>";}
						echo		
								'</ul>
							  </ul>
							</li>';
					}
					if(!$row['analizator_kwasu_mlekowego'])
					{
						echo
							'<li class="nav-item '; activateMenu(4,0); echo'">
								<a href="rozchodniaczki/id_opcji.php?o=4&p=0&b=-1">
									<i class="ft-bar-chart"></i>
									<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Analizator kwasu mlekowego</span>
								</a>
							</li>';
					}
					if(!$row['wzrostomierz'])
					{
						echo
							'<li class="nav-item '; activateMenu(5,0); echo'">
								<a href="rozchodniaczki/id_opcji.php?o=5&p=0&b=-1">
									<i class="fas fa-ruler-vertical"></i>
									<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Wzrostomierz</span>
								</a>
							</li>';
					}
					if(!$row['beep_test'])
					{
						echo
							'<li class="nav-item '; activateMenu(6,0); echo'">
								<a href="rozchodniaczki/id_opcji.php?o=6&p=0&b=-1">
									<i class="ft-activity"></i>
									<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Beep test</span>
								</a>
							</li>';
					}
					if(!$row['opto_jump_next'])
					{
						echo
							'<li class="nav-item '; activateMenu(7,0); echo'">
								<a href="rozchodniaczki/id_opcji.php?o=7&p=0&b=-1">
									<i class="fas fa-stopwatch-20"></i>
									<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Opto jump next</span>
								</a>
							</li>';
					}
				}
			}
		?>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
