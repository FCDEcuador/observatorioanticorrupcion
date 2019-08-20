@extends('backend.layouts.login-layout')

@section('custom-css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! Html::style('public/backend/assets/plugins/ladda/ladda-themeless.min.css') !!}
    {!! Html::style('public/backend/assets/plugins/bootstrap-sweetalert/sweetalert.css') !!}
    <!-- page css -->
    
    <style type="text/css">
        .login-register{
            background-size:cover;
            background-repeat:no-repeat;
            background-position:50%;
            height:100%;
            width:100%;
            padding:10% 0;
            position:fixed;
        }

        .login-box{
            width:400px;
            margin:0 auto;
        }

        .login-box .footer{
            width:100%;
            left:0;
            right:0;
        }

        .login-box .social{
            display:block;
            margin-bottom:30px;
        }

        #recoverform{
            display:none;
        }

        .login-sidebar{
            padding:0;
            margin-top:0;
        }

        .login-sidebar .login-box{
            right:0;
            position:absolute;
            height:100%;
        }
    </style>
    <!-- END PAGE LEVEL PLUGINS -->
@endsection

@section('title')
	Login
@endsection

@section('main-content')
	<!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
        <div class="login-register">
            <div class="login-box card">
                <div class="card-body">
                    

                    {!! Form::open(['route' => 'backend.login.validate', 'method' => 'POST', 'name' => 'loginform', 'id' => 'loginform', 'class' => 'form-horizontal form-material']) !!}

                        <h3 class="box-title m-b-20">
                            <img src="{!! asset('public/backend/assets/images/logoBlaud.png') !!}" alt="Cuponcity.ec" width="60%" />
                        </h3>
                        <div class="form-group">
                            <div class="col-xs-12">
                                {!! Form::email('email', null, ['id' => 'email', 'placeholder' => 'Email', 'class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                {!! Form::password('password', ['id' => 'password', 'placeholder' => 'Password', 'class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="checkbox checkbox-info pull-left p-t-0">
                                    {!! Form::checkbox('remember', 1, true, ['id' => 'checkbox-signup', 'class' => 'filled-in chk-col-light-blue']); !!}
                                    <label for="remember"> Recordarme </label>
                                </div> <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Olvidó su clave?</a> </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-xs-12 p-b-20">
                                <button type="submit" class="btn btn-block btn-lg btn-info btn-rounded ladda-button" data-style="zoom-out" name="loginBtn" id="loginBtn">
                                    <i class="fa fa-key"></i>
                                    <span class="ladda-label">Entrar</span>
                                </button>
                            </div>
                        </div>
                        
                    {!! Form::close() !!}


                    <form class="form-horizontal" id="recoverform" action="index.html">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h3>Recuperar Clave</h3>
                                <p class="text-muted">Ingrese su Email y recibirá instrucciones en su correo acerca de como cambiar su clave! </p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" placeholder="Email"> </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <button class="btn btn-primary text-uppercase waves-effect waves-light" type="submit">Reset</button>
                            </div>
                            <div class="col-md-6">
                            	<button class="btn btn-danger text-uppercase waves-effect waves-light" type="button" id="to-login">Cancelar</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom-js')
    {!! Html::script('public/backend/assets/plugins/bootstrap-sweetalert/sweetalert.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/js/ui-sweetalert.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/jquery-validation/js/jquery.validate.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/jquery-validation/js/additional-methods.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/ladda/spin.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/ladda/ladda.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/jquery.blockui.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/js/custom.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/js/form-validate/form-validation-login.min.js', ['type' => 'text/javascript']) !!}

    
    <!--Custom JavaScript -->
    <script type="text/javascript">

        var urlBackendDashboard = '{!! route('backend.dashboard') !!}';
        $(document).ready(function() {
            FormLoginValidation.init();
        });
        
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });

        $('#to-login').on("click", function() {
            $("#recoverform").fadeOut();
            $("#loginform").slideDown('slow');
        });
    </script>

@endsection