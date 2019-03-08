@extends('frontend.layouts.frontend-layout')

@section('title')
	Casos de Corrupción
@endsection

@section('custom-css')	
    {!! Html::style('public/backend/assets/plugins/bootstrap-sweetalert/sweetalert.css') !!}
@endsection



@section('main-content')
	
	
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
			{!! Form::open(['route' => ['corruption-cases'], 'method' => 'GET', 'name' => 'corruptionCasesForm', 'id' => 'corruptionCasesForm']) !!}
				<select class="form-control form-control-sm mb-2 border-left-0 border-right-0 border-top-0 border-info" name="sCaseStage" id="sCaseStage">
				  <option value="">Estado actual del caso</option>
				  @if($caseStageList->isNotEmpty())
				  	@foreach($caseStageList as $oCaseStage)
				  		<option value="{!! $oCaseStage->description !!}">{!! $oCaseStage->description !!}</option>
				  	@endforeach
				  @endif
				</select>
				<select class="form-control form-control-sm mb-2 border-left-0 border-right-0 border-top-0 border-info" name="sProvince" id="sProvince">
				  <option value="">Provincia</option>
				  @if($provinceList->isNotEmpty())
				  	@foreach($provinceList as $oProvince)
				  		<option value="{!! $oProvince->description !!}">{!! $oProvince->description !!}</option>
				  	@endforeach
				  @endif
				</select>
				<select class="form-control form-control-sm mb-2 border-left-0 border-right-0 border-top-0 border-info" name="sStateFunction" id="sStateFunction">
				  <option value="">Función del estado</option>
				  @if($stateFunctionList->isNotEmpty())
				  	@foreach($stateFunctionList as $oStateFunction)
				  		<option value="{!! $oStateFunction->description !!}">{!! $oStateFunction->description !!}</option>
				  	@endforeach
				  @endif
				</select>
				<div class="form-group mb-2">
				    <label for="sStringSearch" class="text-info">Palabras claves</label>
				    <input type="text" class="form-control border-info" id="sStringSearch" name="sStringSearch" placeholder="busqueda">
				</div>
				<div class="align-self-end d-flex justify-content-end">
				  	<button type="submit" class="btn btn-info btn-sm">Buscar</button>
				</div>
			{!! Form::close() !!}
			<!-- END BUSCADOR -->		
		</div>
		<div class="col-sm-9">
			<!-- END LISTADO DE CASOS -->
			<div class="row no-gutters">
				@if($corruptionCasesList->isNotEmpty())
					@foreach($corruptionCasesList as $oCorruptionCase)
						<div class="col-6 col-sm-4 mt-3">
							<div class="shadow m-2 bg-white rounded">
								<img class="d-block w-100" src="{!! $oStorage->url($oCorruptionCase->main_multimedia) !!}" alt="{!! $oCorruptionCase->title !!}">
								<div class="cont-text p-1">
									<h6 class="text-center mt-3">
										<a class="morado" href="#" data-toggle="modal" data-target="#casos-resumen" onclick="javascript: loadCorruptionCase('{!! route('corruption-cases.detail-json', [$oCorruptionCase->id]) !!}');">
											{!! $oCorruptionCase->title !!}
										</a>
									</h6>
								</div>
							</div>
						</div>
					@endforeach
				@endif
			</div>
			<!-- END LISTADO DE CASOS -->

			<div class="row mt-3">
				<div class="col-12">
					{!! $corruptionCasesList->links() !!}
				</div>
			</div>

		</div>
	
	</div>
	<!-- END LISTADO DE CASOS -->



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
												<small class="display-block border-bottom border-secondary text-uppercase">Funcionarios involucrados</small>
												<select class="form-control form-control-sm text-uppercase pb-1 mb-0 border-0 text-default font-weight-bold" id="corruptionCasePublicOfficialsInvolved">
												</select>
											</div>
										</div>
										<div class="col-sm-2 fz20 mb-1 mb-sm-0 mt-1 mb-sm-0 pt-3 pb-2">
											<i class="fas fa-map-marker-alt"></i>
										</div>
										<div class="col-sm-10 p-1">
											<div class="bg-white mb-1 p-2 p-sm-2" > 
												<small class="display-block border-bottom border-secondary text-uppercase">Provincia</small>
												<p class="text-uppercase pb-1 mb-0 text-default font-weight-bold letter-spacing-1" id="corruptionCaseProvince"></p>
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