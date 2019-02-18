<?php 
	include_once 'header.php';	
?>

<div class="container mt-3">

	<!-- BEGIN SECCION TITULO -->
	<div class="row mt-3 mb-3">
		<div class="col-sm-6">
			<div class="titulo border-bottom border-info text-default text-uppercase">Estadísticas</div>
		</div>
	</div>
	<!-- END SECCION TITULO -->
</div>

<!-- BEGIN SECCION NOTA DESTACADA -->
<div class="container-fluid p-3 bg-light imagen-estadisticas" style="background-image: url('https://picsum.photos/1000/260?auto=yes&bg=666&fg=444&text=banner');">
	<div class="row" >
		<div class="offset-sm-4 col-sm-4 align-self-center" style="background: rgba(0,0,0,0.5)">
			<div class="row p-3">
				<div class="col-12">
					<div class="row">
						<div class="col-4 pr-0">
							<h3 class="subtitulo text-white text-uppercase text-right text-info fz80">10</h3>
						</div>
						<div class="col-8">
							<h3 class="subtitulo text-white text-uppercase text-info font-italic fz32">Casos investigados</h3>
						</div>
					</div>
				</div>
				<div class="col-5">
					<div class="bg-light text-info fz80 text-center p-3 lupa" style="margin-bottom:-15px; "><i class="fas fa-search"></i></div>
				</div>
				<div class="col-7 text-center ">
					<p class="text-uppercase text-white fz12 d-block flex-grow-1">por el observatorio hasta:</p>
					<div class="d-flex">
						<div>
							<span class="fechas-circulos mr-2"><?php echo date('d'); ?></span>
							<span class="text-center text-white mr-2 fz12">DÍA</span>
						</div>
						<div>						
							<span class="fechas-circulos mr-2"><?php echo date('m'); ?></span>
							<span class="text-center text-white mr-2 fz12">MES</span>
						</div>
						<div>
							<span class="fechas-circulos"><?php echo date('y'); ?></span>
							<span class="text-center text-white fz12">AÑO</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END SECCION NOTA DESTACADA -->

		
