if(dane_badania != 'nope'){
	
	let myChart = document.getElementById('RSS_chart').getContext('2d');
	let sourceChart = new Chart(myChart, {
		type: dane_badania[2],
		data:{
			labels: dane_badania[3],
			datasets:[{
				label: dane_badania[1],
				data:dane_badania[4]
			}]
		},
		options:{
			title:{
				display: true,
				text:dane_badania[0] + " - badanie " + dane_badania[1],
				fontSize: 22
			},
			legend:{
				display:false,
				position: 'right'
			}
		}
	});
	
}
/*
JSON template
{
"Nazwa",
"Data",
"Typ wykresu",
{"labels","tutaj"},
{8,5,4,3,2}
}
*/