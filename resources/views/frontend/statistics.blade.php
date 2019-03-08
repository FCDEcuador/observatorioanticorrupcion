@extends('frontend.layouts.frontend-layout')

@section('title')	
@endsection

@section('custom-css')
@endsection

@section('main-content')
	
	
	<!-- BEGIN SECCION NOTA DESTACADA -->
<div class="container-fluid p-3 bg-light imagen-estadisticas" style="background-image: url('https://via.placeholder.com/1000x340');">
	<div class="container">
		<!-- BEGIN SECCION TITULO -->
		<div class="row mt-3 mb-5">
			<div class="col-sm-6">
				<div class="fz32 border-bottom border-white text-white text-uppercase">Estadísticas</div>
			</div>
		</div>
		<!-- END SECCION TITULO -->
		<div class="row" >
			<div class="offset-sm-4 col-sm-4 align-self-center" style="background: rgba(0,0,0,0.5)">
				<div class="row pt-3 pb-3">
					<div class="col-12">
						<div class="row">
							<div class="col-4 pr-0">
								<h3 class="subtitulo text-white text-uppercase text-right text-info fz60">{!! $numCases !!}</h3>
							</div>
							<div class="col-8">
								<h3 class="subtitulo text-white text-uppercase text-info font-italic fz28">Casos investigados</h3>
							</div>
						</div>
					</div>
					<div class="col-5">
						<div class="bg-light text-info fz60 text-center p-1" style="margin-bottom:-15px;padding: 10px!important;"><img src="{!! asset('public/frontend/images/ico-lupa.svg') !!}" class="img-fluid"></div>
					</div>
					<div class="col-7 text-center ">
						<p class="text-uppercase text-white fz12 d-block flex-grow-1" style="margin-bottom: 5px;">por el observatorio hasta:</p>
						<div class="d-flex">
							<div>
								<span class="fechas-circulos mr-2">{!! date('d') !!}</span>
								<span class="text-center text-white mr-2 fz12">DÍA</span>
							</div>
							<div>						
								<span class="fechas-circulos mr-2">{!! date('m') !!}</span>
								<span class="text-center text-white mr-2 fz12">MES</span>
							</div>
							<div>
								<span class="fechas-circulos">{!! date('y') !!}</span>
								<span class="text-center text-white fz12">AÑO</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END SECCION NOTA DESTACADA -->

		
<div class="container">
	<!-- BEGIN SECCION ANTECEDENTES -->
	<div class="row mt-5">
		<div class="col-sm-6">
			<h1 class="titulo border-bottom bormorado morado text-uppercase">etapa actual del caso</h1>
		</div>
		<div class="col-sm-6">
			<a href="" role="button" class="btn btn-success btn-sm float-right">descargar EXCEL</a>
		</div>
	</div>
	<div class="row">
		@if($aCaseStageList->isNotEmpty())
			@php
				$aAux = [];	
				$aCharts = [];
			@endphp
			@foreach($aCaseStageList as $oCaseStage)
				@if( ! in_array($oCaseStage->case_stage, $aAux))	
					<div class="col-12 mt-5">
						<h6 class="border-top bormorado morado pt-2 pb-2 font-weight-bold">{!! $oCaseStage->case_stage !!}</h6>
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
	<!-- END SECCION ANTECEDENTES -->

	
	<!-- BEGIN SECCION DIAGRAMA INFERIOR -->
	<div class="row mt-5">
		<div class="col-sm-6">
			<h1 class="titulo border-bottom bormorado morado text-uppercase">función del estado</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-7 mt-5">
			<div><canvas id="periodistica" class="m-100 h-100" height="400px"></canvas></div>
		</div>
		<div class="col-sm-5 mt-5 align-self-center">
			@if($aStateFunctionList->isNotEmpty())
				@foreach($aStateFunctionList as $oStateFunction)
					<p class="text-secondary text-uppercase">
						<span class="p-1 text-white mr-3 d-inline-block" style="background: #400a99;width: 100px;">
							@php
								$percentStateFunction = 0;
								if($numCases > 0){
									$percentStateFunction = ($oStateFunction->corruptionCaseNum*100) / $numCases;
								}
							@endphp
							{!! round($percentStateFunction, 0, PHP_ROUND_HALF_EVEN) !!} %
						</span>
						{!! $oStateFunction->state_function !!}
					</p>
				@endforeach
			@endif
		</div>
	</div>
	
	<!-- END SECCION DIAGRAMA INFERIOR -->


</div>


@endsection



