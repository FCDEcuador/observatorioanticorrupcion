	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    {!! Html::script('public/frontend/js/jquery-3.3.1.slim.min.js', ['type' => 'text/javascript', 'crossorigin' => 'anonymous']) !!}
    {!! Html::script('public/frontend/js/popper.min.js', ['type' => 'text/javascript', 'crossorigin' => 'anonymous']) !!}
    {!! Html::script('public/frontend/js/bootstrap.min.js', ['type' => 'text/javascript', 'crossorigin' => 'anonymous']) !!}
    {!! Html::script('public/frontend/js/custom.js', ['type' => 'text/javascript', 'crossorigin' => 'anonymous']) !!}
    {!! Html::script('public/frontend/js/all.js', ['type' => 'text/javascript', 'crossorigin' => 'anonymous']) !!}

    @yield('custom-js')