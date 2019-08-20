<?php 
	include_once 'header.php';	
?>

<div class="container mt-3">

	<!-- BEGIN SECCION BUSCAR -->
		<div class="row mt-3 p-3 bg-light">
			<div class="col-sm-6">
				<div class="titulo border-bottom border-info text-info text-uppercase">Biblioteca legal</div>
			</div>
			<div class="col-12 mt-3">
				<p class="text-justify">A continuación te presentamos las principales leyes, reglamentos y decretos que abordan temas y mecanismos de prevención y sanción a los actos de corrupción en Ecuador. Utiliza el buscador para acceder a los documentos de tu interés.</p>
			</div>
		</div>

		<div class="row p-3 bg-light">
			<div class="col-12 ">
				<form>
				  <div class="form-group row justify-content-center">
				    <label for="termino" class="col-sm-3 col-form-label text-uppercase text-left text-sm-right text-secondary">Término de búsqueda</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="termino" name="termino" required>
				    </div>
				  </div>
				  <div class="form-group row justify-content-center">
				    <label for="ano_emision" class="col-sm-3 col-form-label text-uppercase text-left text-sm-right text-secondary">Año de emisión</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="ano_emision" name="ano_emision" required>
				    </div>
				  </div>
				  <div class="align-self-center d-flex justify-content-center">
				  	<button type="submit" class="btn btn-info btn-sm">Buscar</button>
				  </div>
				</form>
			</div>
		</div>
	<!-- END SECCION BUSCAR -->


	<!-- BEGIN SECCION RESULTADO DE BUSQUEDA -->
	<div class="row mt-5 ">
		<div class="col-4 d-none d-sm-block">
			<h6 class="border-bottom border-default text-default font-weight-bold">CASO</h6>
		</div>
		<div class="col-8 d-none d-sm-block">
			<h6 class="border-bottom border-default text-default font-weight-bold">DESCRIPCIÓN</h6>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-12 mb-3 border-bottom border-info pb-3">
			<div class="row">
				<div class="col-sm-4 ">
					<h6 class="text-info">Loren ipsun dolor didiad,madmafa</h6>
				</div>
				<div class="col-sm-8">
					<div class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar. Donec facilisis enim gravida lectus pretium egestas. Aenean tempus lectus ut risus suscipit, tempus vestibulum</div>
					<a href="#" role="button" class="btn btn-info btn-sm float-right">Descargar</a>
				</div>
			</div>
		</div>
		<div class="col-12 mb-3 border-bottom border-info pb-3">
			<div class="row">
				<div class="col-sm-4 ">
					<h6 class="text-info">Loren ipsun dolor didiad,madmafa</h6>
				</div>
				<div class="col-sm-8">
					<div class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar. Donec facilisis enim gravida lectus pretium egestas. Aenean tempus lectus ut risus suscipit, tempus vestibulum</div>
					<a href="#" role="button" class="btn btn-info btn-sm float-right">Descargar</a>
				</div>
			</div>
		</div>
		<div class="col-12 mb-3 border-bottom border-info pb-3">
			<div class="row">
				<div class="col-sm-4 ">
					<h6 class="text-info">Loren ipsun dolor didiad,madmafa</h6>
				</div>
				<div class="col-sm-8">
					<div class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar. Donec facilisis enim gravida lectus pretium egestas. Aenean tempus lectus ut risus suscipit, tempus vestibulum</div>
					<a href="#" role="button" class="btn btn-info btn-sm float-right">Descargar</a>
				</div>
			</div>
		</div>
		

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

	<!-- END SECCION RESULTADO DE BUSQUEDA -->
</div>

<?php 
	include_once 'footer.php';
?>