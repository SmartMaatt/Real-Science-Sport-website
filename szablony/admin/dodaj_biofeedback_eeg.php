<?php 
	/*SECURED*/
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}
?>


<div class="row">
	<div class="col-12">
	  <div class="card">
		<div class="card-header">
		  <h2 class="card-title" id="basic-layout-tooltip">Biofeedback EEG</h2>
		  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
		   <div class="card-text">
				<p>Załącz arkusz excel w celu dodania badań Biofeedback EEG</p>
			</div>
		</div>
		<div class="card-content">
		  <div class="card-body pt-0">
		   
			
			<div class="container">
			
				<h1>Drop zone</h1>
				<form action="rozchodniaczki/upload_excel.php" class="dropzone" id="dropzoneFrom">

				</form>
			  
				<div>
					<button type="button" class="btn btn-info mt-1" id="submit-all">Upload</button>
				</div>
			
			</div>
			
			
		  </div>
		</div>
	  </div>
	</div>
</div>