<div class="container">
	<!-- BEGIN SECCION ANTECEDENTES -->
	<div class="row mt-3">
		<div class="col-sm-6">
			<h1 class="titulo border-bottom bormorado morado text-uppercase">etapa actual del caso</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-12 mt-5">
			<h6 class="border-top bormorado morado pt-2 pb-2 font-weight-bold">Examen de contraloría</h6>
			<div class="row no-gutters">
				<div class="col-6">
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
				</div>
				<div class="col-6">
					<canvas id="barChart" width="400" height="150"></canvas>
				</div>
			</div>
		</div>
		<div class="col-12 mt-5">
			<h6 class="border-top bormorado morado pt-2 pb-2 font-weight-bold">Proceso judicial</h6>
			<div class="row no-gutters">
				<div class="col-6">
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
				</div>
				<div class="col-6">
					<canvas id="barChart2" width="400" height="210"></canvas>
				</div>
			</div>
		</div>
		<div class="col-12 mt-5">
			<h6 class="border-top bormorado morado pt-2 pb-2 font-weight-bold">Investigación periodística</h6>
			<div class="row no-gutters">
				<div class="col-6">
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
					<p class="pb-0 mb-0 fz30 text-secondary border-bottom border-secondary text-uppercase text-right"><span class="mr-3">Auditoría</span></p>
				</div>
				<div class="col-6">
					<canvas id="barChart3" width="400" height="150"></canvas>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">

        setupChart('barChart', 11, ["3", "3", "2", "1", "1"], 148, 213,0);
		setupChart('barChart2', 91,["20", "18", "15", "12", "11", "8", "5"],148, 213,0);
		setupChart('barChart3', 110,["40", "30", "20", "10", "1"], 148, 213,0);


		function setupChart(chartId, totalcasos, arreglocasos, colR, colG, colB ) {
		  var canvas = document.getElementById(chartId);
		  var context = canvas.getContext('2d');	

	        //El total de casos por tipo va a ser el 100 y 
	        //cada subtipo sera calculado con regla de 3 
	        //para ir dibujando cada barra
	        
	        var datos = [];
	        var fondos = [];

	        fLen = arreglocasos.length;
	        for (i = 0; i < fLen; i++) {
			  datos.push(Math.round((arreglocasos[i]*100)/totalcasos));
			  c1 = colR - i * 10;
			  c2 = colG - i * 10;
			  c3 = colB;
			  fondos.push('rgba(' + c1 + ',' + c2 + ',' + c3 + ', 1)')
			}
	        	
			console.log(datos)

	          var horizontalBarChartData = {
	              labels: datos,
	              datasets: [{
	                  backgroundColor: fondos,
	                  data: datos
	              }]

	          };
	          //var ctx = document.getElementById("barChart").getContext("2d");
	          var myHorizontalBar = new Chart(context, {
	              type: 'horizontalBar',
	              data: horizontalBarChartData,
	              options: {
	                  scales: {
	                  	xAxes: [{
	                  		display: false,
				            gridLines: {
				                offsetGridLines: false,
				                display: false,
				                drawOnChartArea: false,
				                drawTicks: false,
				                show: false,
				                drawBorder: false,
				            },
				            scaleShowGridLines: {
				            	display: false,
				            }
				        }],
	                    yAxes:[{
	                    	display: false,
	                    	gridLines: {
				                ffsetGridLines: false,
				                display: false,
				                drawOnChartArea: false,
				                drawTicks: false,
				                show: false,
				                drawBorder: false,
				            },
				            scaleShowGridLines: {
				            	display: false,
				            },
	                        barThickness: 30,
	                        ticks: {
	                            beginAtZero:false,
	                            mirror: true,
	                        },
	                    }],
	                  },
	                  responsive: false,
	                  legend: {
	                      display: false,
	                  },
	                  title: {
	                      display: false,
	                      text: ''
	                  },
	                animation: {
	                  duration: 1,
					    onComplete () {
					      const chartInstance = this.chart;
					      const ctx = chartInstance.ctx;
					      const dataset = this.data.datasets[0];
					      const meta = chartInstance.controller.getDatasetMeta(0);

					      Chart.helpers.each(meta.data.forEach((bar, index) => {
					        const label = this.data.labels[index]+'%';
					        const labelPositionX = 5;
					        const labelWidth = ctx.measureText(label).width + labelPositionX;

					        ctx.textBaseline = 'middle';
					        ctx.textAlign = 'left';
					        ctx.fillStyle = '#fff';
					        ctx.fillText(label, labelPositionX, bar._model.y);
					      }));
					    }
					  }
	              }
	          });
	        }
	</script>
	<!-- END SECCION ANTECEDENTES -->

	<!-- BEGIN SECCION DIAGRAMA INFERIOR -->
	<div class="row mt-5">
		<div class="col-sm-6">
			<h1 class="titulo border-bottom bormorado morado text-uppercase">etapa actual del caso</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-7 mt-5">
			<div><canvas id="periodistica" class="m-100 h-100" height="400px"></canvas></div>
		</div>
		<div class="col-sm-5 mt-5 align-self-center">
			<p class="text-secondary text-uppercase"><span class="p-1 text-white mr-3 d-inline-block" style="background: #400a99;width: 100px;">66%</span>Función legislativa</p>
			<p class="text-secondary text-uppercase"><span class="p-1 text-white mr-3 d-inline-block" style="background: #5a16a3;width: 100px;">66%</span>Función ejecutiva</p>
			<p class="text-secondary text-uppercase"><span class="p-1 text-white mr-3 d-inline-block" style="background: #834db8;width: 100px;">66%</span>Función judicial</p>
			<p class="text-secondary text-uppercase"><span class="p-1 text-white mr-3 d-inline-block" style="background: #a87dcc;width: 100px;">66%</span>Función electoral</p>
			<p class="text-secondary text-uppercase"><span class="p-1 text-white mr-3 d-inline-block" style="background: #ccafe0;width: 100px;">66%</span>Función de transparencia y control social</p>
		</div>
	</div>
	
	<script type="text/javascript">

		setupChart('periodistica', 50, 40, 60, 20, 10);
		function setupChart(chartId, flegislativo, fejecutivo, fjudicial, felectoal, ftransparencia ) {
		  var canvas = document.getElementById(chartId);
		  var context = canvas.getContext('2d');

		  var remaining = 100 - flegislativo;
		  var remaining2 = 100 - fejecutivo;
		  var remaining3 = 100 - fjudicial;
		  var remaining4 = 100 - felectoal;
		  var remaining5 = 100 - ftransparencia;

		  var data = {
		    labels: [ 'Función Legislativa', 'Función Ejecutiva', 'Función Judicial', 'Función Electoral', 'Función de Transparencia y Control Social' ],
		    datasets: [{
		      data: [flegislativo, remaining],
		      backgroundColor: [
		        '#400a99',
		        '#fff'
		      ],borderWidth: 1,
		      borderColor: [
		        '#400a99',
		        '#ccc'
		      ],
		      hoverBackgroundColor: [
		        '#400a99',
		        '#FFFFFF'
		      ]
		    },{
		      data: [fejecutivo, remaining2],
		      backgroundColor: [
		        '#5a16a3',
		        '#fff'
		      ],borderWidth: 1,
		      borderColor: [
		        '#5a16a3',
		        '#ccc'
		      ],
		      hoverBackgroundColor: [
		        '#5a16a3',
		        '#FFFFFF'
		      ]
		    },{
		      data: [fjudicial, remaining3],
		      backgroundColor: [
		        '#834db8',
		        '#fff'
		      ],borderWidth: 1,
		      borderColor: [
		        '#834db8',
		        '#ccc'
		      ],
		      hoverBackgroundColor: [
		        '#834db8',
		        '#FFFFFF'
		      ]
		    },{
		      data: [felectoal, remaining4],
		      backgroundColor: [
		        '#a87dcc',
		        '#fff'
		      ],borderWidth: 1,
		      borderColor: [
		        '#a87dcc',
		        '#ccc'
		      ],
		      hoverBackgroundColor: [
		        '#a87dcc',
		        '#FFFFFF'
		      ]
		    },{
		      data: [ftransparencia, remaining5],
		      backgroundColor: [
		        '#ccafe0',
		        '#fff'
		      ],borderWidth: 1,
		      borderColor: [
		        '#ccafe0',
		        '#ccc'
		      ],
		      hoverBackgroundColor: [
		        '#ccafe0',
		        '#FFFFFF'
		      ]
		    }],
		  };


		  var options = {
		    responsive: true,
		    maintainAspectRatio: false,
		    scaleShowVerticalLines: false,
		    cutoutPercentage: 50,

		    legend: {
		      display: false
		    },
		    animation: {
		     
		    }
		  };

		  Chart.defaults.global.tooltips.enabled = false;
		  var chart = new Chart(context, {
		    type: 'doughnut',
		    data: data,
		    options: options
		  });
		}

	</script>
	<!-- END SECCION DIAGRAMA INFERIOR -->


</div>

<?php 
	include_once 'footer.php';
?>