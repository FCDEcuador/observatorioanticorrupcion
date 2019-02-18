	<title>Observatorio Anticorrupción | @yield('title')</title>

	<!-- Required meta tags -->
	{!! Html::meta(null, null, ['charset' => 'utf-8']) !!}
	{!! Html::meta('viewport', 'width=device-width, initial-scale=1, shrink-to-fit=no') !!}

	<!-- Bootstrap CSS -->
	{!! Html::style('public/backend/assets/plugins/bootstrap/css/bootstrap.min.css', ['crossorigin' => 'anonymous']) !!}
	<!-- Font-awesome CSS -->
	{!! Html::style('public/frontend/css/all.css') !!}

	{!! Html::style('public/frontend/css/custom.css') !!}

	@yield('custom-css')