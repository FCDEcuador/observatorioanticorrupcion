@extends('frontend.layouts.frontend-layout')

@section('title')
	
@endsection

@section('custom-css')	
    {!! Html::style('public/backend/assets/plugins/bootstrap-sweetalert/sweetalert.css') !!}
    @if($oContentArticle->extra_headers != '')
    	{!! $oContentArticle->extra_headers !!}
    @else
    	{!! $oContentCategory->extra_headers !!}
    @endif
@endsection



@section('main-content')
	
	
	<div class="row mt-3">
		<div class="col-sm-6">
			<div class="titulo border-bottom border-success ext-success text-uppercase">{!! $oContentCategory->title !!}</div>
		</div>
	</div>

	<div class="row mt-3">
		<!-- BEGIN SECCION CONTENIDDO -->
		<div class="col-sm-8">
			<div class="shadow p-3 mb-5 bg-white rounded">
				<img src="{!! $oStorage->url($oContentArticle->main_multimedia) !!}" alt="{!! $oContentArticle->title !!}" title="asfsaf" class=" w-100">
				<div class="row mt-1">
				    <div class="col align-self-start text-muted">
				      {!! TimeFormat::dateShortFormat($oContentArticle->created_at) !!}
				    </div>
			  	</div>
			  	<div class="content mt-3">
				  	<h6 class="text-success">{!! $oContentCategory->name !!}</h6>
					<h3 class="titulo text-default text-uppercase">{!! $oContentArticle->title !!}</h3>
					<div class="text-justify text-muted">
						<p>{!! $oContentArticle->summary !!}</p>
						{!! $oContentArticle->content !!}
					</div>
				</div>
			</div>
		</div>
		<!-- END SECCION CONTENIDDO -->

		<!-- BEGIN SECCION LATERAL -->
		<div class="col-sm-4">
			<!-- BEGIN lo mas reciente -->
			<div class="shadow p-3 mb-4 bg-white rounded">
				<h6 class="text-success text-uppercase">Lo más reciente</h6>
				@if($contentArticlesListRecent->isNotEmpty())
					@foreach($contentArticlesListRecent as $oContentArticleRecent)
						<div class="elemento">
							<img src="{!! $oStorage->url($oContentArticleRecent->main_multimedia) !!}" alt="{!! $oContentArticleRecent->title !!}" title="{!! $oContentArticleRecent->title !!}" class="w-100 mt-2">
							<h6 class="mt-3"><a href="{!! route('content-article', [$oContentCategory->slug, $oContentArticleRecent->slug]) !!}" class="text-muted">{!! $oContentArticleRecent->title !!}</a></h6>
							<div class="row mt-1">
							    <div class="col align-self-start text-muted">
							      {!! TimeFormat::dateShortFormat($oContentArticleRecent->created_at) !!}
							    </div>
						  	</div>
						</div>
						<hr class="border-success">
					@endforeach
				@endif
			</div>

			<div class="compartir shadow p-3 mb-4 bg-white rounded">
				<h6 class="text-success text-uppercase">Ejes temáticos</h6>
				<div class="elemento mt-3">
					<ul class="text-muted">
						@if($contentCategoriesList->isNotEmpty())
							@foreach($contentCategoriesList as $oCCList)
								<li><a href="{!! route('content-category', [$oCCList->slug]) !!}" class="text-muted">{!! $oCCList->name !!}</a></li>
							@endforeach
						@endif
					</ul>
				</div>
			</div>
			<!-- END lo mas reciente -->
			<div class="compartir shadow p-3 mb-4 bg-white rounded">
				<h6 class="text-success text-uppercase">Compartir</h6>
				<div class="elemento mt-3">
					<div class="addthis_inline_share_toolbox d-flex justify-content-center"></div>
					<div class="mt-2 text-center text-default">Observatorio Anticorrupción</div>
				</div>
			</div>
			
		</div>
		<!-- END SECCION LATERAL -->
	</div>

	
	<div class="row">
		<div class="col-sm-6">
			<div class="titulo border-bottom border-success ext-success text-uppercase">Otros Artículos</div>
		</div>
		<!-- BEGIN SECCION PUBLICACIONES -->
		<div class="row mt-3 no-gutters">
			@if($contentArticlesList->isNotEmpty())
				@foreach($contentArticlesList as $oContentArticleList)
					<div class="col-sm-6">
						<div class="row no-gutters">
							<div class="col-4 d-sm-flex align-items-center pl-3 pr-sm-3">
								<img class="d-block w-100" src="{!! $oStorage->url($oContentArticleList->main_multimedia) !!}" alt="{!! $oContentArticleList->title !!}">
							</div>
							<div class="col-8 pl-3 pl-sm-0 pr-3 pr-sm-0">
								<h6 class="text-success font-weight-bold">{!! $oContentArticleList->contentCategory->name !!}</h6>
								<h3 class="subtitulo text-default text-uppercase"><a href="#" class="text-default">{!! $oContentArticleList->title !!}</a></h3>
								<p class="text-justify"><a href="{!! route('content-article', [$oContentArticleList->contentCategory->slug, $oContentArticleList->slug]) !!}" class="text-secondary">
									{!! $oContentArticleList->summary !!}
								</a></p>
							</div>
						</div>
					</div>
				@endforeach
			@endif

		</div>
	<!-- END SECCION PUBLICACIONES -->	
	</div>
	
	
@endsection



@section('custom-js')
	{!! Html::script('public/backend/assets/plugins/bootstrap-sweetalert/sweetalert.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/js/ui-sweetalert.min.js', ['type' => 'text/javascript']) !!}
@endsection