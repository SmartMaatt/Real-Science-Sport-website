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
  
  <title>Zamówienia - Wysokiej klasy kręgielnia</title>
  
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
          <h3 class="content-header-title mb-0 d-inline-block">Usługi gastronomiczne</h3>
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
			<li class="is-shown"><a class="menu-item" href="rozchodniaczki/id_opcji1.php">Thory</a></li><li class="is-shown"><a class="menu-item" href="rozchodniaczki/id_opcji2.php">Stoły</a></li><li class="  is-shown"><a class="menu-item" href="rozchodniaczki/id_opcji3.php">Stoliki</a></li>
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
		<li class="active nav-item"><a href="gastro.php">
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
		  
		  <!-- OKNO TABELI  -->
		  <div class="row">
            <div class="col-12">
              <div id="table_card" class="card">
                <div class="card-naglowek_cor card-header">
                  <h1 class="card-title" style="font-size: 30px;"> Szczegóły zamówienia
				  </h1>
                  <div class="heading-elements">
                      <a data-action="collapse"><i class="ft-minus"></i></a>
                  </div>
                </div>
                <div class="card-content collapse show">
                  <div class="card-body">
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

							echo '<table id="app_table" class="cash_table order_details_table">';
							
							echo '<tr id="tablenav">';
							echo '<td>Id</td>';
							echo '<td>Dane klienta</td>';
							echo '<td>Adres</td>';
							echo '<td>Telefon</td>';
							echo '</tr>';
							
							foreach($_POST as $key => $name)
							{
								$id_z = $key;
							}
							$sql = "SELECT * FROM adres_zamowienia WHERE id_zamowienia = '$id_z'";
							if($result = @$connection->query($sql))
							{
								$row = $result->fetch_assoc();
								$id_zamowienia = $row['id_zamowienia'];
								$adres = $row['kraj']." ".$row['miasto']." ".$row['ulica']." ".$row['nr_domu']."/".$row['nr_mieszkania']." ".$row['kod_pocztowy'];
								$telefon = $row['telefon'];
								$sql3 = "SELECT imie, nazwisko FROM klient k, zamowienia z WHERE k.id_klienta = z.id_klienta AND z.id_zamowienia = '$id_zamowienia'";
								if($result3 = @$connection->query($sql3))
								{
									$row3 = $result3->fetch_assoc();
									$imie = $row3['imie'];
									$nazwisko = $row3['nazwisko'];
									$result3->free_result();
								}
								echo '<tr>';
								echo "<td>$id_z</td><td>$imie $nazwisko</td><td>$adres</td><td>$telefon</td>";
								echo '</tr>';		
								$result->free_result();
							}
							echo '</table>';
							
							echo '<table id="app_table" class="ingredients_table">';
							echo '<tr id="tablenav">';
							echo '<td>Nazwa</td>';
							echo '<td>Cena</td>';
							echo '</tr>';
							
							$sql2 = "SELECT m.nazwa_uslugi, m.cena_uslugi FROM menu m, zamowienia_menu zm WHERE zm.id_uslugi = m.id_uslugi AND zm.id_zamowienia = '$id_z'";
							if($result2 = @$connection->query($sql2))
							{
								$suma = 0;
								for($i=0; $i < $result2->num_rows; $i++)
								{
									$row2 = $result2->fetch_assoc();
									$nazwa = $row2['nazwa_uslugi'];
									$cena = $row2['cena_uslugi'];
									$suma += $cena;
									echo '<tr>';
									echo "<td>$nazwa</td><td>$cena</td>";
									echo '</tr>';
								}
								echo '<tr>';
								echo "<td>suma</td><td>$suma</td>";
								echo '</tr>';
								echo '</table>';
								$result2->free_result();
							}
							echo "</br>";
							echo '<form action="rozchodniaczki/usun_usluge.php" method="post">
								<input type="submit" class="btn btn-danger" value="usuń usługę" name='.$id_z;'/>
								</form>';
							
							$connection->close();
						}

					?>
					<a href="gastro.php"><button style="margin-left:5px;" class="btn btn-dark">Wróć do spisu</button></a>
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