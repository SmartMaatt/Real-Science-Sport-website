<!DOCTYPE html>
<html class="loading" lang="pl" data-textdirection="ltr">
<?php
	session_start();

	if (!isset($_SESSION['id_osoby'])) 
	{
		header('Location: index.php');
	}
	
	if(isset($_POST['global_date']))
	{
		$_SESSION['data'] = $_POST['global_date'];
	}
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Projekt zaliczeniony IO grupy 3-2-1">
  <meta name="author" content="IO grupa 3-2-1">
  
  <title>Rezerwacje - Wysokiej klasy kręgielnia</title>
  
  <!-- Ikony i animacje -->
  <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/logoBowling.png">
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
              <img class="brand-logo" alt="modern admin logo" src="app-assets/images/logoBowling.png">
              <h5 class="brand-text">Wysokiej klasy kręgielnia</h5>
            </a>
          </li>
          <li class="nav-item d-none d-md-block float-right"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="toggle-icon ft-toggle-right font-medium-3 white" data-ticon="ft-toggle-right"></i></a></li>
          <li class="nav-item d-md-none">
            <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
          </li>
        </ul>
      </div>
      <div class="navbar-container content">
        <div class="collapse navbar-collapse" id="navbar-mobile">
          <h3 class="content-header-title mb-0 d-inline-block">Rezerwacje 
				<?php
					if($_SESSION['id_opcji'] == 1) echo "thorów do kręgli";
					elseif($_SESSION['id_opcji'] == 2) echo "stołów do bilarda";
					elseif($_SESSION['id_opcji'] == 3) echo "stolików restauracyjnych";
				?>
			</h3>
          <div class="row breadcrumbs-top d-inline-block">
        </div>
          <ul class="nav navbar-nav ml-auto float-right">
            <li class="dropdown dropdown-user nav-item">
              <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                <span class="mr-1">Witaj,
                  <span class="user-name text-bold-700"><?php  echo $_SESSION['Imie']." ".$_SESSION['Nazwisko']; ?></span>
                </span>
                <span class="avatar avatar-online">
                  <img src="app-assets/images/avatar-s-19.png" alt="avatar"><i></i></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#"><i class="ft-user"></i>Pokaż profil</a>
                <a class="dropdown-item" href="#"><i class="ft-bell"></i>Bojowe zadania</a>
                <div class="dropdown-divider"></div><a class="dropdown-item" href="rozchodniaczki/wyloguj.php"><i class="ft-power"></i> Wyloguj</a>
              </div>
            </li>
            <li class="dropdown dropdown-notification nav-item">
              <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                <li class="dropdown-menu-header">
                  <h6 class="dropdown-header m-0">
                    <span class="grey darken-2">Bojowe zadania</span>
                  </h6>
                </li>
                <li class="scrollable-container media-list w-100">
				<?php
				require_once "rozchodniaczki/connect.php";
	
				$connection = @new mysqli($host, $db_user, $db_password, $db_name);
				
				if($connection->connect_errno!=0)
				{
					echo "Error: ".$connection->connect_errno;
				}
				else
				{
					$id_osoby = $_SESSION['id_osoby'];
					$sql = "SELECT * FROM zadanie_specjalne WHERE id_osoby = '$id_osoby'";
					if($result = @$connection->query($sql))
					{
						for($i = 0; $i<$result->num_rows; $i++)
						{
							$row = $result->fetch_assoc();
							$information = $row['tresc'];
							echo'<a href="javascript:void(0)">';
								echo'<div class="media">';
								  echo'<div class="media-left align-self-center"><i class="ft-alert-triangle icon-bg-circle bg-yellow bg-darken-3"></i></div>';
									echo'<div class="media-body">';
										echo'<h6 class="media-heading yellow darken-3">Uwaga! Szykuje się szóstka z IO</h6>';
									echo"<p class='notification-text font-small-3 text-muted'>$information</p>";
								  echo'</div>';
								echo'</div>';
							 echo'</a>';
						}	
						$result->free_result();
					}
					$connection->close();
				}
				?>
                </li>
              </ul>
            </li>
            <li class="dropdown dropdown-notification nav-item">
              <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-mail">             </i></a>
              <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                <li class="dropdown-menu-header">
                  <h6 class="dropdown-header m-0">
                    <span class="grey darken-2">Wiadomości</span>
                  </h6>
                  <span class="notification-tag badge badge-default badge-warning float-right m-0">1 Nowa</span>
                </li>
                <li class="scrollable-container media-list w-100">
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left">
                        <span class="avatar avatar-sm avatar-away rounded-circle">
                          <img src="app-assets/images/avatar-s-6.png" alt="avatar"><i></i></span>
                      </div>
                      <div class="media-body">
                        <h6 class="media-heading">Luke Skywalker</h6>
                        <p class="notification-text font-small-3 text-muted">No, it's not true!</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Wczoraj</time>
                        </small>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Zobacz wszystkie wiadomości</a></li>
              </ul>
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
	   <li class="nav-item has-sub"><a href="#"><i class="la la-calendar"></i><span class="menu-title" data-i18n="nav.event_calendars.main">Rezerwacje</span></a>
          <ul class="menu-content" style="height: 122.297px; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px; overflow: hidden;">
            <ul class="menu-content" style="">
			<?php
                echo "<li class=' ";
				if($_SESSION['id_opcji'] == 1) echo "active";		
				echo " is-shown'><a class='menu-item' href='rozchodniaczki/id_opcji1.php'>Thory</a></li>";
				
				echo "<li class=' ";
				if($_SESSION['id_opcji'] == 2) echo "active";		
				echo " is-shown'><a class='menu-item' href='rozchodniaczki/id_opcji2.php'>Stoły</a></li>";
				
				echo "<li class=' ";
				if($_SESSION['id_opcji'] == 3) echo "active";		
				echo " is-shown'><a class='menu-item' href='rozchodniaczki/id_opcji3.php'>Stoliki</a></li>";
			?>
              </ul>
          </ul>
        </li>
		<li class="nav-item"><a href="rachunki.php">
			<i class="las la-cash-register"></i>
			<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Rachunki</span></a>
        </li>
		<li class="nav-item"><a href="grafik.php">
			<i class="las la-bell"></i>
			<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Grafik</span></a>
        </li>
		<li class="nav-item"><a href="gastro.php">
			<i class="las la-utensils"></i>
			<span class="menu-title" data-i18n="nav.rickshaw_charts.main">Usługi gastronomiczne</span></a>
        </li>
      </ul>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  <!-- GŁÓWNY KONTENER -->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-body">
	 
        <section id="basic-examples">
		
		<!-- OKNO FORMULARZA -->
		 <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title" id="horz-layout-icons">Dodaj rezerwację 
					<?php
						if($_SESSION['id_opcji'] == 1) echo "thorów do kręgli";
						elseif($_SESSION['id_opcji'] == 2) echo "stołu do bilarda";
						elseif($_SESSION['id_opcji'] == 3) echo "stolika restauracyjnego";
					?>
				  </h4>
                  
                  <div class="heading-elements">
                      <a data-action="collapse"><i class="ft-plus"></i></a>
                  </div>
                </div>
                <div class="card-content collpase collapse" style="">
                  <div class="card-body">
				  
				  
                    <form class="form form-horizontal" method="POST" action="rozchodniaczki/dodaj_rezerwacje.php">
                      <div class="form-body">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="timesheetinput1">Imie klienta</label>
                          <div class="col-md-9">
                            <div class="position-relative has-icon-left">
                              <input type="text" id="zamowienie_imie" class="form-control" placeholder="Imie klienta" name="zamowienie_imie" required>
                              <div class="form-control-position">
                                <i class="ft-user"></i>
                              </div>
                            </div>
                          </div>
                        </div>
						 <div class="form-group row">
                          <label class="col-md-3 label-control" for="timesheetinput2">Nazwisko klienta</label>
                          <div class="col-md-9">
                            <div class="position-relative has-icon-left">
                              <input type="text" id="zamowienie_nazwisko" class="form-control" placeholder="Nazwisko klienta" name="zamowienie_nazwisko" required>
                              <div class="form-control-position">
                                <i class="ft-user"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="timesheetinput3">Numer telefonu</label>
                          <div class="col-md-9">
                            <div class="position-relative has-icon-left">
                              <input type="text" id="zamowienie_telefon" class="form-control" placeholder="Numer telefonu" name="zamowienie_telefon" onkeypress='correctPhone(event)' maxlength="11" required>
                              <div class="form-control-position">
                                <i class="ft-phone-forwarded"></i>
                              </div>
                            </div>
                          </div>
                        </div>
						<div class="form-group row">
                          <label class="col-md-3 label-control" for="timesheetinput4">E-mail</label>
                          <div class="col-md-9">
                            <div class="position-relative has-icon-left">
                              <input type="email" id="zamowienie_email" class="form-control" placeholder="E-mail" name="zamowienie_email" required>
                              <div class="form-control-position">
                                 <i class="ft-mail"></i>
                              </div>
                            </div>
                          </div>
                        </div>
						<div class="form-group row">
                          <label class="col-md-3 label-control" for="timesheetinput5">Liczba torów</label>
                          <div class="col-md-9">
                            <div class="position-relative has-icon-left">
                              <input type="number" id="zamowienie_tory" class="form-control" placeholder="liczba_stanowisk" name="liczba_stanowisk" min="1" value="1" required>
                              <div class="form-control-position">
                                 <i class="las la-bowling-ball"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="timesheetinput6">Data</label>
                          <div class="col-md-9">
                            <div class="position-relative has-icon-left">
                              <input type="date" id="zamowienie_data" class="form-control" name="data" oninput="correctDate(this)" required>
                              <div class="form-control-position">
                                <i class="ft-calendar"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="timesheetinput7">Rozpoczęcie rezerwacji</label>
                          <div class="col-md-9">
                            <div class="position-relative has-icon-left">
                              <input type="time" id="zamowienie_start" class="form-control" name="godz_pocz" oninput="correctFirstTime(this)" required>
                              <div class="form-control-position">
                                <i class="ft-clock"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="timesheetinput8">Koniec rezerwacji</label>
                          <div class="col-md-9">
                            <div class="position-relative has-icon-left">
                              <input type="time" id="zamowienie_koniec" class="form-control" name="godz_kon" oninput="correctSecondTime(this)" required>
                              <div class="form-control-position">
                                <i class="ft-clock"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-actions right">
                        <button type="reset" class="btn btn-danger mr-1">
                          <i class="ft-x"></i> Wyczyść
                        </button>
                        <button type="submit" class="btn btn-dark">
                          <i class="la la-check-square-o"></i> Dodaj
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
         <!-- ////////////////////////////////////////////////////////////////////////////-->
		  
		  <!-- OKNO TABELI REZERWACJI -->
		  <div class="row">
            <div class="col-12">
              <div id="table_card" class="card 
				<?php 
					if($_SESSION['id_opcji'] == 1) echo 'table_card1">';
					elseif($_SESSION['id_opcji'] == 2) echo 'table_card2">';
					elseif($_SESSION['id_opcji'] == 3) echo 'table_card3">';
				?>
                <div class="card-naglowek_cor card-header">
                  <h4 class="card-title">Grafik rezerwacji
					<?php
						if($_SESSION['id_opcji'] == 1) echo "thorów do kręgli";
						elseif($_SESSION['id_opcji'] == 2) echo "stołów do bilarda";
						elseif($_SESSION['id_opcji'] == 3) echo "stolików restauracyjnych";
					?>
				  </h4>
                  <div class="heading-elements">
                      <a data-action="collapse"><i class="ft-minus"></i></a>
                  </div>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body">
                    <p class="card-text">To statek, który pokonał trasę na Kessel w mniej niż 12 parseków. 
					Jest szybszy od imperialnych niszczycieli. Nie mówię o krążownikach, pamiętaj. 
					Mówię o wielkich statkach. Jest wystarczająco szybki, staruszku. <b>~Han Solo</b></p>
					
					<form method="POST" action="rezerwacja.php" id="table_date_picker">
						<button type="submit" class="btn btn-dark">
                          <i class="la la-check-square-o"></i> Zmień
                        </button>
					
					<?php

						require_once "rozchodniaczki/connect.php";
						
						$connection = @new mysqli($host, $db_user, $db_password, $db_name);
						
						if($connection->connect_errno!=0)
						{
							echo "Error: ".$connection->connect_errno;
						}
						else
						{
							$dzien = $_SESSION['data'];
							$id_klubu = $_SESSION['id_klubu'];
							$id_opcji = $_SESSION['id_opcji'];

							echo "<input type='date' class='form-control' name='global_date' value='".$dzien."' required/>";
							echo "</form>";
							echo '<table id="app_table" class="reservation_table">';
							echo '<tr id="tablenav">';
							if($_SESSION['id_opcji'] == 1) echo "<td>Thor</td>";
							elseif($_SESSION['id_opcji'] == 2) echo "<td>Stół</td>";
							elseif($_SESSION['id_opcji'] == 3) echo "<td>Stolik</td>";
						
							for($j = 6; $j<22; $j++)
							{
								echo "<td>$j:00</td>";
							}
							echo '</tr>';
							
							$ile = 0;

							$sql = "SELECT liczba_torow AS ile FROM kluby WHERE id_klubu = '$id_klubu'";
							if($result = @$connection->query($sql))
							{
								$row = $result->fetch_assoc();
								$ile = $row['ile'];
							}
							
							for($k = 1; $k<=$ile; $k++)
							{
								echo "<tr>";
								echo"<td><h4>$k</h4></td>";
							
								$sql = "SELECT * FROM rezerwacje WHERE id_opcji = '$id_opcji' AND data = '$dzien' AND nr_porzadkowy = '$k'";
								if($result = @$connection->query($sql))
								{
									$hour_array = array();
									for($i = 0; $i<$result->num_rows; $i++)
									{
										$row = $result->fetch_assoc();
										$godz = $row['godzina'];
										array_push($hour_array, $godz);
									}
									
									$cell = "<td></td>";
									
									for($j = 6; $j<22; $j++)
									{
										for($i = 0; $i<$result->num_rows; $i++)
										{
											if($j == $hour_array[$i])
											{
												$sql2 = "SELECT imie, nazwisko, telefon, adres_email FROM klient k, rezerwacje r WHERE k.id_klienta = r.id_klienta AND r.godzina = '$j' AND r.data = '$dzien' AND r.id_opcji = '$id_opcji' AND r.nr_porzadkowy = '$k' ";
												if($result2 = @$connection->query($sql2))
												{
													$row2 = $result2->fetch_assoc();
													$imie = $row2['imie'];
													$nazwisko = $row2['nazwisko'];
													$osoba = $imie." ".$nazwisko;
													$telefon = $row2['telefon'];
													$adres_email = $row2['adres_email'];
												}
												$cell = "<td class='table_reserved' onclick=\"infoCardAlley(".$_SESSION['id_opcji'].",".$k.",".$j.",'".$imie."','".$nazwisko."',".$telefon.",'".$adres_email."', 0)\">
														<p>".$osoba."</p>
														</td>";
												break;
											}
										}
										echo "$cell";
										$cell = "<td></td>";
									}			
									$result->free_result();
								}	
								echo '</tr>';
							}
							echo '</table>';
							$connection->close();
						}

					?>
                  </div>
                </div>
              </div>
            </div>
          </div>
		 <!-- ////////////////////////////////////////////////////////////////////////////-->
			
        </section>
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  <!-- STOPKA -->
  <footer class="footer footer-static footer-light navbar-border navbar-shadow">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
      <span class="float-md-left d-block d-md-inline-block">Projekt IO, sekcja 3-2-1 </span>
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
  
</body>
</html>