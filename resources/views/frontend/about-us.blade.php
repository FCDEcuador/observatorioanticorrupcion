@extends('frontend.layouts.frontend-layout')

@section('title')
	Sobre el Observatorio
@endsection

@section('custom-css')
@endsection

@section('main-content')
	
	<!-- BEGIN SECCION MISION -->
		<div class="row mt-3 p-3 bg-light">
			<div class="col-12">
				<div class="titulo border-bottom border-info text-default text-uppercase text-left text-sm-right">Sobre el observatorio</div>
			</div>
			<div class="row mt-3">
				<div class="col-sm-6">
					<iframe class="w-100 h-100" src="https://www.youtube.com/embed/aZPRrlLzPFc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
				<div class="col-sm-6 mt-3 mb-3 text-justify">
					<p>Somos una iniciativa de Fundación Ciudadanía y Desarrollo que través de la investigación y análisis de casos de corrupción y su posterior difusión en formatos abiertos y amigables, busca promover el conocimiento y debate ciudadano sobre la importancia del combate a la corrupción. </p>
					<h2 class="morado mt-3">Misión</h2>
					<p>Obtener, sistematizar y difundir información confiable y amigable sobre casos de corrupción en Ecuador y sus consecuencias en la vida diaria de sus habitantes.</p>
					<h2 class="morado mt-3">Visión</h2>
					<p>Un Ecuador en el que el sector público y privado actúen de manera sinérgica en el combate efectivo a la corrupción.</p>
				</div>
			</div>
		</div>

	<!-- END SECCION  MISION -->


	<!-- BEGIN SECCION METODOLOGÍA -->
		<div class="row mt-5 p-3 ">
			<div class="col-sm-6 mt-sm-5 mb-5">
				<h2 class="morado mt-3 text-default border-bottom text-left text-sm-right">Metodología</h2>
				<p class="text-justify">La información obtenida y difundida por el Observatorio Anticorrupción de Fundación Ciudadanía y Desarrollo pretende constituirse en una herramienta ciudadana que otorgue elementos de valoración cuantitativa y cualitativa acerca de los casos de corrupción en Ecuador. El análisis realizado será referente a aquellos casos que han quedado en la impunidad, que actualmente estén siendo investigados por la Fiscalía General del Estado, se encuentren en etapa de juicio ante las instancias pertinentes, o sean evidenciados por los medios de comunicación especializados en periodismo de investigación. </p>
			</div>
			<div class="col-sm-6">
				<iframe class="w-100 h-100" src="https://www.youtube.com/embed/bdeM5T8K3uA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				
			</div>
		</div>

	<!-- END SECCION  METODOLOGÍA -->

	<hr class="borazul" />

	<div class="row mt-3 p-3 ">
		<div class="col-12">
			<h3 class="text-secondary text-center fz24">Con el apoyo de:</h3>
		</div>
		<div class="col-12">
			<div class="row mt-3 mb-1">
				<div class="col-sm-12 align-self-center mt-3 pl-5 pr-5 pl-sm-0 pr-sm-0">
					<a href="https://www.padf.org/" target="_blank"><img src="{!! asset('public/frontend/images/padf.png') !!}" class="mx-auto d-block img-fluid" style="width: 240px;"></a>
				</div>
				<!--div class="col-sm-4 align-self-center mt-5 mt-sm-3  pl-5 pr-5 pl-sm-0 pr-sm-0">
					<a href="http://www.oas.org/es/" target="_blank"><img src="{!! asset('public/frontend/images/OEA.png') !!}" class="mx-auto d-block img-fluid"></a>
				</div-->
			</div>
		</div>
	</div>

	

	<!-- END SECCION RESULTADO DE BUSQUEDA -->
	
@endsection



@section('custom-js')
@endsection