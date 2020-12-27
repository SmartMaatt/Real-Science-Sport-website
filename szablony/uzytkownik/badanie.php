<?php

	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}

	$badanie = "";
	if($id_opcji  == 1) $badanie = "biofeedback_eeg";
	elseif($id_opcji  == 2) $badanie= "analiza_skladu_ciala";
	elseif($id_opcji  == 3) 
	{
		if($_SESSION['id_podopcji'] == 1)
			$badanie = "test_szybkosci";
		elseif($_SESSION['id_podopcji'] == 2)
			$badanie = "rest_test";
		else
			$badanie = "prowadzenie_pilki";
	}
	elseif($id_opcji  == 4) $badanie = "analizator_kwasu_mlekowego";
	elseif($id_opcji  == 5) $badanie = "wzrostomierz";
	elseif($id_opcji  == 6) $badanie = "beep_test";
	elseif($id_opcji  == 7) $badanie = "opto_jump_test";

	require_once "rozchodniaczki/connect.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		$id_klienta = $_SESSION['id_klienta'];

		echo '<table>';
		echo '<tr>';
		echo '<td>Data</td>';
		echo '<td>Szczegóły</td>';
		echo '</tr>';
		
		$sql = "SELECT id_badania, data FROM $badanie WHERE id_klienta = '$id_klienta'";
		echo $sql;
		if($result = @$connection->query($sql))
		{
			for($i=0; $i < $result->num_rows; $i++)
			{
				$row = $result->fetch_assoc();
				$id_badania = $row['id_badania'];
				$data = $row['data'];
				echo '<tr>';
				echo "<td>$data</td>";
				echo '<td><form action="szablony/uzytkownik/szczegoly_'.$badanie.'.php" method="post">
					  <input type="submit" class="btn btn-danger" value="Wyświetl szczegóły" name='.$id_badania.'/>
					  </form></td>';
				echo '</tr>';
			}		
			$result->free_result();
		}
		echo '</table>';
		
		$connection->close();
	}

?>