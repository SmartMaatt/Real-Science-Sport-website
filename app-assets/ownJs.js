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