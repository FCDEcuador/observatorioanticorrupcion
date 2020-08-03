	
	{!! $oConfiguration->google_analytics_script !!}
	{!! $oConfiguration->another_mark_top_script !!}

	<!-- Required meta tags -->
	{!! Html::meta(null, null, ['charset' => 'utf-8']) !!}
	{!! Html::meta('viewport', 'width=device-width, initial-scale=1, shrink-to-fit=no') !!}

	{!! SEO::generate() !!}

	<link rel="apple-touch-icon" sizes="57x57" href="{!! asset('frontend/images/apple-icon-57x57.png') !!}">
	<link rel="apple-touch-icon" sizes="60x60" href="{!! asset('frontend/images/apple-icon-60x60.png') !!}">
	<link rel="apple-touch-icon" sizes="72x72" href="{!! asset('frontend/images/apple-icon-72x72.png') !!}">
	<link rel="apple-touch-icon" sizes="76x76" href="{!! asset('frontend/images/apple-icon-76x76.png') !!}">
	<link rel="apple-touch-icon" sizes="114x114" href="{!! asset('frontend/images/apple-icon-114x114.png') !!}">
	<link rel="apple-touch-icon" sizes="120x120" href="{!! asset('frontend/images/apple-icon-120x120.png') !!}">
	<link rel="apple-touch-icon" sizes="144x144" href="{!! asset('frontend/images/apple-icon-144x144.png') !!}">
	<link rel="apple-touch-icon" sizes="152x152" href="{!! asset('frontend/images/apple-icon-152x152.png') !!}">
	<link rel="apple-touch-icon" sizes="180x180" href="{!! asset('frontend/images/apple-icon-180x180.png') !!}">
	<link rel="icon" type="image/png" sizes="192x192"  href="{!! asset('frontend/images/android-icon-192x192.png') !!}">
	<link rel="icon" type="image/png" sizes="32x32" href="{!! asset('frontend/images/favicon-32x32.png') !!}">
	<link rel="icon" type="image/png" sizes="96x96" href="{!! asset('frontend/images/favicon-96x96.png') !!}">
	<link rel="icon" type="image/png" sizes="16x16" href="{!! asset('frontend/images/favicon-16x16.png') !!}">
	<link rel="manifest" href="{!! asset('frontend/images/manifest.json') !!}">

	{!! Html::meta('msapplication-TileColor', '#ffffff') !!}
	{!! Html::meta('msapplication-TileImage', asset('frontend/images/ms-icon-144x144.png')) !!}
	{!! Html::meta('theme-color', '#ffffff') !!}

	<!-- Bootstrap CSS -->	
	{!! Html::style('frontend/css/bootstrap.min.css', ['crossorigin' => 'anonymous']) !!}
	<!-- Font-awesome CSS -->
	{!! Html::style('frontend/css/all.css') !!}

	{!! Html::style('frontend/css/custom.css') !!}

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

	@yield('custom-css')

	{!! Html::script('frontend/js/jquery-3.3.1.slim.min.js', ['type' => 'text/javascript']) !!}
	{!! Html::script('frontend/js/Chart.min.js', ['type' => 'text/javascript']) !!}
	{!! Html::script('frontend/js/amcharts.js', ['type' => 'text/javascript']) !!}
	{!! Html::script('frontend/js/serial.js', ['type' => 'text/javascript']) !!}
    <!-- Go to www.addthis.com/dashboard to customize your tools --> 
    {!! Html::script('https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c6df5f8f2935ace', ['type' => 'text/javascript']) !!}