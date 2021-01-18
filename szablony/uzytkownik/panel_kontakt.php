<?php 
	/*SECURED*/
	if (session_status() == PHP_SESSION_NONE) {
		header('Location: ../../logowanie.php');
	}
?>

<!-- reCAPTCHA V3 -->
  <script src="https://www.google.com/recaptcha/api.js?render=6LePmDAaAAAAANPG5K6X_E7geNF1lALQ3oBnCJj6"></script>

<div class="row">
            <div class="col-lg-8 col-12">
              <div class="card">
                <div class="card-header">
                  <h2 class="card-title" id="basic-layout-tooltip">Skontaktuj się z nami</h2>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    </ul>
                  </div>
				   <div class="card-text">
						<p>Skontaktuj się z nami w przypadku niejasności bądź pytań dotyczących badań czy obsługi serwisu jak również ewentualnych błędów które na nim znalazłeś. Będziemy wdzięczni za każdą pomoc oraz krytykę.
						</p>
                    </div>
                </div>
                <div class="card-content">
                  <div class="card-body pt-0">
                   
					
					
					
					
					
					
                    <form class="form" id="panel_kontakt" action="rozchodniaczki/panel_mail.php" method="post">
                      <div class="form-body">
                        <div class="form-group">
							<label for="issueinput1">Tematyka</label>
								<fieldset class="form-group">
									<select class="custom-select" id="customSelect" form="panel_kontakt" name="tematyka_maila" required>
										<option value="Pytanie do działu RSS">Pytanie do działu RSS</option>
										<option value="Pytanie do działu technicznego">Pytanie do działu technicznego</option>
										<option value="Biofeedback EEG">Biofeedback EEG</option>
										<option value="Analiza składu ciała">Analiza składu ciała</option>
										<option value="Fotokomórki">Fotokomórki</option>
										<option value="Analizator kwasu mlekowego">Analizator kwasu mlekowego</option>
										<option value="Wzrostomierz">Wzrostomierz</option>
										<option value="Beep test">Beep test</option>
										<option value="Opto jump next">Opto jump next</option>
										<option value="Inne">Inne...</option>
									</select>
								</fieldset>
						</div>
                        <div class="form-group">
                          <label for="issueinput2">Tytuł</label>
                          <input type="text" id="issueinput2" class="form-control" placeholder="Tytuł maila" name="tytul_maila" required>
                        </div>
                        
                        
                        
                        <div class="form-group">
                          <label for="issueinput3">Treść</label>
                          <textarea id="issueinput8" rows="8" class="form-control" name="tresc_maila" placeholder="Treść maila" style="margin-top: 0px; margin-bottom: 0px; height: 185px;" required></textarea>
                        </div>
                      </div>
					  <input type="hidden" name="token" id="token" required>
                      <div class="form-actions">
                        
                        <button type="submit" class="btn btn-success">Wyślij</button>
						<button type="reset" class="btn btn-warning mr-1">Wyczyść</button>
                      </div>
                    </form>
					
					<!-- reCAPTCHA V3 -->
				   <script>
				   $('#panel_kontakt').submit(function() {
						event.preventDefault();
						grecaptcha.ready(function() {
						  grecaptcha.execute('6LePmDAaAAAAANPG5K6X_E7geNF1lALQ3oBnCJj6', {action: 'homepage'}).then(function(token) {
							  document.getElementById("token").value = token;
							  document.getElementById("panel_kontakt").submit();
						  });
						});
					});
				  </script>
					
                  </div>
                </div>
              </div>
            </div>
			
			
			
			<div class="col-lg-4 col-12">
            <div class="card profile-card-with-cover">
              <div class="card-profile-image">
                <img src="app-assets/images/logoCard.png" width="150px" class="rounded-circle img-border box-shadow-1" alt="RSS logo">
              </div>
			  <hr>
              <div class="profile-card-with-cover-content text-center">
                <div class="card-body-small">
                  <h4 class="card-title">Real Science Sport</h4>
                  <ul class="list-inline list-inline-pipe">
                    <li>@real.science.sport</li>
                    <li>realsciencesport.com</li>
                  </ul>
                  <h6 class="card-subtitle text-muted">Media społecznościowe</h6>
                </div>
                <div class="text-center mt-1">
                  <a href="https://www.facebook.com/RealScienceSport/" target="_blank" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook">
                    <span class="la la-facebook"></span>
                  </a>
                  <a href="https://www.instagram.com/real.science.sport/" target="_blank" class="btn btn-social-icon mr-1 mb-1 btn-outline-instagram">
                    <span class="la la-instagram"></span>
                  </a>
                  <a href="http://www.realsciencesport.com/" target="_blank" class="btn btn-social-icon mr-1 mb-1 btn-outline-rss">
                    <span class="la la-globe font-medium-4"></span>
                  </a>
                  
                </div>
              </div>
            </div>
          </div>
       
	   
          </div>