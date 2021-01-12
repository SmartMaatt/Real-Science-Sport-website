if(dane_badania != 'nope'){
	
	if(dane_badania[0] == "wykres_porownawczy"){
		
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
					text:dane_badania[1] + " - badanie " + dane_badania[1],
					fontSize: 22
				},
				legend:{
					display: true,
					position: 'left'
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
					text:dane_badania[1] + " - badanie " + dane_badania[1],
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