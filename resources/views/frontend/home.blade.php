@extends('frontend.layouts.frontend-layout')

@section('title')
	FDC
@endsection

@section('custom-css')
@endsection

@section('main-content')
	<!-- BEGIN SECCION CASOS DE CORRUPCION -->
		<div class="row mt-3 shadow p-3 mb-5 bg-white rounded">
			<div class="col-md-6 mb-3 mb-md-0">
				<!--  BEGIN CAROUSEL  -->
		      	<div id="casos-corrupcion" class="carousel slide" data-ride="carousel">
		      	  <ol class="carousel-indicators">
				    <li data-target="#casos-corrupcion" data-slide-to="0" class="active"></li>
				    <li data-target="#casos-corrupcion" data-slide-to="1"></li>
				    <li data-target="#casos-corrupcion" data-slide-to="2"></li>
				  </ol>
				  <div class="carousel-inner">
				    <div class="carousel-item active">
				    	<div class="row">
				    		<div class="col-4 col-md-5">
				    			<img class="d-block w-100" src="https://picsum.photos/200/400?auto=yes&bg=777&fg=555&text=First slide" alt="First slide">
				    		</div>
				    		<div class="col-8 col-md-7">
				    			<h1 class="titulo border-bottom border-info text-info text-uppercase">NUEVOS CASOS DE CORRUPCIÓN</h1>
				    			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar. Donec facilisis enim gravida lectus pretium egestas. Aenean tempus lectus ut risus suscipit, tempus vestibulum ex aliquet. Mauris ac vehicula sem, a sodales urna. In eget condimentum tellus, non porttitor diam. Ut consectetur dolor eget velit semper, id congue lectus maximus.</p>
				    			<a href="" role="button" class="btn btn-success btn-sm float-right">Entérate</a>
				    		</div>
				    	</div>
				    </div>
				    <div class="carousel-item">
				    	<div class="row">
				    		<div class="col-4 col-md-5">
				    			<img class="d-block w-100" src="https://picsum.photos/200/400?auto=yes&bg=666&fg=444&text=Second slide" alt="Second slide">
				    		</div>
				    		<div class="col-8 col-md-7">
				    			<h1 class="titulo border-bottom border-info text-info text-uppercase">NUEVOS CASOS DE CORRUPCIÓN</h1>
				    			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar. Donec facilisis enim gravida lectus pretium egestas. Aenean tempus lectus ut risus suscipit, tempus vestibulum ex aliquet. Mauris ac vehicula sem, a sodales urna. In eget condimentum tellus, non porttitor diam. Ut consectetur dolor eget velit semper, id congue lectus maximus.</p>
				    			<a href="" role="button" class="btn btn-success btn-sm float-right">Entérate</a>
				    		</div>
				    	</div>
				    </div>
				    <div class="carousel-item">
				      	<div class="row">
				    		<div class="col-4 col-md-5">
				    			<img class="d-block w-100" src="https://picsum.photos/200/400?auto=yes&bg=555&fg=333&text=Third slide" alt="Third slide">
				    		</div>
				    		<div class="col-8 col-md-7">
				    			<h1 class="titulo border-bottom border-info text-info text-uppercase">NUEVOS CASOS DE CORRUPCIÓN</h1>
				    			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar. Donec facilisis enim gravida lectus pretium egestas. Aenean tempus lectus ut risus suscipit, tempus vestibulum ex aliquet. Mauris ac vehicula sem, a sodales urna. In eget condimentum tellus, non porttitor diam. Ut consectetur dolor eget velit semper, id congue lectus maximus.</p>
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
			<div class="col-md-6">
				<a href="" role="button" class="btn btn-success btn-sm float-right bgmorado">conoce más aquí</a>
			</div>
		</div>

	<!-- END SECCION CASOS DE CORRUPCION -->

	<!-- BEGIN BANNER JUEGO -->
		
		<div class="row mt-3 shadow mb-5 bg-white rounded banner-juego" style="background-image: url('https://picsum.photos/1000/260?auto=yes&bg=666&fg=444&text=banner');" >
			<div class="col-8 col-sm-6 d-flex align-items-center">
				<h3 class="text-white">¿Sabes como se sancionan los casos de corrupción?</h3>
			</div>
			<div class="col-4 col-sm-6 d-flex align-items-end justify-content-end mb-3">
				<button type="button" class="btn btn-success btn-sm float-right">Descúbrelo jugando</button>
			</div>
		</div>
		
	<!-- END BANNER JUEGO -->

	<!-- BEGIN SECCION PUBLICACIONES -->
		<div class="row mt-3 shadow p-3 mb-5 bg-white rounded">
			<div class="col-12">
				<h1 class="titulo border-bottom border-info text-info">PUBLICACIONES</h1>
			</div>
				<div class="col-6">
					<div class="row">
						<div class="col-sm-3 d-flex align-items-center">
							<img class="d-block w-100" src="https://picsum.photos/80/80" alt="Publicacion1">
						</div>
						<div class="col-sm-9">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar. Donec facilisis enim gravida lectus pretium egestas. Aenean tempus lectus ut risus suscipit, tempus vestibulum</p>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="row">
						<div class="col-sm-3 d-flex align-items-center">
							<img class="d-block w-100" src="https://picsum.photos/80/80" alt="Publicacion1">
						</div>
						<div class="col-sm-9">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar. Donec facilisis enim gravida lectus pretium egestas. Aenean tempus lectus ut risus suscipit, tempus vestibulum</p>
						</div>
					</div>
				</div>
			<div class="col-12">
				<button type="button" class="btn btn-info btn-sm float-right">Ver más</button>
			</div>
		</div>
	<!-- END SECCION PUBLICACIONES -->	


	<!-- BEGIN SECCION BIBLIOTECA E HISTORIAS -->
		<div class="row mt-3 shadow p-3 mb-5 bg-white rounded ">
			<div class="col-sm-6">
				<div class="row no-gutters">
					<div class="col-sm-5 align-self-start">
						<img class="d-block w-100" src="https://picsum.photos/400/400" alt="Publicacion1">
					</div>
					<div class="col-sm-7 pl-3">
						<h1 class="titulo text-info text-uppercase">Biblioteca Legal</h1>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar. Donec facilisis enim gravida lectus pretium egestas. Aenean tempus lectus ut risus suscipit, tempus vestibulum</p>
						<button type="button" class="btn btn-info btn-sm float-right">Ver más</button>
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
					<div class="col-sm-8 p-3">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque convallis dolor ac nibh sollicitudin faucibus. Fusce venenatis odio non condimentum pulvinar. </p>
						<button type="button" class="btn btn-success btn-sm float-right">Ver más</button>
					</div>
					<div class="col-sm-4 align-self-start">
						<img class="d-block w-100" src="https://picsum.photos/400/400" alt="Publicacion1">
					</div>
				</div>
			</div>
		</div>
	<!-- END SECCION BIBLIOTECA E HISTORIAS -->
@endsection



@section('custom-js')
@endsection