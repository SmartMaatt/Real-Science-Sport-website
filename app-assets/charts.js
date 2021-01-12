function changeLegend(sourceChart){ 
	var w = window.innerWidth;
	console.log(w);
	
	if(w > 992){
		sourceChart.options.legend.display = true;
		sourceChart.options.legend.position = 'left';
	}
	else if((w > 766) && (w < 992)){
		sourceChart.options.legend.display = true;
		sourceChart.options.legend.position = 'bottom';
	}
	else if(w < 766){
		sourceChart.options.legend.display = false;
		sourceChart.options.legend.position = 'bottom';
	}
}



if(dane_badania != 'nope'){
	
	if(dane_badania[0] == "wykres_porownawczy"){
		
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
		
		
		
		let myChart = document.getElementById('RSS_chart').getContext('2d');
		let sourceChart = new Chart(myChart, {
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
		
		setInterval(function() { changeLegend(sourceChart); }, 1000);
	}
	else if(dane_badania[0] == "wykres_szczegolowy"){

		let myChart = document.getElementById('RSS_chart').getContext('2d');
		let sourceChart = new Chart(myChart, {
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




/*
JSON template - porownawczy
{
"Jaki wykres?"	
"Nazwa",
"Data",
"Typ wykresu",
{"labels","tutaj"},
{8,5,4,3,2}
}


JSON template - szczegółowe
{
0"Jaki wykres?"	
1"Nazwa",
2 [data, data, data],
3"Typ wykresu",
4[{jaka fala, [dane,dane,dane]},{jaka fala, [dane,dane,dane]}]
}

length 2 = length 4
*/