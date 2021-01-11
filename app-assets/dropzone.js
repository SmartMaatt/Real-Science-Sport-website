$(document).ready(function(){

var maximumFiles = 1;
 
//Ustawienia dropzone'a
Dropzone.options.dropzoneFrom = {
	 
	//Automatyczne przetwarzanie kolejki
	autoProcessQueue: false,
	
	//Dozwolone rozszerzenia (w oknie dialogowym)
	acceptedFiles:".xlsx",
	
	maxFiles: maximumFiles,
  
	//Funkcja inicjalizacyjna
	init: function(){
		
		//Element akceptujący formularz oraz obszar dropzone
		var submitButton = document.querySelector('#submit-all');
		myDropzone = this;
		
		//Przetwarzanie plików po kliknieciu przycisku
		submitButton.addEventListener("click", function(){
			myDropzone.processQueue();
		});
		
		//Usuwanie plików + wyświetlenie komunikatu gdy przykroczony limit plików.
		this.on("maxfilesexceeded", function(file){
			toastr.warning('Maksymalna ilość plików do przetworzenia to '+maximumFiles+' !');
			this.removeFile(file);
		});
		
		//Gdy przetwarzanie skończone, wyczyść dropzone
		this.on("complete", function(){
			if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0){
				this.removeAllFiles();
				$( "#dropzoneFrom" ).submit();
			}
			//list_image();
		});
	},
  
};

/*
 list_image();

 function list_image()
 {
  $.ajax({
   url:"upload.php",
   success:function(data){
    $('#preview').html(data);
   }
  });
 }

 $(document).on('click', '.remove_image', function(){
  var name = $(this).attr('id');
  $.ajax({
   url:"upload.php",
   method:"POST",
   data:{name:name},
   success:function(data)
   {
    list_image();
   }
  })
 });
*/
 
});