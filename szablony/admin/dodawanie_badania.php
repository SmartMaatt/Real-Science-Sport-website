<?php 
	/*SECURED*/
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}
	
	$id_opcji = 
	$id_podopcji = $_SESSION['id_podopcji'];
	$id_badania = $_SESSION['id_badania'];
	$tytul = "";
	$badanie = "";
	switch ($_SESSION['id_opcji'])
	{
    case 1:
        $tytul = "Biofeedback EEG";
		$badanie = "biofeedback_eeg";
        break;
    case 2:
        $tytul = "Analiza składu ciała";
		$badanie = "analiza_skladu_ciala";
        break;
    case 3:
        if($_SESSION['id_podopcji'] == 1)
		{
			$tytul = "Test szybkości";
			$badanie = "test_szybkosci";
		}
		elseif($_SESSION['id_podopcji'] == 2)
		{
			$tytul = "Rast test";
			$badanie = "rast_test";
		}
		else
		{
			$tytul = "Prowadzenie piłki";
			$badanie = "prowadzenie_pilki";
		}
        break;
	case 4:
        $tytul = "Analizator kwasu mlekowego";
		$badanie = "analizator_kwasu_mlekowego";
        break;
	case 5:
        $tytul = "Wzrostomierz";
		$badanie = "wzrostomierz";
        break;
	case 6:
        $tytul = "Beep test";
		$badanie = "beep_test";
        break;
	case 7:
        $tytul = "Opto jump next";
		$badanie = "opto_jump_next";
        break;
	}
?>


<div class="row">
	<div class="col-12">
	  <div class="card">
		<div class="card-header">
		  <h2 class="card-title" id="basic-layout-tooltip"><?php echo $tytul; ?></h2>
		  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
		   <div class="card-text">
				<p>Załącz arkusz excel w celu dodania badania <?php echo $tytul; ?></p>
			</div>
		</div>
		<div class="card-content">
		  <div class="card-body pt-0">
			
			<div class="px-2">
				<h1>Drop zone</h1>
				<form action="rozchodniaczki/admin/przeslij_excel.php" method="POST" class="dropzone" id="dropzoneFrom" enctype="multipart/form-data">
					<input type="hidden" name='badanie' value="<?php echo $badanie; ?>" />
				</form>
				<input type="submit" class="btn btn-info mt-1" id="submit-all" value="Dodaj" />
			</div>
			
		  </div>
		</div>
	  </div>
	</div>
</div>