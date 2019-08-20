@extends('backend.layouts.backend-layout')

@section('custom-css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! Html::style('public/backend/assets/plugins/ladda/ladda-themeless.min.css') !!}
    {!! Html::style('public/backend/assets/plugins/bootstrap-sweetalert/sweetalert.css') !!}
    {!! Html::style('public/backend/assets/plugins/dropify/dist/css/dropify.min.css') !!}
    <!-- END PAGE LEVEL PLUGINS -->
@endsection

@section('title')
	Mi Perfil
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Mi Perfil</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Auth</li>
                    <li class="breadcrumb-item active">Mi Perfil</li>
                </ol>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <h4 class="card-title">
                                  {!! Auth::user()->name !!} {!! Auth::user()->lastname !!}
                                </h4>
                                <h6 class="card-subtitle">
                                  Por favor llene el formulario con los campos indicados
                                </h6>
                            </div>
                        </div>

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Formulario de usuarios -->
                        {!! Form::model($oUser, ['route' => ['backend.profile.save', $oUser->id], 'method' => 'PUT', 'class' => 'form p-t-20', 'name' => 'profileForm', 'id' => 'profileForm', 'files' => true]) !!}

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h4 class="card-title">Avatar</h4>
                                        <label for="avatar">Por favor seleccione su avatar. Unicamente se aceptan archivos de tipo PNG, JPG, GIF.</label>
                                        @php
                                            $defaultAvatar = asset('public/backend/assets/images/default-user.png');
                                            if(is_object($oUser)){
                                                if($oUser->avatar != ""){
                                                    if($env == 'production'){
                                                        $defaultAvatar = asset($oStorage->url($oUser->avatar));
                                                    }else{
                                                        $defaultAvatar = asset('public'.$oStorage->url($oUser->avatar));
                                                    }
                                                }
                                            }
                                        @endphp
                                        {!! Form::file('avatar',['id' => 'avatar', 'class' => 'dropify', 'data-show-remove' => 'false', 'data-default-file' => $defaultAvatar]) !!}
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    
                                    <div class="form-group">
                                        <label for="name">Nombre <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="user-name">
                                                    <i class="ti-user"></i>
                                                </span>
                                            </div>
                                            {!! Form::text('name', null, ['id' => 'name', 'placeholder' => 'Ingrese su nombre', 'class' => 'form-control', 'required']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="lastname">Apellido <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="user-lastname">
                                                    <i class="ti-user"></i>
                                                </span>
                                            </div>
                                            {!! Form::text('lastname', null, ['id' => 'lastname', 'placeholder' => 'Ingrese su apellido', 'class' => 'form-control', 'required']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="user-email">
                                                    <i class="ti-email"></i>
                                                </span>
                                            </div>
                                            {!! Form::email('email', null, ['id' => 'email', 'placeholder' => 'Ingrese su direccion de email', 'class' => 'form-control', 'readonly']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="user-password">
                                                    <i class="ti-lock"></i>
                                                </span>
                                            </div>
                                            {!! Form::password('password', ['id' => 'password', 'placeholder' => 'Cambie su clave', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">Confirmar Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="user-password-confirmation">
                                                    <i class="ti-lock"></i>
                                                </span>
                                            </div>
                                            {!! Form::password('password_confirmation', ['id' => 'password_confirmation', 'placeholder' => 'Confirme su clave', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-block btn-outline-info ladda-button" data-style="zoom-out" name="profileBtn" id="profileBtn">
                                            <i class="fa fa-save"></i>
                                            <span class="ladda-label">Guardar mis datos</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
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
    {!! Html::script('public/backend/assets/js/form-validate/form-validation-profile.min.js', ['type' => 'text/javascript']) !!}
    <!-- jQuery file upload -->
    {!! Html::script('public/backend/assets/plugins/dropify/dist/js/dropify.min.js', ['type' => 'text/javascript']) !!}
    
    <!--Custom JavaScript -->
    <script type="text/javascript">

        var urlProfile = '{!! route('backend.profile') !!}';
        $(document).ready(function() {
            $('.dropify').dropify();
            FormProfileValidation.init();
        });
        
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
@endsection