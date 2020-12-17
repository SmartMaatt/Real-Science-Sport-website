
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
					$to      = 'mateuszplonka.tg@gmail.com';
					$subject = $_POST['name'] . ' ' . $_POST['surname'];
					$message = "Imie: " . $_POST['name'] . "<BR />Nazwisko: " . $_POST['surname'] . "<BR />E-mail: " . $_POST['e-mail'] . "<BR /><BR />" . $_POST['message'];
					$headers = 'From: ' . $_POST['e-mail'] . "\r\n" .
						'Content-type: text/html; charset=utf-8';

					mail($to, $subject, $message, $headers)
					 or die('<h1 class="animated fadeInUp" >Coś poszło nie tak ;/</h1>');
					 
					 echo('<h1 class="animated fadeInUp" >Wiadomość została wysłana!</h1>');
				?>
			
		
		<a href="StronaGlowna" class="btn center_btn home_screan animated fadeInRight" style="margin:30px auto;">Powrót</a>
		
	</div>	

	

		
</div>  
	

		<script src="script.js"></script>
		

</body>
</html>