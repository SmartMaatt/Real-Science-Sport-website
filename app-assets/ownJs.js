document.addEventListener('DOMContentLoaded', function() {
correctForms();	
});

//Insert only numbers
function onlyNumber(input) {
    var insertWord = input.value;

    insertWord = insertWord.toUpperCase();
    insertWord = insertWord.replaceAll("[^0-9']+", "");
    insertWord = insertWord.replace(/[A-Z' '&\/\\#,+()$~%.'":*?<>{}]/g, '');
    insertWord.trim();

    input.value = insertWord;
}

//Load toast using params
	function loadToast(type, header, bottom){
		if(type == 0){
			toastr.success(bottom, header);
		}else if(type == 1){
			toastr.info(bottom, header);
		}else if(type == 2){
			toastr.warning(bottom, header);
		}else if(type == 3){
			toastr.error(bottom, header);
		}
	}

//Załaduj nową opcję
function nowaOpcja(opcja, podopcja){
	document.getElementById('nowyIdOpcjiInput').setAttribute("value", opcja);
	document.getElementById('nowyIdPodopcjiInput').setAttribute("value", podopcja);
	document.getElementById('nowyIdOpcji').submit();	
}

//Wprowadza dane czasu do formularzy rezerwacji
function correctForms()
{
//Uzupełnienie daty	
correctDate(document.getElementById('zamowienie_data'));

//Uzupełnienie godziny
correctFirstTime(document.getElementById('zamowienie_start'));
correctSecondTime(document.getElementById('zamowienie_koniec'));
}

//Sprawdzenie poprawnosci daty formularza
function correctDate(element)
{
    var Time = new Date();
	
	if(element.value !== "")
	{
		if (new Date(element.value).getTime() < Time.getTime()) 
		{
			element.value = Time.getFullYear().toString() + '-' + (Time.getMonth()+1).toString().padStart(2, '0') + '-' + Time.getDate().toString().padStart(2, '0');
		 }
	}
	else
	{
		element.value = Time.getFullYear().toString() + '-' + (Time.getMonth()+1).toString().padStart(2, '0') + '-' + Time.getDate().toString().padStart(2, '0');
	}
}

//Sprawdzenie poprawności godziny złożenia
function correctFirstTime(element)
{
	
 var Time = new Date();	
	
 if (element.value !== "") 
	{
		var hours = element.value.split(":")[0];
		var minutes = element.value.split(":")[1];
		
		if(hours > 21)
			element.value = "21:00";
		else if(hours < 6)
			element.value = "06:00";
		else
			element.value = hours + ":00";
		
		hours = element.value.split(":")[0];
		var secondTime = document.getElementById('zamowienie_koniec');
		if(hours >= secondTime.value.split(":")[0])
		{
			console.log(secondTime.value);
			hours = (parseInt(hours)+1).toString().padStart(2, '0');
			secondTime.value = hours + ":00";
			correctSecondTime(secondTime);
		}
		
	}
	else
	{
		if(Time.getHours() > 21)
			element.value = "21:00";
		else if(Time.getHours() < 6)
			element.value = "06:00";
		else
			element.value = Time.getHours().toString().padStart(2, '0') + ":00";
	}
}

//Sprawdzenie poprawności godziny zakończenia
function correctSecondTime(element)
{
	 var Time = new Date();	
	
 if (element.value !== "") 
	{
		var hours = element.value.split(":")[0];
		var minutes = element.value.split(":")[1];
		
		if(hours > 22)
			element.value = "22:00";
		else if(hours < 7)
			element.value = "07:00";
		else
			element.value = hours + ":00";
		
		hours = element.value.split(":")[0];
		var firstTime = document.getElementById('zamowienie_start');
		
		if(hours <= firstTime.value.split(":")[0])
		{
			console.log(firstTime.value);
			hours = (parseInt(hours)-1).toString().padStart(2, '0');
			firstTime.value = hours + ":00";
			correctFirstTime(firstTime);
		}
		
	}
	else
	{
		if(Time.getHours() > 22)
			element.value = "22:00";
		else if(Time.getHours() < 7)
			element.value = "07:00";
		else
			element.value = (Time.getHours()+1).toString().padStart(2, '0') + ":00";
	}
}

//Sprawdzenie poprawności nr tel
function correctPhone(evt) {
  var theEvent = evt || window.event;

  // Handle paste
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}


//Wyświetla informacje zamówienia toru
function infoCardAlley(mode, numberos, time, name, surname, call, mail, exit )
{	
		let body= document.body;
		let ICC= document.getElementById("ICC");
		let text = "";
		
		if(mode==1) text = "Thor";
		else if(mode==2) text = "Stół";
		else if(mode==3) text = "Stolik";
		
		if(exit==0)
		{
			body.style.overflow= "hidden";
			ICC.className="ICC_active";
			ICC.innerHTML = "<div id='infoCard_0' class='infoCard animate__animated animate__fadeInDown'><ul><li><h2><b>" + text + ":</b> " + numberos + "</h2></li><li><h2><b>Godzina:</b> " + time + "-" + (time+1) + "</h2></li><li><h2><b>Klient:</b> " + name + " " + surname + "</h2></li><li><h2><b>Telefon:</b> " + call + "</h2></li><li><h2><b>Mail:</b> " +mail+ "</h2></li></ul><button type='button' class='btn btn-dark btn-min-width' onclick='infoCardAlley(0,0,0,0,0,0,0,1)'>Wyjdź</button><button type='button' class='btn btn-danger btn-min-width' onclick='deleteReservation(" + numberos + "," + time + ")'>Usuń zamówienie</button></div>";
		}
		else if(exit==1)
		{
			body.style.overflow= "visible";
			ICC.className="";
			ICC.innerHTML = "";
		}
}


//Przygotowanie usuwania rezerwacji
function deleteReservation(numberos, time)
{
	document.getElementById('infoCard_0').innerHTML += '<form style="display:none;" position="absolute" method="POST" action="rozchodniaczki/usun_rezerwacje.php"><input type="text" name="nr_porzadkowy" value="' + numberos + '" /><input type="text" name="godzina" value="' + time + '" /><input id="redirbtn" type="submit"></form>';
	document.getElementById('redirbtn').click();
}


//Wiadomosc powodzenia/braku dostepu do bazy
function infoCardDataBase(message, mode)
{
	let body= document.body;
	let ICC= document.getElementById("ICC");
		
		//Dodawanie nie powiodlo sie
		if(mode==0)
		{
			body.style.overflow= "hidden";
			ICC.className="ICC_active";
			ICC.innerHTML = "<div id='infoCard_1' class='infoCard animate__animated animate__fadeInDown'><i class='ft-alert-triangle'></i><h2>" + message + "</h2><button type='button' class='btn btn-dark btn-min-width mx-auto' onclick='infoCardDataBase(0, 2)'>Wyjdź</button></div>";
		}
		//Dodawanie powiodło sie
		else if(mode==1)
		{
			body.style.overflow= "hidden";
			ICC.className="ICC_active";
			ICC.innerHTML = "<div id='infoCard_1' class='infoCard animate__animated animate__fadeInDown'><i class='ft-check-circle'></i><h2>" + message + "</h2><button type='button' class='btn btn-dark btn-min-width mx-auto' onclick='infoCardDataBase(0, 2)'>Wyjdź</button></div>";
		}
		//Zamknij karte
		else if(mode==2)
		{
			body.style.overflow= "visible";
			ICC.className="";
			ICC.innerHTML = "";
		}
}



