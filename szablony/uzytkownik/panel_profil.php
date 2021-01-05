<?php

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
            <h1 class="text-bold-600">Profil Rss - <?php echo $_SESSION['imie']. " " .$_SESSION['nazwisko']; ?></h1>
			<p>Analizuj swoje statystyki oraz wprowadź zmiany w profilu</p>
            <hr>
          </div>
		  
		 <!-- Force next columns to break to new line -->
		<div class="w-100"></div>
		  
 
          
         
          
          <div class="col-lg-5 col-md-12">
              <div class="card" style="">
                <div class="card-content profile-card">
						<img src="app-assets/images/logoCard.png" />
                  <div class="card-body profile-card-border">
                    <h2 class="card-title"><?php echo $_SESSION['imie']." ".$_SESSION['nazwisko']."  ".$plec; ?></h2>
                    <p class="card-text">Standardowy użytkownik RSS</p>
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
                     
					  
					  <div id="heading3" role="tab" class="card-header border-bottom-blue-grey border-bottom-lighten-4 profile-card">
						<a data-toggle="collapse" href="#accordion3" class="h6 collapsed">
						<i class="fas fa-weight"></i><b> Waga:</b> <?php echo $waga; ?></a>
                      </div>
                      <div id="accordion3" class="collapse profile-subcard"  style="">
                        <div class="card-body">
						
						<!-- DODAWANIE WAGI!!! -->
                          <form class="form" method="post" action="">
							<div class="form-body">
								<div class="form-group">
								  <label for="issueinput1">Wprowadź nową wagę [kg]</label></br>
								  <input type="number" name="waga" max="170" pattern="[0-9.]+" required />
								</div>
								<button type="submit" class="btn btn-warning">Zmień wagę</button>
							</div>
						  </form>
                        </div>
                      </div>
					  
					  
					  <div id="heading4" role="tab" class="card-header border-bottom-blue-grey border-bottom-lighten-4 profile-card">
						<a data-toggle="collapse" href="#accordion4" class="h6 collapsed">
						<i class="fas fa-ruler-vertical"></i><b> Wzrost:</b> <?php echo $wzrost; ?></a>
                      </div>
                      <div id="accordion4" class="collapse profile-subcard"  style="">
                        <div class="card-body">
						
						<!-- DODAWANIE WZROSTU!!! -->
                          <form class="form" method="post" action="">
							<div class="form-body">
								<div class="form-group">
								  <label for="issueinput2">Wprowadź nowy wzrost [cm]</label></br>
								  <input type="number" name="wzrost" max="210" pattern="[0-9.]+" required />
								</div>
								<button type="submit" class="btn btn-warning">Zmień wzrost</button>
							</div>
						  </form>
                        </div>
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
                      <a class="nav-link active settings-link" id="activeIcon-tab" data-toggle="tab" href="#activeIcon"><i class="ft-unlock"></i> Zmień hasło</a>
                    </li>
					
					<li class="nav-item">
                      <a class="nav-link settings-link" id="linkIcon-tab" data-toggle="tab" href="#linkIcon" ><i class="la la-link"></i> Inne ustawienia</a>
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
								<button type="submit" class="btn btn-warning">Zmień hasło</button>
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