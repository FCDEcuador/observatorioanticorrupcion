<div class="container-fluid">
	<div class="row mb-4">
		    <div class="col-12 col-sm-3 media mt-3 mt-sm-0 mb-3 mb-md-0 justify-content-center">
		      	<a href="{!! route('home') !!}" class="mr-3 align-self-center"><img src="{!! asset('public/frontend/images/logo-sitio.png') !!}" ></a>
		    </div>
		    <div class="col-12 col-sm-9">
		    	<!--  BEGIN MENU  -->
		    	<nav class="navbar navbar-expand-lg navbar-dark bg-dark menu ">
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				  </button>
				  <div class="collapse navbar-collapse" id="navbarNav">
				    <ul class="navbar-nav mr-auto">
				      <li class="nav-item active">
				        <a class="nav-link" href="/obs_anticorrupcion">Inicio <span class="sr-only">(current)</span></a>
				      </li>
				      <li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				          Nosotros
				        </a>
				        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
				          <a class="dropdown-item" href="nosotros.php">Sobre el observatorio</a>
				          <a class="dropdown-item" href="contacto.php">Contacto</a>
				        </div>
				      </li>
				      <li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" href="corrupcion.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				          Lo que hacemos
				        </a>
				        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
				          <a class="dropdown-item" href="casos.php">Casos de Corrupción</a>
				          <a class="dropdown-item" href="#">Estadísticas</a>
				          <a class="dropdown-item" href="exito.php">Historias de éxito</a>
				        </div>
				      </li>
				      <li class="nav-item">
				        <a class="nav-link" href="publicaciones.php">Publicaciones</a>
				      </li>
				      <li class="nav-item">
				        <a class="nav-link" href="biblioteca.php">Biblioteca Legal</a>
				      </li>
				      
				    </ul>
				  </div>
				</nav>

		    	<!--  END MENU  -->


		      <!--  BEGIN CAROUSEL  -->
		      	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
				  <ol class="carousel-indicators">
				    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
				    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
				    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
				  </ol>
				  <div class="carousel-inner">
				    <div class="carousel-item active">
				      <img class="d-block w-100" src="https://picsum.photos/1000/260?auto=yes&bg=777&fg=555&text=First slide" alt="First slide">
				    </div>
				    <div class="carousel-item">
				      <img class="d-block w-100" src="https://picsum.photos/1000/260?auto=yes&bg=666&fg=444&text=Second slide" alt="Second slide">
				    </div>
				    <div class="carousel-item">
				      <img class="d-block w-100" src="https://picsum.photos/1000/260?auto=yes&bg=555&fg=333&text=Third slide" alt="Third slide">
				    </div>
				  </div>
				  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				    <span class="carousel-control-next-icon" aria-hidden="true"></span>
				    <span class="sr-only">Next</span>
				  </a>
				</div>
		      <!--  END CAROUSEL -->
		    </div>
	</div>
</div>