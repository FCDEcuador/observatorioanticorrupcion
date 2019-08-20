<!DOCTYPE html>
<html lang="es">

<head>
    
    {!! Html::meta(null, null, ['charset' => 'utf-8']) !!}
    {!! Html::meta(null, 'IE=edge', ['http-equiv' => 'X-UA-Compatible']) !!}
    <!-- Tell the browser to be responsive to screen width -->
    {!! Html::meta('viewport', 'width=device-width, initial-scale=1') !!}
    {!! Html::meta('description', '') !!}
    {!! Html::meta('author', 'Buhoo Artesanos Digitales') !!}
    <!-- Favicon icon -->
    {!! Html::favicon('public/images/faviconBlaud.png', ['type' => 'image/png', 'sizes' => '16x16']) !!}

    <title>BlaudCMS :: @yield('title')</title>

    <!-- Bootstrap Core CSS -->
    {!! Html::style('public/backend/assets/plugins/bootstrap/css/bootstrap.min.css') !!}
    <!-- Custom CSS -->
    {!! Html::style('public/backend/assets/css/icons/font-awesome/css/font-awesome.min.css') !!}
    {!! Html::style('public/backend/assets/css/icons/simple-line-icons/css/simple-line-icons.css') !!}
    {!! Html::style('public/backend/assets/css/icons/weather-icons/css/weather-icons.min.css') !!}
    {!! Html::style('public/backend/assets/css/icons/themify-icons/themify-icons.css') !!}
    {!! Html::style('public/backend/assets/css/icons/flag-icon-css/flag-icon.min.css') !!}
    {!! Html::style('public/backend/assets/css/icons/material-design-iconic-font/css/materialdesignicons.min.css') !!}
    {!! Html::style('public/backend/assets/css/style.css') !!}
    <!-- You can change the theme colors from here -->
    {!! Html::style('public/backend/assets/css/colors/default-dark.css') !!}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

    @yield('custom-css')
</head>

<body class="card-no-border">
    
    @include('backend.includes.preloader')

    @yield('main-content')
    
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    {!! Html::script('public/backend/assets/plugins/jquery/jquery.min.js', ['type' => 'text/javascript']) !!}
    <!-- Bootstrap tether Core JavaScript -->
    {!! Html::script('public/backend/assets/plugins/bootstrap/js/popper.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/bootstrap/js/bootstrap.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/js/perfect-scrollbar.jquery.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/js/sidebarmenu.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/bootstrap-sweetalert/sweetalert.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/js/ui-sweetalert.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/ladda/spin.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/ladda/ladda.min.js', ['type' => 'text/javascript']) !!}
    <!--Custom JavaScript -->
    {!! Html::script('public/backend/assets/js/custom.min.js', ['type' => 'text/javascript']) !!}
    
    @yield('custom-js')
    
</body>

</html>