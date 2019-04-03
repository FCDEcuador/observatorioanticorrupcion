@extends('frontend.layouts.frontend-layout')

@section('title')
	{!! $oCorruptionCase->title !!}
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
	</div>
	<!-- END SECCION NOTA DESTACADA -->

		
	<div class="container">
		@if($oCorruptionCase->history != '')
			<!-- BEGIN SECCION ANTECEDENTES -->
			<div class="row mt-3 mb-3">
				<div class="col-6">
					<h1 class="titulo border-bottom border-info text-info text-uppercase">ANTECEDENTES</h1>
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
					<h1 class="titulo border-bottom bormorado morado text-uppercase">¿Qué ocurrió?</h1>
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
		          				Causas Jurídicas
		        			</a>
		      			</h3>
		    		</div>

		    		<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
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
		          				Causas Técnicas
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
						<div class="subtitulo text-white font-italic mt-3">
							Sociales
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
						<h6 class="text-white text-uppercase font-weight-bold font-italic">Fuentes</h6>
						<div class="detalle text-white fz12">
							{!! $oCorruptionCase->sources !!}
						</div>
					</div>
				</div>
			</div>
		@endif
		<!-- END SECCION CONSECUENCIAS -->
@endsection