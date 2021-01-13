<?php
	session_start();
	$error_msg = "";

	if (isset($_SESSION['id_klienta'])){
		header('Location: panel.php');
	}
	elseif(isset($_SESSION['error'])){
		$error_msg = "onload=\"".$_SESSION['error']."\"";
		unset($_SESSION['error']);
	}
	
	//Otwieranie bazy danych w celu pobrania aktualnej listy klubów
	require_once 'rozchodniaczki/connect.php';
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	$slider = "";

	if ($connection->connect_errno == 0){
		
		$sql = "SELECT * FROM klub";
		$result = @$connection->query($sql);

		if ($result){
			
			//Slider list do wyświetlenia w formularzu rejestracji
			$slider = "<label>Klub</label><fieldset class=\"form-group register-field position-relative has-icon-left\"><select class=\"custom-select\" id=\"custom_select\" name=\"id_klubu\" required><option value=\"\">Klient indywidualny</option>";
			
			while($row = $result->fetch_assoc()){
				$slider = $slider."<option value=\"".$row['id_klubu']."\">".$row['nazwa']."</option>";
			}
			$slider = $slider."</select></fieldset>";
			
		}
		else{
			//Niepowodzenie wykonania zapytania SQL
			header('Location: ../panel_admina.php');
			$_SESSION['error'] = 'loadToast(\'3\',\'Błąd wykonania polecenia SQL!\',\'Command: SELECT * FROM klub\')';
		}
		$connection->close();
	}
	else{
		//Nieudane połączenie z bazą
		header('Location: ../panel_admina.php');
		$_SESSION['error'] = 'loadToast(\'3\',\'Błąd bazy danych\',\'Error '.$connection->connect_errno.'\')';
	}	
?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="author" content="DeVision303" />
  <meta name="description" content="Official website of Real Science Sport" />
  <title>Rejestracja-Real Science Sport</title>
  <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
  <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
  rel="stylesheet">
  <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css"
  rel="stylesheet">
  
  
  <!-- Ikony i animacje -->
  <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/logoCard.png">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700" rel="stylesheet">
  <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
  
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/ModernAdminCss/vendors.css">
  <link rel="stylesheet" type="text/css" href="app-assets/ModernAdminCss/icheck/icheck.css">
  <link rel="stylesheet" type="text/css" href="app-assets/ModernAdminCss/icheck/custom.css">
  
  <!-- BEGIN MODERN CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/ModernAdminCss/app.css">

  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/ModernAdminCss/vertical-menu-modern.css">
  <link rel="stylesheet" type="text/css" href="app-assets/ModernAdminCss/palette-gradient.css">
  <link rel="stylesheet" type="text/css" href="app-assets/ModernAdminCss/login-register.css">

  <!-- WŁASNE STYLE CSS -->
  <link rel="stylesheet" type="text/css" href="app-assets/ownCss.css">
  
  <!-- TOASTR PLUGIN -->
  <link rel="stylesheet" type="text/css" href="app-assets/ModernAdminCss/plugins/toastr.css">
  
  
