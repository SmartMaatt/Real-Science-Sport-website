/**
*Asking/informing pop-updateCommands
*message - Additional msg
*mode - type of msg box or closage (-1)
*/
function infoCard(mode, message, ...params){
	let body= document.body;
	let ICC= document.getElementById("ICC");
		
		//Zamknij kartę
		if(mode==-1)
		{
			body.style.overflow= "visible";
			ICC.className="";
			ICC.innerHTML = "";
		}
		//Usuwanie klienta
		else if(mode==0)
		{
			body.style.overflow= "hidden";
			ICC.className="ICC_active";
			ICC.innerHTML = "<div id='infoCard_1' class='infoCard infoCard-admin animate__animated animate__fadeInDown'><i class='ft-alert-triangle'></i><h2>" + message + "</h2><button type='button' class='btn btn-dark btn-min-width mx-auto' onclick='infoCard(\"-1\",\"\")'>Wyjdź</button><a href='rozchodniaczki/admin/usun_klienta.php?id_klienta="+params[0]+"' class='btn btn-danger'>Usuń klienta</a></div>";
		}
		//Usuwanie klubu
		else if(mode==1)
		{
			body.style.overflow= "hidden";
			ICC.className="ICC_active";
			ICC.innerHTML = "<div id='infoCard_1' class='infoCard infoCard-admin animate__animated animate__fadeInDown'><i class='ft-alert-triangle'></i><h2>" + message + "</h2><button type='button' class='btn btn-dark btn-min-width mx-auto' onclick='infoCard(\"-1\",\"\")'>Wyjdź</button><a href='rozchodniaczki/admin/usun_klub.php?id_klubu="+params[0]+"' class='btn btn-danger'>Usuń klub</a></div>";
		}
		//Zmiana klubu
		else if(mode==2)
		{
			var slider = "<form id=\"form-id\" action=\"rozchodniaczki/admin/zmien_klub.php\" method=\"POST\"><fieldset class=\"form-group\"><select class=\"custom-select\" id=\"custom_select\" name=\"id_klubu\" required>";

			for(var i = 1; i < params.length; i=(i+2)){
				slider = slider + "<option value=\"" + params[i] + "\">" + params[i+1] + "</option>";
			}
			slider = slider + "<input type=\"hidden\" value=\"" + params[0] + "\" name=\"id_klienta\" /></select></fieldset></form>";
			
			body.style.overflow= "hidden";
			ICC.className="ICC_active";
			ICC.innerHTML = "<div id='infoCard_1' class='infoCard infoCard-admin animate__animated animate__fadeInDown'><i class=\"fas fa-question\"></i><h2>" + message + "</h2>"+slider+"<button class='btn btn-dark btn-min-width' onclick='infoCard(\"-1\",\"\")'>Wyjdź</button><button class=\"btn btn-danger btn-min-width\" onclick=\"document.getElementById('form-id').submit()\">Zmień</button></div>";
		}		
}