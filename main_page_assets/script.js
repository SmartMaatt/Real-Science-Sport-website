//Zamiast OnLoad ;)
document.addEventListener('DOMContentLoaded', function() {
	changeBar()
	
});


function hamburger(x){
		
		var menu= document.querySelector(".bar");
		
		if(!x.classList.contains("active")){
		x.classList.add("active");
		menu.style.top="48px";
	}else if(x.classList.contains("active")) {
		x.classList.remove("active");
		menu.style.top="-260px";
	};
	}

	setInterval(function(){ 
		if(window.innerWidth > 554){
		document.querySelector(".bar").style="";
	}}, 250)
	
	

	//kropka powrotu na górę
	function changeBar(){
		var dot= document.querySelector(".scrollup");
		var home= document.getElementById("home_screan");
		
		var y= window.pageYOffset;
		
		if(y<0.5*home.offsetHeight) 
		{
			dot.style.opacity="0";
			dot.style.pointerEvents="none";}
				
		else {
			dot.style.opacity="1";
			dot.style.pointerEvents="";
		}
		
	} setInterval(changeBar, 250);
	
	
	
	
	
	
	
	