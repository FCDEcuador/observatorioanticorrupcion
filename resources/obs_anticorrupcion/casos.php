<?php 
	include_once 'header.php';	
?>

<div class="container mt-3">

	<!-- BEGIN SECCION TITULO -->
	<div class="row mt-3 mb-3">
		<div class="col-sm-6">
			<div class="titulo border-bottom border-info text-default text-uppercase">Casos de corrupción</div>
		</div>
	</div>
	<!-- END SECCION TITULO -->

	<!-- BEGIN LISTADO DE CASOS -->
	<div class="row">	
		<div class="col-sm-3 mt-4">
			<!-- BEGIN BUSCADOR -->
			<form>
				<select class="form-control form-control-sm mb-2 border-left-0 border-right-0 border-top-0 border-info">
				  <option>Estado actual del caso</option>
				</select>
				<select class="form-control form-control-sm mb-2 border-left-0 border-right-0 border-top-0 border-info">
				  <option>Provincia</option>
				</select>
				<select class="form-control form-control-sm mb-2 border-left-0 border-right-0 border-top-0 border-info">
				  <option>Función del estado</option>
				</select>
				<div class="form-group mb-2">
				    <label for="palabras_claves" class="text-info">Palabras claves</label>
				    <input type="email" class="form-control border-info" id="palabras_claves" placeholder="busqueda">
				</div>
				<div class="align-self-end d-flex justify-content-end">
				  	<button type="submit" class="btn btn-info btn-sm">Buscar</button>
				</div>
			</form>
			<!-- END BUSCADOR -->		
		</div>
		<div class="col-sm-9">
			<!-- END LISTADO DE CASOS -->
			<div class="row no-gutters">
				<div class="col-6 col-sm-4 mt-3">
					<div class="shadow m-2 bg-white rounded">
						<img class="d-block w-100" src="https://via.placeholder.com/280x300" alt="Publicacion1">
						<div class="cont-text p-1">
							<h6 class="text-center mt-3"><a class="morado" href="#" data-toggle="modal" data-target="#casos-resumen">Lipsum sjfn lsasd skad</a></h6>
						</div>
					</div>
				</div>
				<div class="col-6 col-sm-4 mt-3">
					<div class="shadow m-2 bg-white rounded">
						<img class="d-block w-100" src="https://via.placeholder.com/280x300" alt="Publicacion1">
						<div class="cont-text p-1">
							<h6 class="text-center mt-3"><a class="morado" href="#" data-toggle="modal" data-target="#casos-resumen">Lipsum sjfn lsasd skad</a></h6>
						</div>
					</div>
				</div>
				<div class="col-6 col-sm-4 mt-3">
					<div class="shadow m-2 bg-white rounded">
						<img class="d-block w-100" src="https://via.placeholder.com/280x300" alt="Publicacion1">
						<div class="cont-text p-1">
							<h6 class="text-center mt-3"><a class="morado" href="#" data-toggle="modal" data-target="#casos-resumen">Lipsum sjfn lsasd skad</a></h6>
						</div>
					</div>
				</div>
				<div class="col-6 col-sm-4 mt-3">
					<div class="shadow m-2 bg-white rounded">
						<img class="d-block w-100" src="https://via.placeholder.com/280x300" alt="Publicacion1">
						<div class="cont-text p-1">
							<h6 class="text-center mt-3"><a class="morado" href="#" data-toggle="modal" data-target="#casos-resumen">Lipsum sjfn lsasd skad</a></h6>
						</div>
					</div>
				</div>
				<div class="col-6 col-sm-4 mt-3">
					<div class="shadow m-2 bg-white rounded">
						<img class="d-block w-100" src="https://via.placeholder.com/280x300" alt="Publicacion1">
						<div class="cont-text p-1">
							<h6 class="text-center mt-3"><a class="morado" href="#" data-toggle="modal" data-target="#casos-resumen">Lipsum sjfn lsasd skad</a></h6>
						</div>
					</div>
				</div>
				<div class="col-6 col-sm-4 mt-3">
					<div class="shadow m-2 bg-white rounded">
						<img class="d-block w-100" src="https://via.placeholder.com/280x300" alt="Publicacion1">
						<div class="cont-text p-1">
							<h6 class="text-center mt-3"><a class="morado" href="#" data-toggle="modal" data-target="#casos-resumen">Lipsum sjfn lsasd skad</a></h6>
						</div>
					</div>
				</div>
			</div>
			<!-- END LISTADO DE CASOS -->

			<div class="row mt-3">
				<div class="col-12">
					<nav aria-label="Page">
					  <ul class="pagination justify-content-center">
					    <li class="page-item">
					      <a class="page-link" href="#" aria-label="Previous">
					        <span aria-hidden="true">&laquo;</span>
					        <span class="sr-only">Previous</span>
					      </a>
					    </li>
					    <li class="page-item"><a class="page-link" href="#">1</a></li>
					    <li class="page-item"><a class="page-link" href="#">2</a></li>
					    <li class="page-item"><a class="page-link" href="#">3</a></li>
					    <li class="page-item">
					      <a class="page-link" href="#" aria-label="Next">
					        <span aria-hidden="true">&raquo;</span>
					        <span class="sr-only">Next</span>
					      </a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>

		</div>
	
	</div>
	<!-- END LISTADO DE CASOS -->


</div>



