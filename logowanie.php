<?php
	session_start();
	$error_msg = "";

	if (isset($_SESSION['id_klienta'])) {
		if(isset($_SESSION['id_admina'])){
			header('Location: panel_admina.php');
		}
		else{
			header('Location: panel.php');
		}
	}
	elseif(isset($_SESSION['error'])){
		$error_msg = "onload=\"".$_SESSION['error']."\"";
		unset($_SESSION['error']);
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
  
  <title>Logowanie-Real Science Sport</title>
  
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



<body 
	class="vertical-layout vertical-menu-modern 1-column menu-expanded blank-page blank-page bgLoggin"
	data-open="click" 
	data-menu="vertical-menu-modern" 
	data-col="1-column"
	<?php echo $error_msg;?>
>
  <div class="app-content content">
    <div class="content-wrapper">
	<div class="blackBlind"></div>
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-lg-5 col-md-6 col-12 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">
                  <div class="card-title text-center">
                    <div class="p-1">
                      <img class="display-logo" alt="Real science sport logo" src="app-assets/images/logoBlack.png">
                    </div>
                  </div>
                  <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span>Panel logowania</span>
                  </h6>
                </div>
                <div class="card-content">
                  <div class="card-body">
				  
					<!-- FORMULARZ LOGOWANIE-->
                    <form class="form-horizontal form-simple" action="rozchodniaczki/loguj.php" method ="post">
                      <fieldset class="form-group position-relative has-icon-left">
					  
                        <input type="email" class="form-control form-control-lg input-lg" id="user-name" placeholder="Wprowadź mail" name="mail" required>
                        <div class="form-control-position">
                          <i class="ft-user"></i>
                        </div>
                      </fieldset>
					  
                      <fieldset class="form-group position-relative has-icon-left mb-3">
                        <input type="password" class="form-control form-control-lg input-lg" id="user-password" placeholder="Wprowadź hasło" name="haslo" required>
                        <div class="form-control-position">
                          <i class="la la-key"></i>
                        </div>
                      </fieldset>
                      <div class="form-group row">
							<div class="col-6 text-center text-md-left">
                          <fieldset>
                            <input type="checkbox" id="remember-me" class="chk-remember">
                            <label for="Zapamiętaj mnie"> Zapamiętaj mnie</label>
                          </fieldset>
                        </div> 
						
                        <div class="col-6 text-center text-md-right"><a href="reset_hasla.php" class="card-link">Zapomniałeś hasła?</a></div>
                      </div>
					  
					  <hr>
                      <button type="submit" style="margin-right:5px;" class="btn btn-rss"><i class="ft-unlock"></i> Zaloguj</button>
					  <a class="btn btn-info" role="button" href="rejestracja.php"><i class="ft-plus-square"></i> Rejestracja</a>
                    </form>
					<!-- ////////////////////////////////////////////////////////////////////////////-->
					
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

</body>
</html>