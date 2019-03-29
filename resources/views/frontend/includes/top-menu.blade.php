<!-- BEGIN SLIDER HEADER REPEAT ALL SITE -->

<div class="container">
	<div class="row mb-4">
		    <div class="col-12 col-sm-3 media mt-3 mt-sm-0 mb-3 mb-md-0 justify-content-end">
		      	<a href="{!! route('home') !!}" class="align-self-center mx-auto mx-sm-0 ">
		      		@if($oConfiguration->frontend_logo != '')
		      			<img src="{!! asset($oStorage->url($oConfiguration->frontend_logo)) !!}" />
		      		@else
		      			<img src="{!! asset('public/frontend/images/logo-sitio.png') !!}" />
		      		@endif
		      	</a>
		    </div>
		    <div class="col-12 col-sm-9">
		    	<!--  BEGIN MENU  -->
		    	<nav class="navbar navbar-expand-lg navbar-dark bg-dark menu ">
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				  </button>
				  <div class="collapse navbar-collapse" id="navbarNav">
				    <ul class="navbar-nav mr-auto">
				      	@if($topMenuItems)
				      		@if($topMenuItems->isNotEmpty())
				      			@foreach($topMenuItems as $oTopMenuItem)
				      				@php
		                          		$subTopMenuItems = $oTopMenuItem->menuItems;
		                        	@endphp
		                        	@if($subTopMenuItems->isNotEmpty())
		                        		<li class="nav-item dropdown">
				        
									        <a class="nav-link dropdown-toggle" href="{!! url($oTopMenuItem->link) !!}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" target="{!! $oTopMenuItem->target !!}">
									          {!! $oTopMenuItem->title !!}
									        </a>
									        
									        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
									          	@foreach($subTopMenuItems as $oSubTopMenuItem)
									          		<a class="dropdown-item" href="{!! url($oSubTopMenuItem->link) !!}" target="{!! $oSubTopMenuItem->target !!}">
									          			{!! $oSubTopMenuItem->title !!}
									          		</a>
									          	@endforeach
									        </div>

								      	</li>
		                        	@else
		                        		<li class="nav-item">
								        	<a class="nav-link" href="{!! url($oTopMenuItem->link) !!}" target="{!! $oTopMenuItem->target !!}">
								        		{!! $oTopMenuItem->title !!}
								        	</a>
								      	</li>
		                        	@endif
				      			@endforeach
				      		@endif
				      	@endif
				    </ul>
				  </div>
				</nav>

		    	<!--  END MENU  -->


		      <!--  BEGIN CAROUSEL  -->
		      	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
				  <ol class="carousel-indicators">
				    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
				    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
				    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
				  </ol>
				  <div class="carousel-inner">
				    <div class="carousel-item active">
				      <img class="d-block w-100" src="{!! asset('public/images/inicio-1.jpg') !!}" alt="First slide">
				    </div>
				    <div class="carousel-item">
				      <img class="d-block w-100" src="{!! asset('public/images/inicio-2.jpg') !!}" alt="Second slide">
				    </div>
				    <div class="carousel-item">
				      <img class="d-block w-100" src="{!! asset('public/images/inicio-3.jpg') !!}" alt="Third slide">
				    </div>
				  </div>
				  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
				    <span class="sr-only">Anterior</span>
				  </a>
				  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				    <span class="carousel-control-next-icon" aria-hidden="true"></span>
				    <span class="sr-only">Siguiente</span>
				  </a>
				</div>
		      <!--  END CAROUSEL -->
		    </div>
	</div>
</div>

<!-- END  SLIDER HEADER REPEAT ALL SITE -->