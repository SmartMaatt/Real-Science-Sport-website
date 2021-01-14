<?php
	$data_urodzenia = $_SESSION['data_urodzenia'];
	$rok_urodzenia = date('Y', strtotime($data_urodzenia));
	$obecny_rok = date("Y");
	$wiek_rocznikowo = (int)($obecny_rok - $rok_urodzenia);
	
	$wiadomosc = "";
	$between_down = "$rok_urodzenia-01-01";
	$between_up = "$rok_urodzenia-12-31";
	
	switch($wiek_rocznikowo){
		case 0:
		case 1:
		case 2:
		case 3:
		case 4:
		case 5:
		case 6:
		case 7:
			$wiadomosc = "do siedemiu lat";
		break;
		case 8:
			$wiadomosc = "osiem lat";
		break;
		
		case 9:
			$wiadomosc = "dziewieć lat";
		break;
		
		case 10:
			$wiadomosc = "dziesieć lat";
		break;
		
		case 11:
			$wiadomosc = "jedenaście lat";
		break;
		
		case 12:
			$wiadomosc = "dwanaście lat";
		break;
		
		case 13:
			$wiadomosc = "trzynaście lat";
		break;
		
		case 14:
			$wiadomosc = "czternaście lat";
		break;
		
		case 15:
			$wiadomosc = "piętnaście lat";
		break;
		
		case 16:
			$wiadomosc = "szesnaście lat";
		break;
		
		case 17:
			$wiadomosc = "siedemnaście lat";
		break;
		
		case 18:
			$wiadomosc = "osiemnascie lat";
		break;
		
		case 19:
			$wiadomosc = "dziewietnaście lat";
		break;
		
		case 20:
			$wiadomosc = "dwadzieścia lat";
		break;
		
		case 21:
		case 22:
		case 23:
		case 24:
		case 25:
			$dolna_data = $obecny_rok - 25;
			$gorna_data = $obecny_rok - 21;
			$between_down = "$dolna_data-01-01";
			$between_up = "$gorna_data-12-31";
			$wiadomosc = "[dwadzieścia jeden - dwadzieścia pięć] lat";
		break;
		
		case 26:
		case 27:
		case 28:
		case 29:
		case 30:
			$dolna_data = $obecny_rok - 30;
			$gorna_data = $obecny_rok - 26;
			$between_down = "$dolna_data-01-01";
			$between_up = "$gorna_data-12-31";
			$wiadomosc = "[dwadzieścia sześć - trzydzieści] lat";
		break;	
		
		default:
			$dolna_data = $obecny_rok - 31;
			$gorna_data = 1900;
			$between_down = "$dolna_data-01-01";
			$between_up = "$gorna_data-12-31";
			$wiadomosc = "powyżej trzydziestu jeden lat";
	}