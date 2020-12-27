<?php
	session_start();
	$error_msg = "";

	if (isset($_SESSION['id_klienta'])) {
		header('Location: panel.php');
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
  <title>Reset hasła - Real Science Sport</title>
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

  <!-- TOASTR PLUGIN -->
  <link rel="stylesheet" type="text/css" href="app-assets/ModernAdminCss/plugins/toastr.css">
	
  <!-- WŁASNE STYLE CSS -->
  <link rel="stylesheet" type="text/css" href="app-assets/ownCss.css">
  
  
</head>
<body class="vertical-layout vertical-menu-modern 1-column  bgResetPass menu-expanded blank-page blank-page"
data-open="click" data-menu="vertical-menu-modern" data-col="1-column" <?php echo $error_msg;?>>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  <div class="blackBlind"></div>
  
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-lg-5 col-md-6 col-12 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                <div class="card-header border-0 pb-0">
                  <div class="card-title text-center">
                    <img class="display-logo" src="app-assets/images/logoBlack.png" alt="Real Science Sport logo">
                  </div>
                </div>
                <div class="card-content mt-1">
                  <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                    <span><b>Resetuj hasło</b></span>
                  </p>
                  <div class="card-body">
				  
				  
				  <!--FORMULARZ RESETU TUTAJ TUTAJ -->
				  
				  
                    <form class="form-horizontal" action="rozchodniaczki/resetuj_haslo.php" method="get">
                      <fieldset class="form-group position-relative has-icon-left">
                        <input type="text" class="form-control" id="user-name" placeholder="Imie" name='imie' required>
                        <div class="form-control-position">
                          <i class="ft-user"></i>
                        </div>
                      </fieldset>
					  <fieldset class="form-group position-relative has-icon-left">
                        <input type="text" class="form-control" id="user-name" placeholder="Nazwisko" name='nazwisko' required>
                        <div class="form-control-position">
                          <i class="ft-user"></i>
                        </div>
                      </fieldset>
                      <fieldset class="form-group position-relative has-icon-left">
                        <input type="email" class="form-control" id="user-email" placeholder="E-mail" name='mail' required>
                        <div class="form-control-position">
                          <i class="ft-mail"></i>
                        </div>
                      </fieldset>
                      
					  <hr>
                      <button type="submit" class="btn btn-lg btn-block btn-warning"><i class="ft-download-cloud"></i> Resetuj</button>
					  <a class="btn btn-lg btn-block btn-info" role="button" href="logowanie.php"><i class="ft-unlock"></i> Logowanie powrót</a>
                    </form>
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