@section('custom-js')
	
	<!-- amCharts javascript code -->
	<script type="text/javascript">
			
			var data;
			@if($aCaseStageList->isNotEmpty())
				@foreach($aCaseStageList as $oCaseStage)
					@php
						$aAux = [];
						$aAux[$oCaseStage][] = [
							'category' => ''.strtoupper($oCaseStage->case_stage_detail).'',
							'column-1' => ''.$oCaseStage->numCases.'',
							'fill alpha' => '1',
							'dash length' => '',
						];	
					@endphp
				@endforeach
			@endif

			@if(count($aCharts))
				@foreach($aCharts as $key => $val)
					data = {!! json_encode($aAux[$val['caseStage']]) !!};
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
						"labelText": "[[value]]",
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
					"horizontalPadding": 10,
					"offsetX": 2,
					"pointerOrientation": "up",
					"showBullet": true
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


	    @php
	    	$flegislativo = 0;
	    	$fejecutivo = 0;
	    	$fjudicial = 0;
	    	$felectoal = 0;
	    	$ftransparencia = 0;
	    	if($aStateFunctionList->isNotEmpty()){
				foreach($aStateFunctionList as $oStateFunction){
					if($oStateFunction->state_function == 'Función Legislativa'){
						$flegislativo = $oStateFunction->numCases;
					}
					if($oStateFunction->state_function == 'Función Ejecutiva'){
						$fejecutivo = $oStateFunction->numCases;
					}
					if($oStateFunction->state_function == 'Función Judicial'){
						$fjudicial = $oStateFunction->numCases;
					}
					if($oStateFunction->state_function == 'Función Electoral'){
						$felectoal = $oStateFunction->numCases;
					}
					if($oStateFunction->state_function == 'Función de Transparencia y Control Social'){
						$ftransparencia = $oStateFunction->numCases;
					}
				}
	    	}
	    @endphp
	    setupChart1('periodistica', {!! $flegislativo !!}, {!! $fejecutivo !!}, {!! $fjudicial !!}, {!! $felectoal !!}, {!! $ftransparencia !!});

		function setupChart1(chartId, flegislativo, fejecutivo, fjudicial, felectoal, ftransparencia ) {
		  	var canvas = document.getElementById(chartId);
		  	var context = canvas.getContext('2d');

		  	var remaining = 100 - flegislativo;
		  	var remaining2 = 100 - fejecutivo;
		  	var remaining3 = 100 - fjudicial;
		  	var remaining4 = 100 - felectoal;
		  	var remaining5 = 100 - ftransparencia;

		  	var data = {
		    	labels: [ 'Función Legislativa', 'Función Ejecutiva', 'Función Judicial', 'Función Electoral', 'Función de Transparencia y Control Social' ],
		    	datasets: [{
		      		data: [flegislativo, remaining],
		      		backgroundColor: [
		        		'#400a99',
		        		'#fff'
		      		],borderWidth: 1,
		      		borderColor: [
		        		'#400a99',
		        		'#ccc'
		      		],
		      		hoverBackgroundColor: [
		        		'#400a99',
		        		'#FFFFFF'
		      		]
		    	},{
		      		data: [fejecutivo, remaining2],
		      		backgroundColor: [
		        		'#5a16a3',
		        		'#fff'
		      		],borderWidth: 1,
		      		borderColor: [
		        		'#5a16a3',
		        		'#ccc'
		      		],
		      hoverBackgroundColor: [
		        '#5a16a3',
		        '#FFFFFF'
		      ]
		    },{
		      data: [fjudicial, remaining3],
		      backgroundColor: [
		        '#834db8',
		        '#fff'
		      ],borderWidth: 1,
		      borderColor: [
		        '#834db8',
		        '#ccc'
		      ],
		      hoverBackgroundColor: [
		        '#834db8',
		        '#FFFFFF'
		      ]
		    },{
		      data: [felectoal, remaining4],
		      backgroundColor: [
		        '#a87dcc',
		        '#fff'
		      ],borderWidth: 1,
		      borderColor: [
		        '#a87dcc',
		        '#ccc'
		      ],
		      hoverBackgroundColor: [
		        '#a87dcc',
		        '#FFFFFF'
		      ]
		    },{
		      data: [ftransparencia, remaining5],
		      backgroundColor: [
		        '#ccafe0',
		        '#fff'
		      ],borderWidth: 1,
		      borderColor: [
		        '#ccafe0',
		        '#ccc'
		      ],
		      hoverBackgroundColor: [
		        '#ccafe0',
		        '#FFFFFF'
		      ]
		    }],
		  };


		  var options = {
		    responsive: true,
		    maintainAspectRatio: false,
		    scaleShowVerticalLines: false,
		    cutoutPercentage: 50,

		    legend: {
		      display: false
		    },
		    animation: {
		     
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

@endsection