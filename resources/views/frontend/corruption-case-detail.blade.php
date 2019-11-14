@extends('frontend.layouts.frontend-layout')

@section('title')
	{!! $oCorruptionCase->title !!}
@endsection

@section('custom-css')	
@endsection



@section('main-content')
	
	<div class="container mt-3">	
		<!-- BEGIN SECCION TITULO -->
		<div class="row mt-3 mb-3">
			<div class="col-sm-6">
				<div class="titulo border-bottom border-info text-default text-uppercase">Casos de corrupción</div>
			</div>
		</div>
		<!-- END SECCION TITULO -->
	</div>

	<!-- BEGIN SECCION NOTA DESTACADA -->
	<div class="container-fluid p-3 bg-light">
		
		<div class="row imagen-exito" style="background-image: url('{!! $oStorage->url($oCorruptionCase->main_multimedia) !!}');">
			<div class="col-sm-6 d-flex align-items-end justify-content-center" style="background:rgba(0,178,226,0.4);">
				<div class="row">
					<div class="offset-sm-4 col-sm-8">
						<h3 class="subtitulo text-white text-uppercase text-right fz32">
							{!! $oCorruptionCase->title !!}
						</h3>
						
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-12 d-flex align-items-middle justify-content-center mt-3">
				<div class="text-muted text-center mr-1 d-none d-sm-inline-block">
					Compartir:
				</div>
				<div class="share-md mr-3">
					<div class="addthis_inline_share_toolbox d-flex justify-content-center"></div>
				</div>
				<div>
					<a href="{!! route('corruption-cases.download-pdf', [$oCorruptionCase->slug]) !!}" role="button" class="btn btn-success btn-sm" target="_blank">descarga PDF</a>
					&nbsp;&nbsp;&nbsp;
					<a href="#" data-toggle="modal" data-target="#casos-resumen" onclick="javascript: loadCorruptionCase('{!! route('corruption-cases.detail-json', [$oCorruptionCase->id]) !!}');" class="btn btn-success btn-sm">Resumen del Caso</a>
				</div>
			</div>
		</div>
	</div>
	<!-- END SECCION NOTA DESTACADA -->

		
	<div class="container">
		@if($oCorruptionCase->history != '')
			<!-- BEGIN SECCION ANTECEDENTES -->
			<div class="row mt-3 mb-3">
				<div class="col-6">
					<h1 class="titulo border-bottom border-info text-info text-uppercase">Contexto</h1>
				</div>
			</div>
			<div class="row mt-3 no-gutters">
				<div class="col-sm-6">
					<div class="bgceleste text-white p-3 antecedentes text-justify">
						{!! $oCorruptionCase->history !!}
					</div>
				</div>
				<div class="col-sm-6">
					@if($oCorruptionCase->history_image)
						<img class="d-block w-100 h-100" src="{!! $oStorage->url($oCorruptionCase->history_image) !!}" alt="{!! $oCorruptionCase->title !!}">
					@endif
				</div>
			</div>
			<!-- END SECCION ANTECEDENTES -->
		@endif
		
		@php
			$aWhatHappened = $oCorruptionCase->whatsHappeneds()->orderBy('order', 'asc')->get();
		@endphp
		
		@if($aWhatHappened->isNotEmpty())
			<!-- BEGIN SECCION QUE OCURRIO -->
			<div class="row mt-3 mb-3">
				<div class="col-sm-6">
					<h1 class="titulo border-bottom bormorado morado text-uppercase">Los hechos</h1>
				</div>
			</div>
			<div class="row">
	        	<div class="col-md-12 ml-2">
	        		<div class="fz40 morado text-left text-sm-center calendario-time-line">
	        			<i class="far fa-calendar-alt"></i>
	        		</div>
	            	<div class="main-timeline">
	                	@foreach($aWhatHappened as $oWhatHappened)
		                	<div class="timeline">
		                    	<div class="timeline-content">
		                        	<h3 class="title">
			                        	{!! $oWhatHappened->day != '' ? $oWhatHappened->day : '' !!} {!! $oWhatHappened->month != '' ? $oWhatHappened->month : '' !!} {!! $oWhatHappened->year != '' ? $oWhatHappened->year : '' !!}
			                        	@if($oWhatHappened->year_end != '' || $oWhatHappened->month_end != '' || $oWhatHappened->day_end != '')
			                        		 a 
			                        		 {!! $oWhatHappened->day_end != '' ? $oWhatHappened->day_end : '' !!} {!! $oWhatHappened->month_end != '' ? $oWhatHappened->month_end : '' !!} {!! $oWhatHappened->year_end != '' ? $oWhatHappened->year_end : '' !!}
			                        	@endif
			                        </h3>
		                    		<div class="description">
		                        		<div class="scrollbar scrollbar-secondary">
								    		<div class="force-overflow text-justify pr-2">
		                        				{!! $oWhatHappened->description !!}
		                        			</div>
			                        	</div>
			                    	</div>
		                    	</div>
		                	</div>
	                	@endforeach
	            	</div>
	        	</div>
	    	</div>
			<!-- END SECCION QUE OCURRIO -->
		@endif


		<!-- BEGIN SECCION POR QUE OCURRIO -->
		<div class="row mt-3 mb-3">
			<div class="col-sm-6">
				<h1 class="titulo border-bottom borazul text-default text-uppercase">¿Por Qué ocurrió?</h1>
			</div>
		</div>

		<div class="accordion" id="accordionExample">
	  		@if($oCorruptionCase->legal_causes != '')
		  		<div class="card">
		    		<div class="card-header bgazul text-center p-0" id="headingOne">
		      			<h3 class="mb-0">
		        			<a class="btn btn-link text-white btn-lg d-block w-100" role="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
		          				Causas Jurídicas <i class="fas fa-angle-down"></i>
		        			</a>
		      			</h3>
		    		</div>

		    		<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
		      			<div class="card-body text-justify pl-5 pr-5">
		      				{!! $oCorruptionCase->legal_causes !!}
		      			</div>
		    		</div>
		  		</div>
	  		@endif
	  		
	  		@if($oCorruptionCase->political_causes != '')
		  		<div class="card">
		    		<div class="card-header bgazul text-center p-0" id="headingTwo">
		      			<h3 class="mb-0">
		        			<a class="btn btn-link text-white btn-lg collapsed d-block w-100" role=button data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
		          				Causas Técnicas <i class="fas fa-angle-down"></i>
		        			</a>
		      			</h3>
		    		</div>
		    		<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
		      			<div class="card-body text-justify pl-5 pr-5">
		        			{!! $oCorruptionCase->political_causes !!}
		      			</div>
		    		</div>
		  		</div>
	  		@endif
		</div>	
		<!-- END SECCION POR QUE OCURRIO -->

		<!-- SECCION CONSECUENCIAS -->
		<div class="row mt-5">
			
			
			<div class="col-sm-6" >
				<div class="p-3" style="background: rgba(36,57,91,0.7);">
					<h2 class=" border-bottom border-white text-white text-uppercase font-weight-bold">
						Consecuencias
					</h2>
					@if($oCorruptionCase->economic_consequences != '')
						<div class="subtitulo text-white font-italic mt-3">
							Económicas
						</div>
						<div class="detalle text-white text-justify">
							{!! $oCorruptionCase->economic_consequences !!}
						</div>
					@endif
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="p-3">
					@if($oCorruptionCase->consequences_introduction != '')
						<div class="subtitulo text-secondary font-italic text-right">
							{!! $oCorruptionCase->consequences_introduction !!}
						</div>
					@endif
					@if($oCorruptionCase->consequences_title != '')
						<div class="fz50 font-italic morado font-weight-bold text-right">
							{!! $oCorruptionCase->consequences_title !!}
						</div>
					@endif
					@if($oCorruptionCase->consequences_description != '')
						<small class="text-secondary">
							{!! $oCorruptionCase->consequences_description !!}
						</small>
					@endif
				</div>
			</div>
		</div>
		
		<div class="row" {!! $oCorruptionCase->consequences_image != '' ? 'style="background: url(\''.$oStorage->url($oCorruptionCase->consequences_image).'\') no-repeat;background-size: cover;"' : '' !!}>
			<div class="col-sm-6" >
				@if($oCorruptionCase->social_consequences != '')
					<div class="p-3" style="background: rgba(36,57,91,0.7);">
						<div class="subtitulo text-white font-italic mt-3 text-uppercase">
							Consecuencias políticas y sociales
						</div>
						<div class="detalle text-white text-justify">
							{!! $oCorruptionCase->social_consequences !!}
						</div>
					</div>
				@endif
			</div>
		</div>

		@if($oCorruptionCase->sources != '')
			<div class="row">
				<div class="col-sm-6" >
					<div class="p-3" style="background: rgba(36,57,91,0.7);">

						<div class="accordion" id="accordionFuentes">
					  		@if($oCorruptionCase->legal_causes != '')
						  		<div class="card">
						    		<div class="card-header bgazul text-center p-0" id="headingFour">
						      			<h6 class="mb-0 text-white text-uppercase font-weight-bold font-italic">
						        			<a class="btn btn-link text-white btn-lg d-block w-100" role="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						          				Fuentes <i class="fas fa-angle-down"></i>
						        			</a>
						      			</h6>
						    		</div>

						    		<div id="collapseOne" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
						      			<div class="card-body text-justify detalle fz12">
						      				{!! $oCorruptionCase->sources !!}
						      			</div>
						    		</div>
						  		</div>
					  		@endif
					  	</div>

					</div>
				</div>
			</div>
		@endif
		<!-- END SECCION CONSECUENCIAS -->

		@if($oCorruptionCase->author)
			<div class="row">
				<div class="col-sm-6" >
					<div class="p-3" style="background: rgba(36,57,91,0.7);">
						<p class="text-white"><strong>Investigador / Autor: </strong>{!! $oCorruptionCase->author !!}</p>
					</div>
				</div>
			</div>
		@endif

		@if($corruptionCasesList->isNotEmpty())
			<!-- BEGIN SECCION OTROS CASOS -->
			<div class="row mt-3">
				<div class="col-sm-6">
					<div class="titulo border-bottom border-success ext-success text-uppercase">Conoce más casos</div>
				</div>
			
				<div class="row mt-3 no-gutters">
					@foreach($corruptionCasesList as $oCorruptionCaseList)
						<div class="col-sm-6">
							<div class="row no-gutters">
								<div class="col-4 d-sm-flex align-items-center pl-3 pr-sm-3">
									<img class="d-block w-100" src="{!! $oStorage->url($oCorruptionCaseList->home_image) !!}" alt="{!! $oCorruptionCaseList->title !!}">
								</div>
								<div class="col-8 pl-3 pl-sm-0 pr-3 pr-sm-0">
									<h6 class="text-success font-weight-bold">
										{!! $oCorruptionCaseList->state_function !!}
									</h6>
									<h3 class="subtitulo text-default text-uppercase">
										<a href="{!! route('corruption-cases.show', [$oCorruptionCaseList->slug]) !!}" class="text-default">
											{!! $oCorruptionCaseList->title !!}
										</a>
									</h3>
									<p class="text-justify">
										<a href="{!! route('corruption-cases.show', [$oCorruptionCaseList->slug]) !!}" class="text-secondary">
											{!! $oCorruptionCaseList->summary !!}
										</a>
									</p>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
			<!-- END SECCION OTROS CASOS -->
		@endif



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
		    			<div class="col-sm-5 d-none d-sm-block" id="corruptionCaseImg"></div>
		    			<div class="col-sm-7 p-3">
		    				<div class="row">
								<div class="col-12">
									<h6 class="text-default mb-3 text-center text-uppercase" id="corruptionCaseTitle"></h6>
									<p class="pb-0 mb-0 text-muted" id="corruptionCaseSummary"></p>
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
												<p class="text-uppercase pb-1 mb-0 text-default font-weight-bold letter-spacing-1" id="corruptionCaseCaseStage"></p>
												<small class="display-block border-bottom border-secondary text-uppercase">Detalle sobre la etapa</small>
												<p class="text-uppercase pb-1 mb-0 text-default font-weight-bold letter-spacing-1" id="corruptionCaseCaseStageDetail"></p>
											</div>
										</div>
										<div class="col-sm-2 fz20 mb-1 mb-sm-0 mt-1 mb-sm-0 pt-3 pb-2">
											<i class="fas fa-users"></i>
										</div>
										<div class="col-sm-10 p-1">
											<div class="bg-white mb-1 p-2 p-sm-2" > 
												<small class="display-block border-bottom border-secondary text-uppercase">Número de involucrádos</small>
												<p class="text-uppercase pb-1 mb-0 text-default font-weight-bold letter-spacing-1" id="corruptionCaseInvolvedNumber"></p>
											</div>
										</div>
										<div class="col-sm-2 fz20 mb-1 mb-sm-0 mt-1 mb-sm-0 pt-3 pb-2">
											<i class="far fa-calendar-alt"></i>
										</div>
										<div class="col-sm-10 p-1">
											<div class="bg-white mb-1 p-2 p-sm-2" > 
												<small class="display-block border-bottom border-secondary text-uppercase">Periodo</small>
												<p class="text-uppercase pb-1 mb-0 text-default font-weight-bold letter-spacing-1" id="corruptionCasePeriod"></p>
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
												<p class="text-uppercase pb-1 mb-0 text-default font-weight-bold letter-spacing-1" id="corruptionCaseStateFunction"></p>
											</div>
										</div>
										<div class="col-sm-2 fz20 mb-1 mb-sm-0 mt-1 mb-sm-0 pt-3 pb-2">
											<i class="fas fa-landmark"></i>
										</div>
										<div class="col-sm-10 p-1">
											<div class="bg-white mb-1 p-2 p-sm-2" > 
												<small class="display-block border-bottom border-secondary text-uppercase">Instituciones Vinvuladas</small>
												<select class="form-control form-control-sm text-uppercase pb-1 mb-0 border-0 text-default font-weight-bold" id="corruptionCaseLinkedInstitutions">
												</select>
											</div>
										</div>
										<div class="col-sm-2 fz20 mb-1 mb-sm-0 mt-1 mb-sm-0 pt-3 pb-2">
											<i class="fas fa-user"></i>
										</div>
										<div class="col-sm-10 p-1">
											<div class="bg-white mb-1 p-2 p-sm-2" > 
												<small class="display-block border-bottom border-secondary text-uppercase">Involucrados</small>
												<select class="form-control form-control-sm text-uppercase pb-1 mb-0 border-0 text-default font-weight-bold" id="corruptionCasePublicOfficialsInvolved">
												</select>
											</div>
										</div>
										<div class="col-sm-2 fz20 mb-1 mb-sm-0 mt-1 mb-sm-0 pt-3 pb-2">
											<i class="fas fa-map-marker-alt"></i>
										</div>
										<div class="col-sm-10 p-1">
											<div class="bg-white mb-1 p-2 p-sm-2" > 
												<small class="display-block border-bottom border-secondary text-uppercase">Ámbito territorial</small>
												<select class="form-control form-control-sm text-uppercase pb-1 mb-0 border-0 text-default font-weight-bold" id="corruptionCaseProvince">
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-2 fz20 mb-1 mb-sm-0 mt-1 mb-sm-0">
										<div class="align-self-center d-flex justify-content-center mt-2" id="corruptionCaseUrl"></div>
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
	
@endsection



@section('custom-js')
	{!! Html::script('public/backend/assets/plugins/bootstrap-sweetalert/sweetalert.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/js/ui-sweetalert.min.js', ['type' => 'text/javascript']) !!}
	{!! Html::script('public/frontend/js/pages/corruption-cases.min.js', ['type' => 'text/javascript']) !!}

	<script type="text/javascript">
    	$(document).ready(function(){
            @if(session()->exists('successMsg'))
                showAlert('Observatorio Anti Corrupción', '{!! session('successMsg') !!}', 'success');
            @endif

            @if(session()->exists('warningMsg'))
                showAlert('Observatorio Anti Corrupción', '{!! session('warningMsg') !!}', 'warning');
            @endif

            @if(session()->exists('errorMsg'))
                showAlert('Observatorio Anti Corrupción', '{!! session('errorMsg') !!}', 'error');
            @endif
        });
    </script>
@endsection