@extends('frontend.layouts.frontend-layout')

@section('title')
	
@endsection

@section('custom-css')	
@endsection



@section('main-content')
	
	<div class="container mt-3">
		<!-- BEGIN SECCION TITULO -->
		<div class="row mt-3 mb-3">
			<div class="col-sm-6">
				<div class="titulo border-bottom bormorado text-default text-uppercase">Historias de éxito</div>
			</div>
		</div>
		<!-- END SECCION TITULO -->
	</div>

	@if(is_object($oMainSuccessStory))
		<!-- BEGIN SECCION NOTA DESTACADA -->
		<div class="container-fluid p-3 bg-light">
			<div class="row imagen-exito" style="background-image: url('{!! $oStorage->url($oMainSuccessStory->image) !!}');">
				<div class="col-sm-6 d-flex align-items-end justify-content-center" style="background:rgba(57,0,148,0.2);">
					<div class="row">
						<div class="offset-sm-4 col-8">
							<h3 class="subtitulo text-white text-uppercase text-right">
								{!! $oMainSuccessStory->title !!}
							</h3>
							<p class="text-right text-white text-justify">
								{!! $oMainSuccessStory->description !!}
							</p>
						</div>
					</div>
				</div>
				<div class="col-sm-6 d-flex align-items-end justify-content-center mb-3 mt-3 mt-sm-0">
					<a href="{!! $oMainSuccessStory->url !!}" role="button" class="btn btn-success btn-sm bgmorado" target="_blank">Ver más</a>
				</div>
			</div>
		</div>
		<!-- END SECCION NOTA DESTACADA -->
	@endif

		
	<div class="container">
		<div class="row mt-3">
			<div class="col-12">
				<h6 class="border-bottom bormorado morado">ÚLTIMAS HISTORIAS</h6>
			</div>
		</div>
		
		<!-- BEGIN SECCION RESULTADO DE BUSQUEDA -->
		<div class="row mt-3 no-gutters p-3 p-sm-0">
			
			@if($successStoriesList->isNotEmpty())
				@foreach($successStoriesList as $oSuccessStory)
					<div class="col-sm-3">
						<img class="d-block w-100" src="{!! $oStorage->url($oSuccessStory->image) !!}" alt="{!! $oSuccessStory->title !!}">
						<div class="cont-text border-left border-right bormorado pl-3 pr-3 pt-3 pb-0">
							<h6 class="text-center mt-3 font-weight-bold"><a href="{!! $oSuccessStory->url !!}" class="morado" target="_blank">{!! $oSuccessStory->title !!}</a></h6>
							<div class="text-justify">{!! $oSuccessStory->description !!}</div>
						</div>
					</div>
				@endforeach
			@endif
			
	</div>

	<div class="row mt-3">
		<div class="col-12">
			{!! $successStoriesList->links() !!}
		</div>
	</div>



	<!-- END SECCION RESULTADO DE BUSQUEDA -->
</div>
	
@endsection



@section('custom-js')
@endsection