<!DOCTYPE html>
<html>
	<head>
	@include('frontend.includes.head')

</head>
<body>

	<!-- BEGIN SLIDER HEADER REPEAT ALL SITE -->
		
		@include('frontend.includes.top-menu')

	<!-- END  SLIDER HEADER REPEAT ALL SITE -->


	<div class="container mt-3">
		@yield('main-content')	
	</div>

	@include('frontend.includes.footer')

	@include('frontend.includes.scripts')
</body>
</html>