<!-- BEGIN MODAL -->
<div class="modal fade" id="casos-resumen" tabindex="-1" role="dialog" aria-labelledby="casos-resumenTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">  
      <div class="modal-body p-0">
      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="container-fluid p-0 bg-light">
    		<div class="row no-gutters">
    			<div class="col-sm-5 d-none d-sm-block">
    				<img class="d-block w-100 h-100" src="https://via.placeholder.com/280x300" alt="Publicacion1">
    			</div>
    			<div class="col-sm-7 p-3">
    				<div class="row">
						<div class="col-12">
							<h6 class="text-default mb-3 text-center text-uppercase">Breve descripción del caso</h6>
							<p class="pb-0 mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar.</p>
						</div>
					</div>
					<hr class="border-success">
					<div class="row">
						<div class="col-6">
							<div class="row">
								<div class="col-sm-2 fz20 mb-1 mb-sm-0 mt-1 mb-sm-0 pt-3 pb-2">
									<i class="fas fa-sync-alt"></i>
								</div>
								<div class="col-sm-10 p-1">
									<div class="bg-white mb-1 p-2 p-sm-2" > 
										<small class="display-block border-bottom border-secondary text-uppercase">Etapa actual del caso</small>
										<p class="text-uppercase pb-1 mb-0 text-default font-weight-bold letter-spacing-1">proceso judicial</p>
										<small class="display-block border-bottom border-secondary text-uppercase">Detalle sobre la etapa</small>
										<p class="text-uppercase pb-1 mb-0 text-default font-weight-bold letter-spacing-1">Sobrestimiento</p>
									</div>
								</div>
								<div class="col-sm-2 fz20 mb-1 mb-sm-0 mt-1 mb-sm-0 pt-3 pb-2">
									<i class="fas fa-users"></i>
								</div>
								<div class="col-sm-10 p-1">
									<div class="bg-white mb-1 p-2 p-sm-2" > 
										<small class="display-block border-bottom border-secondary text-uppercase">Número de involucrádos</small>
										<p class="text-uppercase pb-1 mb-0 text-default font-weight-bold letter-spacing-1">3 personas</p>
									</div>
								</div>
								<div class="col-sm-2 fz20 mb-1 mb-sm-0 mt-1 mb-sm-0 pt-3 pb-2">
									<i class="far fa-calendar-alt"></i>
								</div>
								<div class="col-sm-10 p-1">
									<div class="bg-white mb-1 p-2 p-sm-2" > 
										<small class="display-block border-bottom border-secondary text-uppercase">Periodo</small>
										<p class="text-uppercase pb-1 mb-0 text-default font-weight-bold letter-spacing-1">1994 - 1997</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-6">
							<div class="row">
								<div class="col-sm-2 fz20 mb-1 mb-sm-0 mt-1 mb-sm-0 pt-3 pb-2">
									<i class="fas fa-university"></i>
								</div>
								<div class="col-sm-10 p-1">
									<div class="bg-white mb-1 p-2 p-sm-2" > 
										<small class="display-block border-bottom border-secondary text-uppercase">Función del estado</small>
										<p class="text-uppercase pb-1 mb-0 text-default font-weight-bold letter-spacing-1">Función legislativa</p>
									</div>
								</div>
								<div class="col-sm-2 fz20 mb-1 mb-sm-0 mt-1 mb-sm-0 pt-3 pb-2">
									<i class="fas fa-landmark"></i>
								</div>
								<div class="col-sm-10 p-1">
									<div class="bg-white mb-1 p-2 p-sm-2" > 
										<small class="display-block border-bottom border-secondary text-uppercase">Instituciones Vinvuladas</small>
										<select class="form-control form-control-sm text-uppercase pb-1 mb-0 border-0 text-default font-weight-bold">
										  <option>Contraloría General del Estado</option>
										  <option>SRI</option>
										</select>
									</div>
								</div>
								<div class="col-sm-2 fz20 mb-1 mb-sm-0 mt-1 mb-sm-0 pt-3 pb-2">
									<i class="fas fa-user"></i>
								</div>
								<div class="col-sm-10 p-1">
									<div class="bg-white mb-1 p-2 p-sm-2" > 
										<small class="display-block border-bottom border-secondary text-uppercase">Funcionarios involucrados</small>
										<select class="form-control form-control-sm text-uppercase pb-1 mb-0 border-0 text-default font-weight-bold">
										  <option>Fabián Alarcón</option>
										  <option>Juan Perez</option>
										</select>
									</div>
								</div>
								<div class="col-sm-2 fz20 mb-1 mb-sm-0 mt-1 mb-sm-0 pt-3 pb-2">
									<i class="fas fa-map-marker-alt"></i>
								</div>
								<div class="col-sm-10 p-1">
									<div class="bg-white mb-1 p-2 p-sm-2" > 
										<small class="display-block border-bottom border-secondary text-uppercase">Provincia</small>
										<p class="text-uppercase pb-1 mb-0 text-default font-weight-bold letter-spacing-1">Pichincha</p>
									</div>
								</div>
							</div>
							<div class="col-sm-2 fz20 mb-1 mb-sm-0 mt-1 mb-sm-0">
								<div class="align-self-center d-flex justify-content-center mt-2">
							  		<a href="#" role="button" class="btn btn-info btn-sm">¿Quieres conocer más?</a>
							  	</div>
							</div>
						</div>
					</div>
    			</div>
    		</div>
    	</div>
      </div>
    </div>
  </div>
</div>

<!-- END MODAL -->



<?php 
	include_once 'footer.php';
?>