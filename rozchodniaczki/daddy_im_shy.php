<?php 

	if(isset($_GET['m']) && isset($_GET['msg']) && isset($_GET['p']))
	{
		session_start();
		
		if($_GET['m'] == '2')
		{
			require_once 'connect.php';
			$connection = @new mysqli($host, $db_user, $db_password, $db_name);

			if ($connection->connect_errno == 0) {
				$sql = sprintf("SELECT * FROM klub",
								mysqli_real_escape_string($connection, $mail));

				$result = @$connection->query($sql);

				if ($result) {
					
					$moja_tablica_xd = array();
					while($row = $result->fetch_assoc())
					{
						array_push($moja_tablica_xd, $row['id_klubu'], $row['nazwa']);	
					}
					
					
				}
				else
				{
					header('Location: ../panel_admina.php');
					$_SESSION['error'] = 'loadToast(\'3\',\'Błąd wykonania polecenia SQL!\',\'Command: SELECT * FROM klub\')';
				}
			}
			else
			{
				header('Location: ../panel_admina.php');
				$_SESSION['error'] = 'loadToast(\'3\',\'Błąd bazy danych\',\'Error '.$connection->connect_errno.'\')';
			}
					
		}
		$_SESSION['askMe'] = 'infoCard(\''.$_GET['m'].'\',\''.$_GET['msg'].'\',\''.json_encode($moja_tablica_xd).'\')';
		echo $_SESSION['askMe'];
	}
	
	header('Location: ../logowanie.php');
	
?>