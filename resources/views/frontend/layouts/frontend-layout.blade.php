<!DOCTYPE html>
<html>
	<head>
		@include('frontend.includes.head')
	</head>
<body>

	<!-- BEGIN SLIDER HEADER REPEAT ALL SITE -->
		
		@include('frontend.includes.top-menu')

	<!-- END  SLIDER HEADER REPEAT ALL SITE -->


	<div class="container mt-3" id="mainContent">
		@yield('main-content')	
	</div>

	@include('frontend.includes.footer')

	<div id="scripts">
		@include('frontend.includes.scripts')
	</div>
</body>
</html>