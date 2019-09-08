@extends('frontend.layouts.frontend-layout')

@section('title')
	FDC
@endsection

@section('custom-css')
@endsection

@section('main-content')
	
	<!-- BEGIN SECCION CASOS DE CORRUPCION -->
	
		<div class="row mb-5">
			<div class="col-md-6 mb-3 mb-md-0">
				<div class="p-3 shadow bg-white rounded home-bq">
					<!--  BEGIN CAROUSEL  -->
					<h1 class="titulo border-bottom border-info text-default text-uppercase mt-3 mt-sm-0 text-sm-left mb-3"><a href="{!! url('/casos-de-corrupcion/') !!}">NUEVOS CASOS DE CORRUPCIÓN</a></h1>
			      	<div id="casos-corrupcion" class="carousel slide" data-ride="carousel">
					  <div class="carousel-inner" style="height: 250px;">
					    @if($corruptionCasesList->isNotEmpty())
						    @foreach($corruptionCasesList as $oCorruptionCase)
							    <div class="carousel-item {!! $loop->first ? 'active' : '' !!}">
							    	<div class="row">
							    		<div class="col-sm-5">
							    			<a href="{!! url('/casos-de-corrupcion/'.$oCorruptionCase->slug) !!}"><img class="d-block w-100" src="{!! $oStorage->url($oCorruptionCase->home_image) !!}" alt="{!! $oCorruptionCase->title !!}"></a>
							    		</div>
							    		<div class="col-sm-7">
							    			<h5 style="margin-left: -15px;" class="subtitulo-home"> {!! $oCorruptionCase->title !!}</h5>
							    			<div style="margin-left: -15px;" class="text-justify text-muted mr-sm-4">{!! $oCorruptionCase->summary !!}
							    				<a href="{!! url('/casos-de-corrupcion/'.$oCorruptionCase->slug) !!}" role="button" class="btn btn-success btn-sm float-right">Entérate</a>
							    			</div>
							    			
							    		</div>
							    	</div>
							    </div>
						    @endforeach
					    @endif
					  </div>
					  <a class="carousel-control-prev" href="#casos-corrupcion" role="button" data-slide="prev">
					    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
					    <span class="sr-only">Previous</span>
					  </a>
					  <a class="carousel-control-next" href="#casos-corrupcion" role="button" data-slide="next">
					    <span class="carousel-control-next-icon" aria-hidden="true"></span>
					    <span class="sr-only">Next</span>
					  </a>
					  
					  <ol class="carousel-indicators d-none d-sm-flex">
					  	@if($corruptionCasesList->isNotEmpty())
						    @foreach($corruptionCasesList as $oCorruptionCase)
						    	<li data-target="#casos-corrupcion" data-slide-to="{!! $loop->index !!}" {!! $loop->first ? 'class="active"' : '' !!}></li>
						    @endforeach
					    @endif
					  </ol>
					</div>
		      	<!--  END CAROUSEL -->
		      </div>
			</div>
			<div class="col-sm-6">
				<div class="p-3 shadow bg-white rounded home-bq">
					<h1 class="titulo border-bottom border-info text-default text-uppercase text-center mb-3 mt-0">Estadísticas</h1>
					<p class="mb-0 text-muted">Estado de los casos de corrupción, información recopilada por nuestro observatorio</p>
					<div class="row">
						@php
							$aAux = [];	
							$aCharts = [];
						@endphp
						@if($aCaseStageList->isNotEmpty())
							@foreach($aCaseStageList as $oCaseStage)
								@if( ! in_array($oCaseStage->case_stage, $aAux))	
									<div class="col-12">
										<!--h6 class="morado pt-2 mb-0 font-weight-bold">{!! $oCaseStage->case_stage !!}</h6-->
										<div class="row no-gutters">
											<div class="col-12 d-flex justify-content-center">
												<div id="chart_{!! $loop->index !!}" style="width: 100%; height: 180px; background-color: #FFFFFF;" ></div>
											</div>
										</div>
									</div>
									@php
										$aAux[] = $oCaseStage->case_stage;	
										$aCharts[] = [
											'caseStage' => $oCaseStage->case_stage,
											'loop' => $loop->index
										];
									@endphp
								@endif
							@endforeach
						@endif
					</div>
					
					
					<script>
					


					function setupChart(chartId, progress, fondo ) {
					  var canvas = document.getElementById(chartId);
					  var context = canvas.getContext('2d');

					  var remaining = 100 - progress;
					  var data = {
					    labels: [ 'Progress', '', ],
					    datasets: [{
					      data: [progress, remaining],
					      backgroundColor: [
					        fondo,
					        '#d2e6ed'
					      ],
					      borderColor: [
					        fondo,
					        '#d2e6ed'
					      ],
					      hoverBackgroundColor: [
					        fondo,
					        '#FFFFFF'
					      ]
					    }]
					  };

					  var options = {
					    responsive: true,
					    maintainAspectRatio: false,
					    scaleShowVerticalLines: false,

					    cutoutPercentage: 80,
					    legend: {
					      display: false
					    },
					    animation: {
					      onComplete: function (event) {
					      	console.log(this.chart.height);
					        var xCenter = this.chart.width/2;
					        var yCenter = this.chart.height/2;

					        context.textAlign = 'center';
					        context.textBaseline = 'middle';

					        var progressLabel = data.datasets[0].data[0] + '%';
					        context.font = '32px Helvetica';
					        context.fillStyle = 'black';
					        context.fillText(progressLabel, xCenter, yCenter);
					      }
					    }
					  };

					  Chart.defaults.global.tooltips.enabled = false;
					  var chart = new Chart(context, {
					    type: 'doughnut',
					    data: data,
					    options: options
					  });
					}

					</script>

					<div class="clearfix">
						<a href="{!! route('statistics') !!}" role="button" class="btn btn-success btn-sm bgmorado mt-2 float-right">conoce más aquí</a>
					</div>
				</div>			
			</div>
		</div>
	
	<!-- END SECCION CASOS DE CORRUPCION -->


	<!-- BEGIN BANNER JUEGO -->
		<!--
		<div class="row mt-3 shadow mb-5 bg-white rounded banner-juego" style="background-image: url('https://picsum.photos/1000/260?auto=yes&bg=666&fg=444&text=banner');" >
			<div class="col-8 col-sm-6 d-flex align-items-center">
				<h3 class="text-white">¿Sabes como se sancionan los casos de corrupción?</h3>
			</div>
			<div class="col-4 col-sm-6 d-flex align-items-end justify-content-end mb-3">
				<button type="button" class="btn btn-success btn-sm float-right">Descúbrelo jugando</button>
			</div>
		</div>
		-->
	<!-- END BANNER JUEGO -->

	@if(is_object($oContentCategory))

		<!-- BEGIN SECCION PUBLICACIONES -->
			<div class="container mb-5">
				<div class="row pb-3 pt-3 shadow bg-white rounded">
					<div class="col-12">
						<h1 class="titulo border-bottom border-info text-default mb-3">
							{!! strtoupper($oContentCategory->name) !!}
						</h1>
					</div>
					@php
						$aContentArticles = $oContentCategory->contentArticles()->take(2)->get();	
					@endphp
					@if($aContentArticles->isNotEmpty())
						@foreach($aContentArticles as $oContentArticle)
							<div class="col-sm-6">
								<div class="row">
									<div class="col-4 d-flex align-items-start  pr-0 pl-sm-3 pr-sm-3">
										<img class="d-block w-100" src="{!! $oStorage->url($oContentArticle->main_multimedia) !!}" alt="{!! $oContentArticle->title !!}">
									</div>
									<div class="col-8 text-justify">
										<a href="{!! route('content-article', [$oContentCategory->slug, $oContentArticle->slug]) !!}" class="subtitulo text-default">
											{!! $oContentArticle->title !!}
										</a>
										<p class="text-muted">{!! $oContentArticle->summary !!}</p>
									</div>
								</div>
							</div>
						@endforeach
					@endif
						
					<div class="col-12">
						<a href="{!! route('content-category', [$oContentCategory->slug]) !!}" role="button" class="btn btn-info btn-sm float-right ">Ver más</a>
					</div>
				</div>
			</div>
		<!-- END SECCION PUBLICACIONES -->	
	@endif


	<!-- BEGIN SECCION BIBLIOTECA E HISTORIAS -->
		<div class="container mb-5">
			<div class="row pb-3 pt-3 shadow  bg-white rounded">
					<div class="col-sm-6">
						<div class="row no-gutters">
							<div class="col-sm-5 align-self-start pr-0 pr-sm-3">
								@if(is_object($oHomeField))
									@if($oHomeField->legal_library_image != '')
										<img class="d-block w-100" src="{!! asset($oStorage->url($oHomeField->legal_library_image)) !!}" alt="Biblioteca Legal">
									@else
										<img class="d-block w-100" src="{!! asset('public/images/biblioteca-legal.jpg') !!}" alt="Biblioteca Legal">
									@endif
								@else
									<img class="d-block w-100" src="{!! asset('public/images/biblioteca-legal.jpg') !!}" alt="Biblioteca Legal">
								@endif
							</div>
							<div class="col-sm-7 pl-3">
								<h1 class="titulo text-default text-uppercase mt-3 mt-sm-0">Biblioteca Legal</h1>
								@if(is_object($oHomeField))
									@if($oHomeField->legal_library_text != '')
										<p class="text-justify text-muted">{!! $oHomeField->legal_library_text !!}</p>
									@else
										<p class="text-justify text-muted">Aquí puedes encontrar  las principales leyes, reglamentos y decretos que abordan temas y mecanismos de prevención y sanción a los actos de corrupción en Ecuador</p>
									@endif
								@else
									<p class="text-justify text-muted">Aquí puedes encontrar  las principales leyes, reglamentos y decretos que abordan temas y mecanismos de prevención y sanción a los actos de corrupción en Ecuador</p>
								@endif

								<a href="{!! route('legal-library') !!}" role="button" class="btn btn-info btn-sm float-right">Ver más</a>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row no-gutters bgvioleta mt-3 mt-sm-0" >
							<div class="col-12">
								<h4 class="pl-4 pr-4 pb-3 pt-3 text-white text-uppercase" style="font-size: 18px;line-height: 22px;text-align: justify;margin-bottom: 0px;">
									@if(is_object($oHomeField))
										@if($oHomeField->success_stories_title != '')
											{!! $oHomeField->success_stories_title !!}
										@else
											Conoce historias de éxito sobre la lucha contra la corrupción
										@endif
									@else
										Conoce historias de éxito sobre la lucha contra la corrupción
									@endif
								</h4>
							</div>
						</div>
						<div class="row no-gutters border-left borazul">
							<div class="col-sm-9 p-3">
								<p class="text-justify text-muted">
									@if(is_object($oHomeField))
										@if($oHomeField->success_stories_text != '')
											{!! $oHomeField->success_stories_text !!}
										@else
											Entérate de experiencias exitosas a nivel mundial sobre la lucha contra la corrupción. 
										@endif
									@else
										Entérate de experiencias exitosas a nivel mundial sobre la lucha contra la corrupción. 
									@endif
								</p>
								<a href="{!! route('success-stories') !!}" role="button" class="btn btn-success btn-sm float-right">Ver más</a>
							</div>
							<div class="col-sm-3 align-self-start">
								@if(is_object($oSuccessStory))
									@if($oSuccessStory->image != '')
										<img class="d-block w-100" src="{!! $oStorage->url($oSuccessStory->image) !!}" alt="Historias de Exito">
									@else
										<img class="d-block w-100" src="{!! asset('public/images/historias.jpg') !!}" alt="Historias de Exito">	
									@endif
								@else
									<img class="d-block w-100" src="{!! asset('public/images/historias.jpg') !!}" alt="Historias de Exito">
								@endif
							</div>
						</div>
					</div>
			</div>
		</div>
	<!-- END SECCION BIBLIOTECA E HISTORIAS -->
