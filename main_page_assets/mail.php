<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>Kontakt - SmartMatt_Page</title>
	
	<meta name="author" content="Mateusz Płonka/ SmartMatt" />
	<meta name="description" content="Oficjalne portfolio Mateusza Płonki a.k.a. SmartMatt" />
	
	<link rel="shortcut icon" href="img/Logo.png" />
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<link rel="stylesheet" href="css/animate.css" type="text/css" />
	<link rel="stylesheet" href="css/responsive.css" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap&subset=latin-ext" rel="stylesheet">
	
	 <script src="https://kit.fontawesome.com/9b863fbae2.js"></script>	
</head>


<body>
	<div id="home_screan" class="mainPage_home">
		<div class="home_screan_part" style="text-align:center;">
			<?php	
				if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['e-mail']) && isset($_POST['message']) && isset($_POST['token']))
				{
					$token_recaptcha = $_POST['token'];
		
					//RECAPTCHA
					$url_recaptcha = "https://www.google.com/recaptcha/api/siteverify";
					$data_recaptcha = [
						'secret' => "6LePmDAaAAAAABS8AtvLqF7YMYVzUtD_dbArn8tN",
						'response' => $token_recaptcha,
						// 'remoteip' => $_SERVER['REMOTE_ADDR']
					];

					$options_recaptcha = array(
						'http' => array(
						  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
						  'method'  => 'POST',
						  'content' => http_build_query($data_recaptcha)
						)
					  );

					$context_recaptcha  = stream_context_create($options_recaptcha);
					$response_recaptcha = file_get_contents($url_recaptcha, false, $context_recaptcha);

					$res_recaptcha = json_decode($response_recaptcha, true);
					
					if($res_recaptcha['success'] == false) {
						echo '<h1 class="animated fadeInUp" >Nie jesteś człowiekiem</h1>';
						echo '<a href="../index.php" class="btn center_btn home_screan animated fadeInRight" style="margin:30px auto;">Powrót</a>';
						exit(0);
					}
					////////////////////////
					
					
					$to      = 'mateuszplonka.tg@gmail.com';
					$subject = $_POST['name'] . ' ' . $_POST['surname'];
					$message = "Imie: " . $_POST['name'] . "<BR />Nazwisko: " . $_POST['surname'] . "<BR />E-mail: " . $_POST['e-mail'] . "<BR /><BR />" . $_POST['message'];
					$headers = 'From: ' . $_POST['e-mail'] . "\r\n" .'Content-type: text/html; charset=utf-8';

					mail($to, $subject, $message, $headers)
					 or die('<h1 class="animated fadeInUp" >Coś poszło nie tak ;/</h1>');
					 
					 echo '<h1 class="animated fadeInUp" >Wiadomość została wysłana!</h1>';
				}
			?>
			<a href="../index.php" class="btn center_btn home_screan animated fadeInRight" style="margin:30px auto;">Powrót</a>
		</div>	
	</div>  
	<script src="script.js"></script>
</body>
</html>