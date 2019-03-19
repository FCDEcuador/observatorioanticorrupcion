    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    {!! Html::script('public/backend/assets/plugins/jquery/jquery.min.js', ['type' => 'text/javascript']) !!}
    <!-- Bootstrap tether Core JavaScript -->
    {!! Html::script('public/backend/assets/plugins/bootstrap/js/popper.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/bootstrap/js/bootstrap.min.js', ['type' => 'text/javascript']) !!}
    <!-- slimscrollbar scrollbar JavaScript -->
    {!! Html::script('public/backend/assets/js/perfect-scrollbar.jquery.min.js', ['type' => 'text/javascript']) !!}
    <!--Wave Effects -->
    {!! Html::script('public/backend/assets/js/waves.min.js', ['type' => 'text/javascript']) !!}
    <!--Menu sidebar -->
    {!! Html::script('public/backend/assets/js/sidebarmenu.min.js', ['type' => 'text/javascript']) !!}
    <!--stickey kit -->
    {!! Html::script('public/backend/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/sparkline/jquery.sparkline.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/bootstrap-sweetalert/sweetalert.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/js/ui-sweetalert.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/ladda/spin.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/ladda/ladda.min.js', ['type' => 'text/javascript']) !!}
    <!--Custom JavaScript -->
    {!! Html::script('public/backend/assets/js/custom.min.js', ['type' => 'text/javascript']) !!}

    <script type="text/javascript">
        $(document).ready(function(){
            @if(session()->exists('successMsg'))
                showAlert('Observatorio Anti Corrupción', '{!! session('successMsg') !!}', 'success');
            @endif

            @if(session()->exists('warningMsg'))
                showAlert('Observatorio Anti Corrupción', '{!! session('warningMsg') !!}', 'warning');
            @endif

            @if(session()->exists('errorMsg'))
                showAlert('Observatorio Anti Corrupción', '{!! session('errorMsg') !!}', 'error');
            @endif
        });
    </script>