@endsection


<script src='https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.js'></script>
@section('custom-js')
	
	<!-- amCharts javascript code -->
	<script type="text/javascript">
			
			var data;
			@if($aCaseStageList->isNotEmpty())
				@php
					$aAux = [];
					$k = 1;
				@endphp
				@foreach($aCaseStageList as $oCaseStage)
					@php
						$aAux[$oCaseStage->case_stage][] = [
							'category' => ''.strtoupper($oCaseStage->case_stage_detail).'',
							'column-1' => ''.round(($oCaseStage->numCases/$numCases*100),2).'',
							'fill alpha' => 1/$k,
							'dash length' => '',
						];
						$k++;
					@endphp
				@endforeach
			@endif

			@if(count($aCharts))
				@foreach($aCharts as $key => $val)
					console.log({!! json_encode($val) !!});
					//console.log({!! $key[$val] !!});
					data = {!! json_encode($aAux[$val['caseStage']]) !!};
					console.log(data);
					setupChart('chart_{!! $val['loop'] !!}', data);
				@endforeach
			@endif


		function setupChart(chartId, arreglocasos ) {

	        //El total de casos por tipo va a ser el 100 y 
	        //cada subtipo sera calculado con regla de 3 
	        //para ir dibujando cada barra

	        AmCharts.makeChart(chartId,
				{
				"type": "serial",
				"categoryField": "category",
				"columnSpacing": 0,
				"rotate": true,
				"autoMarginOffset": 0,
				"marginBottom": 0,
				"marginLeft": 0,
				"marginRight": 0,
				"marginTop": 0,
				"colors": [
					"#94D500",
					
				],
				"startDuration": 1,
				"classNamePrefix": "estadisticas",
				"fontSize": 14,
				"handDrawScatter": 1,
				"categoryAxis": {
					"classNameField": "c_categorias",
					"gridPosition": "start",
					"axisColor": "#FFFFFF",
					"gridColor": "#FFFFFF"
				},
				"trendLines": [],
				"graphs": [
					{
						"alphaField": "fill alpha",
						"dashLengthField": "dash length",
						"fillAlphas": 1,
						"id": "AmGraph-1",
						"lineThickness": 0,
						"title": "graph 1",
						"type": "column",
						"valueField": "column-1"
					},
					{
						"clustered": false,
						"fillAlphas": 0.3,
						"id": "AmGraph-2",
						"labelText": "[[value]]%",
						"lineColor": "#fff",
						"type": "column",
						"valueField": "column-1"
					}
				],
				"guides": [],
				"valueAxes": [
					{
						"id": "ValueAxis-1",
						"position": "bottom",
						"zeroGridAlpha": 0,
						"autoGridCount": false,
						"autoRotateCount": 0,
						"axisColor": "#FFFFFF",
						"fontSize": 0,
						"gridAlpha": 0,
						"gridColor": "#FFFFFF",
						"gridCount": 0,
						"gridThickness": 0,
						"title": ""
					}
				],
				"allLabels": [],
				"balloon": {
				"adjustBorderColor": false,
				"animationDuration": 0,
				"borderThickness": 0,
				"color": "#FFFFFF",
				"disableMouseEvents": false,
				"fadeOutDuration": 0,
				"horizontalPadding": 0,
				"maxWidth": 0,
				"offsetX": 0,
				"offsetY": 0,
				"pointerOrientation": "right"
			},
				"titles": [
					{
						"id": "Title-1",
						"size": 15,
						"text": ""
					}
				],
				"dataProvider": arreglocasos,
			}
			);



	     }
</script>

@endsection