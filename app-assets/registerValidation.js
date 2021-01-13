//Validation of inserted date in registration form
function correctDate(element){
	
	//Get tomorrow
    var Tomorrow = new Date();
	Tomorrow.setDate(Tomorrow.getDate() + 1);
	
	//Get past
	var Past = new Date(1900,0,1);
		
	var Today = new Date();
	
	if ((element.value === "") || (new Date(element.value).getTime() > Tomorrow.getTime()) || (new Date(element.value).getTime() < Past.getTime())) {
		element.value = Today.getFullYear().toString() + '-' + (Today.getMonth()+1).toString().padStart(2, '0') + '-' + Today.getDate().toString().padStart(2, '0');
	}
	
}