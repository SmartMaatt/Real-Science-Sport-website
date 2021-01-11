//EXECUTE ON START
document.addEventListener('DOMContentLoaded', function() {
});

/**
*Load toast using params
*type [0] green/succes, [1] blue/info, [2] yellow/warning, [3] red/error
*header Header of toast
*bottom Main text of toast
*/
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
			ICC.innerHTML = "<div id='infoCard_1' class='infoCard infoCard-admin animate__animated animate__fadeInDown'><i class='ft-alert-triangle'></i><h2>" + message + "</h2><button type='button' class='btn btn-dark btn-min-width mx-auto' onclick='infoCard(\"-1\",\"\")'>Wyjdź</button><a href='rozchodniaczki/usun_klienta.php?id_klienta="+params[0]+"' class='btn btn-danger'>Usuń klienta</a></div>";
		}
		//Usuwanie klubu
		else if(mode==1)
		{
			body.style.overflow= "hidden";
			ICC.className="ICC_active";
			ICC.innerHTML = "<div id='infoCard_1' class='infoCard infoCard-admin animate__animated animate__fadeInDown'><i class='ft-alert-triangle'></i><h2>" + message + "</h2><button type='button' class='btn btn-dark btn-min-width mx-auto' onclick='infoCard(\"-1\",\"\")'>Wyjdź</button><a href='rozchodniaczki/usun_klub.php?id_klubu="+params[0]+"' class='btn btn-danger'>Usuń klub</a></div>";
		}
		else if(mode==2)
		{
			var slider = 
			
			
			body.style.overflow= "hidden";
			ICC.className="ICC_active";
			ICC.innerHTML = "<div id='infoCard_1' class='infoCard infoCard-admin animate__animated animate__fadeInDown'><i class='ft-alert-triangle'></i><h2>" + message + "</h2><button type='button' class='btn btn-dark btn-min-width mx-auto' onclick='infoCard(\"-1\",\"\")'>Wyjdź</button><a href='rozchodniaczki/usun_klub.php?id_klubu="+params[0]+"' class='btn btn-danger'>Usuń klub</a></div>";
		}
		
}




