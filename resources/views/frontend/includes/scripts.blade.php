    {!! Html::script('https://code.jquery.com/jquery-3.3.1.min.js', ['type' => 'text/javascript', 'crossorigin' => 'anonymous']) !!}
    {!! Html::script('frontend/js/popper.min.js', ['type' => 'text/javascript', 'crossorigin' => 'anonymous']) !!}
    {!! Html::script('frontend/js/bootstrap.min.js', ['type' => 'text/javascript', 'crossorigin' => 'anonymous']) !!}
    {!! Html::script('frontend/js/Chart.min.js', ['type' => 'text/javascript', 'crossorigin' => 'anonymous']) !!}
    {!! Html::script('frontend/js/all.js', ['type' => 'text/javascript', 'crossorigin' => 'anonymous']) !!}
	{!! Html::script('frontend/js/custom.js', ['type' => 'text/javascript', 'crossorigin' => 'anonymous']) !!}

    <script type="text/javascript">
        sliderObj = document.getElementById("casos-corrupcion");
        valueObj = "#casos-corrupcion";
    </script>

    <script  src="frontend/js/index.js"></script>

    @yield('custom-js')

    {!! $oConfiguration->another_mark_bottom_script !!}

    {!! $oConfiguration->add_this_script !!}

    {!! $oConfiguration->disqus_script !!}