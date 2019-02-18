<?php 
	include_once 'header.php';	
?>

<div class="container mt-3">
	<!-- BEGIN SECCION CASOS DE CORRUPCION -->
	<div class="container">
		<div class="row mt-3 p-3 shadow mb-5 bg-white rounded">
			<div class="col-md-6 mb-3 mb-md-0">
				<!--  BEGIN CAROUSEL  -->
		      	<div id="casos-corrupcion" class="carousel slide" data-ride="carousel">
		      	  <ol class="carousel-indicators d-none d-sm-flex">
				    <li data-target="#casos-corrupcion" data-slide-to="0" class="active"></li>
				    <li data-target="#casos-corrupcion" data-slide-to="1"></li>
				    <li data-target="#casos-corrupcion" data-slide-to="2"></li>
				  </ol>
				  <div class="carousel-inner">
				    <div class="carousel-item active">
				    	<div class="row">
				    		<div class="col-sm-5">
				    			<img class="d-block img-fluid" src="https://picsum.photos/280/400?auto=yes&bg=777&fg=555&text=First slide" alt="First slide">
				    		</div>
				    		<div class="col-sm-7">
				    			<h1 class="titulo border-bottom border-info text-default text-uppercase mt-3 mt-sm-0 text-sm-left">NUEVOS CASOS DE CORRUPCIÓN</h1>
				    			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar. Donec facilisis enim gravida lectus pretium egestas. Aenean tempus lectus ut risus suscipit, tempus vestibulum ex aliquet.</p>
				    			<a href="" role="button" class="btn btn-success btn-sm float-right">Entérate</a>
				    		</div>
				    	</div>
				    </div>
				    <div class="carousel-item">
				    	<div class="row">
				    		<div class="col-sm-5">
				    			<img class="d-block img-fluid" src="https://picsum.photos/280/400?auto=yes&bg=666&fg=444&text=Second slide" alt="Second slide">
				    		</div>
				    		<div class="col-sm-7">
				    			<h1 class="titulo border-bottom border-info text-default text-uppercase mt-3 mt-sm-0 text-sm-left">NUEVOS CASOS DE CORRUPCIÓN</h1>
				    			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar. Donec facilisis enim gravida lectus pretium egestas. Aenean tempus lectus ut risus suscipit, tempus vestibulum ex aliquet.</p>
				    			<a href="" role="button" class="btn btn-success btn-sm float-right">Entérate</a>
				    		</div>
				    	</div>
				    </div>
				    <div class="carousel-item">
				      	<div class="row">
				    		<div class="col-sm-5">
				    			<img class="d-block img-fluid" src="https://picsum.photos/280/400?auto=yes&bg=555&fg=333&text=Third slide" alt="Third slide">
				    		</div>
				    		<div class="col-sm-7">
				    			<h1 class="titulo border-bottom border-info text-default text-uppercase mt-3 mt-sm-0 text-sm-left">NUEVOS CASOS DE CORRUPCIÓN</h1>
				    			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar. Donec facilisis enim gravida lectus pretium egestas. Aenean tempus lectus ut risus suscipit, tempus vestibulum ex aliquet.</p>
				    			<a href="" role="button" class="btn btn-success btn-sm float-right">Entérate</a>
				    		</div>
				    	</div>
				    </div>
				  </div>
				  <a class="carousel-control-prev" href="#casos-corrupcion" role="button" data-slide="prev">
				    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="carousel-control-next" href="#casos-corrupcion" role="button" data-slide="next">
				    <span class="carousel-control-next-icon" aria-hidden="true"></span>
				    <span class="sr-only">Next</span>
				  </a>
				</div>
		      	<!--  END CAROUSEL -->
			</div>
			<div class="col-sm-6">
				<h1 class="titulo border-bottom border-info text-default text-uppercase text-center">Estadísticas</h1>
				<p>Conoce cuál es el estado de los casos de corrupción, cuya información es recopilada por nuestro Observatorio</p>
				<div class="row">
					<div class="col-sm-4">
						<div><canvas id="contraloria" class="m-100 h-100"></canvas></div>
						<div class="titulo text-uppercase fz14 mt-1 mb-3 mb-sm-0 text-center">Exámen de contraloría</div>
					</div>
					<div class="col-sm-4">
						<div><canvas id="judicial" class="m-100 h-100"></canvas></div>
						<div class="titulo text-uppercase fz14 mt-1 mb-3 mb-sm-0 text-center">Proceso judicial</div>
					</div>
					<div class="col-sm-4">
						<div><canvas id="periodistica" class="m-100 h-100"></canvas></div>
						<div class="titulo text-uppercase fz14 mt-1 mb-3 mb-sm-0 text-center">Envestigación periodística</div>
					</div>
				</div>
				
				
				<script>
				
				setupChart('contraloria', 33,'#a9d42c');
				setupChart('judicial', 66,'#390094');
				setupChart('periodistica', 99, '#4db1e0');


				function setupChart(chartId, progress, fondo ) {
				  var canvas = document.getElementById(chartId);
				  var context = canvas.getContext('2d');

				  var remaining = 100 - progress;
				  var data = {
				    labels: [ 'Progress', '', ],
				    datasets: [{
				      data: [progress, remaining],
				      backgroundColor: [
				        fondo,
				        '#d2e6ed'
				      ],
				      borderColor: [
				        fondo,
				        '#d2e6ed'
				      ],
				      hoverBackgroundColor: [
				        fondo,
				        '#FFFFFF'
				      ]
				    }]
				  };

				  var options = {
				    responsive: true,
				    maintainAspectRatio: false,
				    scaleShowVerticalLines: false,

				    cutoutPercentage: 80,
				    legend: {
				      display: false
				    },
				    animation: {
				      onComplete: function (event) {
				      	console.log(this.chart.height);
				        var xCenter = this.chart.width/2;
				        var yCenter = this.chart.height/2;

				        context.textAlign = 'center';
				        context.textBaseline = 'middle';

				        var progressLabel = data.datasets[0].data[0] + '%';
				        context.font = '32px Helvetica';
				        context.fillStyle = 'black';
				        context.fillText(progressLabel, xCenter, yCenter);
				      }
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

				<a href="" role="button" class="btn btn-success btn-sm float-right bgmorado mt-3">conoce más aquí</a>
			</div>
		</div>
	</div>
	<!-- END SECCION CASOS DE CORRUPCION -->

	<!-- BEGIN BANNER JUEGO -->
	<div class="container">
		<div class="row mt-3 shadow mb-5 bg-white rounded banner-juego" style="background-image: url('https://picsum.photos/1000/260?auto=yes&bg=666&fg=444&text=banner');" >
			<div class="col-sm-6 d-flex align-items-center">
				<h3 class="text-white">¿Sabes como se sancionan los casos de corrupción?</h3>
			</div>
			<div class="col-sm-6 d-flex align-items-end justify-content-end mb-3">
				<a href="#" role="button" class="btn btn-success btn-sm float-right">Descúbrelo jugando</a>
			</div>
		</div>
	</div>
		
	<!-- END BANNER JUEGO -->

	<!-- BEGIN SECCION PUBLICACIONES -->
		<div class="container">
			<div class="row mt-3 p-3 shadow mb-5 bg-white rounded">
				<div class="col-12">
					<h1 class="titulo border-bottom border-info text-default">PUBLICACIONES</h1>
				</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-4 d-flex align-items-center">
								<img class="d-block w-100" src="https://picsum.photos/80/80" alt="Publicacion1">
							</div>
							<div class="col-8">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar. Donec facilisis enim gravida lectus pretium egestas. Aenean tempus lectus ut risus suscipit, tempus vestibulum</p>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-4 d-flex align-items-center">
								<img class="d-block w-100" src="https://picsum.photos/80/80" alt="Publicacion1">
							</div>
							<div class="col-8">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar. Donec facilisis enim gravida lectus pretium egestas. Aenean tempus lectus ut risus suscipit, tempus vestibulum</p>
							</div>
						</div>
					</div>
				<div class="col-12">
					<a href="#" role="button" class="btn btn-info btn-sm float-right">Ver más</a>
				</div>
			</div>
		</div>
	<!-- END SECCION PUBLICACIONES -->	


	<!-- BEGIN SECCION BIBLIOTECA E HISTORIAS -->
		<div class="container">
			<div class="row mt-3 p-3 shadow mb-5 bg-white rounded">
					<div class="col-sm-6">
						<div class="row no-gutters">
							<div class="col-sm-5 align-self-start">
								<img class="d-block w-100" src="https://picsum.photos/400/400" alt="Publicacion1">
							</div>
							<div class="col-sm-7 pl-3">
								<h1 class="titulo text-default text-uppercase mt-3 mt-sm-0">Biblioteca Legal</h1>
								<p>Aquí puedes encontrar  las principales leyes, reglamentos y decretos que abordan temas y mecanismos de prevención y sanción a los actos de corrupción en Ecuador</p>
								<a href="biblioteca.php" role="button" class="btn btn-info btn-sm float-right">Ver más</a>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row no-gutters bgvioleta mt-3 mt-sm-0" >
							<div class="col-12">
								<h4 class="p-3 text-white text-uppercase fz14">Conoce historias de éxito sobre la lucha contra la corrupción</h4>
							</div>
						</div>
						<div class="row no-gutters border-left borazul">
							<div class="col-sm-9 p-3">
								<p>Entérate de experiencias exitosas a nivel mundial sobre la lucha contra la corrupción. </p>
								<a href="exito.php" role="button" class="btn btn-success btn-sm float-right">Ver más</a>
							</div>
							<div class="col-sm-3 align-self-start">
								<img class="d-block w-100" src="https://picsum.photos/300/300" alt="Publicacion1">
							</div>
						</div>
					</div>
			</div>
		</div>
	<!-- END SECCION BIBLIOTECA E HISTORIAS -->
		
</div>

<?php 
	include_once 'footer.php';
?>