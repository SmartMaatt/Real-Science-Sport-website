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
*Load new dynamic card on user panel
*opcja Main option chosen from avaible [1-7] tests [11] profile [12] options [13] e-mail
*podopcja Selection of chosen test, default [0]
*/
function nowaOpcja(opcja, podopcja){
	document.getElementById('nowyIdOpcjiInput').setAttribute("value", opcja);
	document.getElementById('nowyIdPodopcjiInput').setAttribute("value", podopcja);
	document.getElementById('nowyIdOpcji').submit();	
}