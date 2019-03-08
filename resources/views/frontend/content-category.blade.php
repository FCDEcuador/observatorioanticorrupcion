@extends('frontend.layouts.frontend-layout')

@section('title')
	
@endsection

@section('custom-css')	
    {!! Html::style('public/backend/assets/plugins/bootstrap-sweetalert/sweetalert.css') !!}
    {!! $oContentCategory->extra_headers !!}
@endsection



@section('main-content')
	
	
	<!-- BEGIN SECCION SLIDER PUBLLLICACIONES -->
	<div class="row mt-3">
		<div class="col-sm-6">
			<div class="titulo border-bottom border-success text-default text-uppercase">{!! $oContentCategory->title !!}</div>
		</div>
	</div>

	@if($outstandingContentArticlesList->isNotEmpty())
		<div class="row mt-3 shadow mb-5 bg-white rounded no-gutters">
			<div class="col-12 mb-3 mb-md-0">
				<!--  BEGIN CAROUSEL  -->
		      	<div id="publicaciones-slider" class="carousel slide" data-ride="carousel">
		      	  	<ol class="carousel-indicators">
				    	@foreach($outstandingContentArticlesList as $oOutstandingContentArticle)
				    		<li data-target="#publicaciones-slider" data-slide-to="{!! $loop->index !!}" {!! $loop->index == 0 ? 'class="active"' : '' !!}></li>
					    @endforeach
				  	</ol>
				  	<div class="carousel-inner">
					    @foreach($outstandingContentArticlesList as $oOutstandingContentArticle)
						    <div class="carousel-item {!! $loop->index == 0 ? 'active' : '' !!}">
						    	<div class="row p-3 p-sm-0">
						    		<div class="col-md-6">
						    			<img class="d-block w-100" src="{!! $oStorage->url($oOutstandingContentArticle->main_multimedia) !!}">
						    		</div>
						    		<div class="col-md-6 p-3">
						    			<h6 class="text-success">{!! $oOutstandingContentArticle->contentCategory->name !!}</h6>
						    			<h3 class="titulo text-default text-uppercase">{!! $oOutstandingContentArticle->title !!}</h3>
						    			<div class="pr-5 text-justify">{!! $oOutstandingContentArticle->summary !!}</div>
						    			<a href="{!! route('content-article', [$oOutstandingContentArticle->contentCategory->slug, $oOutstandingContentArticle->slug]) !!}" role="button" class="btn btn-success btn-sm float-right mr-3">Ver más</a>
						    		</div>
						    	</div>
						    </div>
					    @endforeach
				  	</div>
			  		<a class="carousel-control-prev" href="#publicaciones-slider" role="button" data-slide="prev">
				    	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				    	<span class="sr-only">Anterior</span>
				  	</a>
				  	<a class="carousel-control-next" href="#publicaciones-slider" role="button" data-slide="next">
				    	<span class="carousel-control-next-icon" aria-hidden="true"></span>
				    	<span class="sr-only">Siguiente</span>
				  	</a>
				</div>
		      	<!--  END CAROUSEL -->
			</div>
		</div>
	@endif


	<!-- END SECCION SLIDER PUBLLLICACIONES -->
	<div class="row mt-3 pl-3 pr-3 pl-sm-0 pr-sm-0">
		<div class="col-12">
			<h6 class="border-bottom border-success text-success">ÚLTIMAS HISTORIAS</h6>
		</div>
	</div>

	@if($contentArticlesList->isNotEmpty())
		<div class="row mt-3 pl-3 pr-3 pl-sm-0 pr-sm-0">
			@foreach($contentArticlesList as $oContentArticle)
				<div class="col-12 mb-3 border-bottom border-success pb-3">
					<div class="row">
						<div class="col-sm-5 d-flex align-items-center">
							<img class="d-block w-100" src="{!! $oStorage->url($oContentArticle->main_multimedia) !!}" alt="{!! $oContentArticle->title !!}">
						</div>
						<div class="col-sm-7">
							<span class="d-block text-right">{!! TimeFormat::dateShortFormat($oContentArticle->created_at) !!}</span>
							<h6 class="text-success">{!! $oContentArticle->contentCategory->name !!}</h6>
							<h3 class="subtitulo text-default text-uppercase">{!! $oContentArticle->title !!}</h3>
							<p class="text-justify">{!! $oContentArticle->summary !!}</p>
							<a href="{!! route('content-article', [$oContentArticle->contentCategory->slug, $oContentArticle->slug]) !!}" role="button" class="btn btn-success btn-sm float-right">Ver más</a>
						</div>
					</div>
				</div>
			@endforeach
			
			<div class="col-12">
				{!! $contentArticlesList->links() !!}
			</div>
		</div>
	@endif
	
	
@endsection



@section('custom-js')
	{!! Html::script('public/backend/assets/plugins/bootstrap-sweetalert/sweetalert.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/js/ui-sweetalert.min.js', ['type' => 'text/javascript']) !!}
@endsection