<?php

	/*SECURED*/
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}

	$plec = "";
	if($_SESSION['plec'] == "m"){
		$plec = '<i class="fas fa-mars"></i>';
	}
	elseif($_SESSION['plec'] == "k"){
		$plec = '<i class="fas fa-venus"></i>';
	}
	
	$waga = "80kg";
	$wzrost = "180cm";
 ?>




<section id="user-profile-cards" class="row mt-2">
          <div class="col-10 col-md-6">
            <h1 class="text-bold-600">Profil Admin RSS - <?php echo $_SESSION['imie']. " " .$_SESSION['nazwisko']; ?></h1>
			<p>Zarządzaj klientami oraz ich badaniami</p>
            <hr>
          </div>
		  
		 <!-- Force next columns to break to new line -->
		<div class="w-100"></div>
		  
 
          
         
          
          <div class="col-lg-5 col-md-12">
              <div class="card" style="">
                <div class="card-content profile-card">
						<img src="app-assets/images/logoCard-admin.png" />
                  <div class="card-body profile-card-border-admin">
                    <h2 class="card-title"><?php echo $_SESSION['imie']." ".$_SESSION['nazwisko']."  ".$plec; ?></h2>
                    <p class="card-text">Administrator panelu RSS</p>
                  </div>
				  
				  
                    <div class="card collapse-icon panel mb-0 box-shadow-0">
					
                      <div id="heading1" role="tab" class="card-header border-bottom-blue-grey border-bottom-lighten-4 profile-card">
						<a href="#" class="h6">
						<i class="fa ft-mail m-corr"></i><b> E-mail:</b> <?php echo $_SESSION['mail']; ?></a>
                      </div>
                      
					  
					  <div id="heading2" role="tab" class="card-header border-bottom-blue-grey border-bottom-lighten-4 profile-card">
						<a href="#" class="h6">
						<i class="fa fa-birthday-cake m-corr"></i><b> Data urodzenia:</b> <?php echo $_SESSION['data_urodzenia']; ?></a>
                      </div>
                      					  
                    </div>
				  
                </div>
              </div>
            </div>
			
			
			
			
			<div class="col-lg-7 col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Ustawienia</h4>
                </div>
                <div class="card-body">
                  <ul class="nav nav-tabs nav-justified">
                    
                    <li class="nav-item">
                      <a class="nav-link active settings-link-admin" id="activeIcon-tab" data-toggle="tab" href="#activeIcon"><i class="ft-unlock"></i> Zmień hasło</a>
                    </li>
					
					<li class="nav-item">
                      <a class="nav-link settings-link-admin" id="linkIcon-tab" data-toggle="tab" href="#linkIcon" ><i class="la la-link"></i> Inne ustawienia</a>
                    </li>
					
                  </ul>
				  
                  <div class="tab-content px-1 pt-1">
                    <div role="tabpanel" class="tab-pane active" id="activeIcon">
					   <form class="form" method="post" action="rozchodniaczki/zmien_haslo.php">
							<div class="form-body">
								<div class="form-group">
								  <label for="issueinput1">Stare hasło</label></br>
								  <input type="password" name="stare_haslo" required />
								</div>
								<div class="form-group">
								  <label for="issueinput2">Wprowadź nowe hasło</label></br>
								  <input type="password" name="nowe_haslo1" required />
								</div>
								<div class="form-group">
								  <label for="issueinput3">Wprowadź nowe hasło</label></br>
								  <input type="password" name="nowe_haslo2" required />
								</div>
								<button type="submit" class="btn btn-info">Zmień hasło</button>
							</div>
						  </form>
                    </div>
					
                    <div class="tab-pane" id="linkIcon" role="tabpanel">
                      <p>Pusto tu... narazie</p>
                    </div>
					
                  </div>
                </div>
              </div>
            </div>
	</section>