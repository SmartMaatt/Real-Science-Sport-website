//Funkcja zarządza wyświetlaniem wykresów w zależności od wielkości ekranu
function zmienLegende(glownyWykres){ 
	var w = window.innerWidth;
	
	if(w > 992){
		glownyWykres.options.legend.display = true;
		glownyWykres.options.legend.position = 'left';
	}
	else if((w > 766) && (w < 992)){
		glownyWykres.options.legend.display = true;
		glownyWykres.options.legend.position = 'bottom';
	}
	else if(w < 766){
		glownyWykres.options.legend.display = false;
		glownyWykres.options.legend.position = 'bottom';
	}
}

//Czy plik otrzymał JSON?
if(dane_badania != 'nope'){
	
	if(dane_badania[0] == "wykres_porownawczy"){
		
		
		//Responsywaność wykresów porównawczych
		var w = window.innerWidth;
		var d = true;
		var p = 'left';
		
		if((w > 766) && (w < 992)){
			d = true;
			p = 'bottom';
		}
		else if(w < 766){
			d = false;
			p = 'bottom';
		}
		
		let mojWykres = document.getElementById('RSS_chart').getContext('2d');
		let glownyWykres = new Chart(mojWykres, {
			type: dane_badania[3],
			data:{
				labels: dane_badania[2],
				datasets: dane_badania[4]
			},
			options:{
				title:{
					display: false,
					text:dane_badania[1],
					fontSize: 22
				},
				legend:{
					display: d,
					position: p
				},
				scales: {
				yAxes: [{
					ticks: {
						suggestedMin: 0
					}
				}]
			}
			}
		});	
		
		//Odświeżanie statusu co sekundę
		setInterval(function(){zmienLegende(glownyWykres);}, 1000);
	}
	else if(dane_badania[0] == "wykres_szczegolowy"){

		let mojWykres = document.getElementById('RSS_chart').getContext('2d');
		let glownyWykres = new Chart(mojWykres, {
			type: dane_badania[3],
			data:{
				labels: dane_badania[4],
				datasets:[{
					label: dane_badania[2],
					data:dane_badania[5],
					backgroundColor: 'rgba(247, 172, 37, 0.7)'
				}]
			},
			options:{
				title:{
					display: false,
					text:dane_badania[1] + " - badanie " + dane_badania[2],
					fontSize: 22
				},
				legend:{
					display: false,
					position: 'right'
				},
				scales: {
				yAxes: [{
					ticks: {
						suggestedMin: 0
					}
				}]
			}
			}
		});
	}
}