</head>
<body class="vertical-layout vertical-menu-modern 1-column  bgRegistration menu-expanded blank-page blank-page"
data-open="click" data-menu="vertical-menu-modern" data-col="1-column" <?php echo $error_msg;?>>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
	  <div class="blackBlind"></div>
      <div class="content-body register-body">
        <section>
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-lg-6 col-md-10 col-12 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0 pb-0">
                  <div class="card-title text-center">
                    <img class="display-logo" src="app-assets/images/logoBlack.png" alt="Real Science Sport logo">
                  </div>
                </div>
                <div class="card-content mt-1">
                  <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                    <span>Rejestracja E-mail</span>
                  </p>
                  <div class="card-body">
				  
				  
				  <!--FORMULARZ REJESTACJI TUTAJ -->
				  
				  
                    <form class="form-horizontal" action="rozchodniaczki/rejestruj.php" method="post">
					
					<label>Imie</label>
                      <fieldset class="form-group register-field position-relative has-icon-left">
                        <input type="text" class="form-control" id="input_imie" placeholder="Imie" name="imie" required>
                        <div class="form-control-position">
                          <i class="ft-user"></i>
                        </div>
                      </fieldset>
					  
					   <label>Nazwisko</label>
					  <fieldset class="form-group register-field position-relative has-icon-left">
                        <input type="text" class="form-control" id="user-name" placeholder="Nazwisko" name="nazwisko" required>
                        <div class="form-control-position">
                          <i class="ft-user"></i>
                        </div>
                      </fieldset>
					  
					  <label>E-mail</label>
                      <fieldset class="form-group register-field position-relative has-icon-left">
                        <input type="email" class="form-control" id="user-email" placeholder="E-mail" name="mail" required>
                        <div class="form-control-position">
                          <i class="ft-mail"></i>
                        </div>
                      </fieldset>
					  
					  <label>Płeć</label>
					  <fieldset class="form-group register-field position-relative has-icon-left">
					  <div class="btn-group btn-group-toggle" data-toggle="buttons">
						  <label class="btn btn-secondary active">
							<input type="radio" id="mezczyzna" name="plec" value="m" checked required>
						  Mężczyzna</label>
						  <label class="btn btn-secondary">
							<input type="radio" id="kobieta" name="plec" value="k" required>
						  Kobieta</label>
					</div>
					</fieldset>
					  
					  <label>Data urodzenia</label>
					  <fieldset class="form-group register-field position-relative has-icon-left">
                        <input type="date" class="form-control" id="user-birth-date" value="<?php echo date('Y-m-d'); ?>" name="data" required>
                        <div class="form-control-position">
                          <i class="fas fa-birthday-cake"></i>
                        </div>
                      </fieldset>
					  
					  <?php echo $slider; ?>
					  
					  <label>Hasło</label>
                      <fieldset class="form-group register-field position-relative has-icon-left">
                        <input type="password" class="form-control" id="user-password" placeholder="Hasło" name="haslo1" required>
                        <div class="form-control-position">
                          <i class="la la-key"></i>
                        </div>
                      </fieldset>
					  
					  <label>Powtórz hasło</label>
					  <fieldset class="form-group register-field position-relative has-icon-left">
                        <input type="password" class="form-control" id="user-password2" placeholder="Powtórz hasło" name="haslo2" required>
                        <div class="form-control-position">
                          <i class="la la-key"></i>
                        </div>
                      </fieldset>
                      
					  <hr>
                      <button type="submit" class="btn btn-rss"><i class="ft-plus-square"></i> Rejestracja</button>
					  <a  class="btn btn-info" role="button" href="logowanie.php"><i class="ft-unlock"></i> Logowanie powrót</a>
					  
                    </form>
					
					<h4>Wymagania dotyczące hasła:</h4>
					<ul>
						<li>Minimum jedena duża litera</li>
						<li>Minimum jedna mała litera</li>
						<li>Minimum jedna cyfra</li>
						<li>Długość hasła minimum 6 znaków</li>
					</ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <!-- BEGIN VENDOR JS-->
  <script src="app-assets/ModernAdminJs/vendors.min.js" type="text/javascript"></script>
  
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="app-assets/ModernAdminJs/icheck.min.js" type="text/javascript"></script>
  <script src="app-assets/ModernAdminJs/jqBootstrapValidation.js" type="text/javascript"></script>

  <!-- BEGIN MODERN JS-->
  <script src="app-assets/ModernAdminJs/app-menu.js" type="text/javascript"></script>
  <script src="app-assets/ModernAdminJs/app.js" type="text/javascript"></script>

  <!-- BEGIN PAGE LEVEL JS-->
  <script src="app-assets/ModernAdminJs/form-login-register.js" type="text/javascript"></script>
  
  <!-- TOASTR PLUGIN -->
  <script src="app-assets/ModernAdminJs/toastrConfig.js" type="text/javascript"></script>
  <script src="app-assets/ModernAdminJs/toastrPlugin.js" type="text/javascript"></script>
  
  <!-- WŁASNE SKRYPTY JS-->
  <script src="app-assets/ownJs.js" type="text/javascript"></script>
  <script src="https://kit.fontawesome.com/9b863fbae2.js"></script>
</body>
</html>