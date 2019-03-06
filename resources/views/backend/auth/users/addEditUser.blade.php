@extends('backend.layouts.backend-layout')

@section('custom-css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! Html::style('public/backend/assets/css/pages/ui-bootstrap-page.css') !!}
    <!-- END PAGE LEVEL PLUGINS -->
    {!! Html::style('public/backend/assets/plugins/wizard/steps.css') !!}
    {!! Html::style('public/backend/assets/plugins/dropify/dist/css/dropify.min.css') !!}
@endsection

@section('title')
	Auth :: Usuarios
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Usuarios del Sistema</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Auth</li>
                    <li class="breadcrumb-item">
                        <a href="{!! route('backend.auth.users.list') !!}">
                            Usuarios
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        @if(is_object($oUser))
                            Editar Usuario
                        @else
                            Agregar Usuario
                        @endif
                    </li>
                </ol>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row" id="validation">
            <div class="col-12">
                <div class="card wizard-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <h4 class="card-title">
                                  @if(is_object($oUser))
                                    Editar Usuario
                                  @else
                                    Agregar Usuario
                                  @endif
                                </h4>
                                <h6 class="card-subtitle">
                                  Por favor llene el formulario con los campos indicados
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_view_users')
                                    <a href="{!! route('backend.auth.users.list') !!}" class="btn btn-info btn-sm waves-effect waves-light" data-toggle="tooltip" title="Agregar Usuario">
                                        <span class="btn-label">
                                            <i class="ti-menu-alt"></i>
                                        </span>
                                        Lista de Usuarios
                                    </a>
                                @endcan
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
                        </div>

                        
                        <!-- Formulario de usuarios -->
                        @if(is_object($oUser))
                            {!! Form::model($oUser, ['route' => ['backend.auth.users.update', $oUser->id], 'method' => 'PUT', 'class' => 'validation-wizard wizard-circle form p-t-20', 'name' => 'userForm', 'id' => 'userForm', 'files' => true]) !!}
                            {!! Form::hidden('id', $oUser->id) !!}
                        @else
                            {!! Form::open(['route' => 'backend.auth.users.store', 'method' => 'POST', 'name' => 'userForm', 'id' => 'userForm', 'class' => 'validation-wizard wizard-circle form p-t-20', 'files' => true]) !!}
                        @endif

                            <!-- Paso 1 -->
                            <h6>Datos Generales</h6>
                            <section>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="avatar">
                                                <strong>Avatar : </strong><br />
                                                <small>Por favor seleccione el avatar del usuario que se va a crear. Unicamente archivos de imagen (PNG, JPG, JPEG, GIF).</small>
                                            </label>
                                            @php
                                                $dataDefaultFile = '';
                                                if(is_object($oUser)){
                                                    if($oUser->avatar){
                                                        $dataDefaultFile = asset($oStorage->url($oUser->avatar));
                                                    }
                                                }
                                            @endphp
                                            {!! Form::file('avatar', ['id' => 'avatar', 'class' => 'dropify', 'data-max-file-size' => '1M', 'data-show-errors' => 'true', 'data-default-file' => $dataDefaultFile ]) !!}
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name"> Nombre : <span class="danger">*</span> </label>
                                            {!! Form::text('name', null, ['id' => 'name', 'class' => 'form-control', 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname"> Apellido : <span class="danger">*</span> </label>
                                            {!! Form::text('lastname', null, ['id' => 'lastname', 'class' => 'form-control', 'required']) !!} 
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type"> Tipo de Usuario : <span class="danger">*</span> </label>
                                            {!! Form::select('type', ['S' => 'Superadministrator', 'A' => 'Administrator', 'B' => 'BackOffice', 'R' => 'Reporter', 'U' => 'Standard User'], null, ['id' => 'type', 'class' => 'custom-select form-control required', 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status"> Estado : <span class="danger">*</span> </label>
                                            {!! Form::select('status', [1 => 'Activo', 0 => 'Inactivo'], null, ['id' => 'status', 'class' => 'custom-select form-control required', 'required']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="wemailAddress2"> Email : <span class="danger">*</span> </label>
                                            {!! Form::email('email', null, ['id' => 'email', 'class' => 'form-control', 'required']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password"> Password : <span class="danger">*</span> </label>
                                            {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirmar Password :</label>
                                            {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation']) !!}
                                        </div>
                                    </div>
                                </div>
                                
                            </section>
                            
                            <!-- Paso 2 -->
                            <h6>Roles</h6>
                            <section>
                                <h4 class="card-title">Seleccione al menos un Rol para este usuario</h4>
                                <div class="form-group">
                                    {!! Form::checkbox('selectAllRoles', 1, false, ['id' => 'selectAllRoles', 'class' => 'filled-in chk-col-light-blue', 'onclick' => 'toggle(this, \'roles[]\')']) !!}
                                    {!! Form::label('selectAllRoles', 'Seleccionar Todo') !!}
                                </div>
                                @if($rolesList->isNotEmpty())
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                        @foreach($rolesList as $oRole)
                                            @php
                                                $checked = false;
                                                if($oUser){
                                                    if($oUser->hasRole($oRole->id)){
                                                        $checked = true;
                                                    }
                                                }
                                            @endphp
                                                <fieldset>
                                                    {!! Form::checkbox('roles[]', $oRole->id, $checked, ['id' => 'role_'.$oRole->id, 'class' => 'chk-col-light-blue']) !!}
                                                    {!! Form::label('role_'.$oRole->id, $oRole->name) !!}
                                                </fieldset>
                                        @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <div class="alert alert-info">
                                            Aún no se han generado roles en el sistema
                                        </div>
                                    </div>
                                @endif
                            </section>
                            
                            <!-- Paso 3 -->
                            <h6>Permisos</h6>
                            <section>
                                <h4 class="card-title">Seleccione los permisos directos que necesite para este usuario</h4>
                                <div class="form-group">
                                    {!! Form::checkbox('selectAllPermissions', 1, false, ['id' => 'selectAllPermissions', 'class' => 'filled-in chk-col-light-blue', 'onclick' => 'toggle(this, \'permissions[]\')']) !!}
                                    {!! Form::label('selectAllPermissions', 'Seleccionar Todo') !!}
                                </div>
                                @if(count($permissionsList))
                                    <hr />
                                    <div class="row"> 
                                        @foreach ($permissionsList as $key => $value)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h3 class="box-title" style="text-transform: capitalize;">
                                                        {!! $key !!}
                                                    </h3>
                                                    @if(count($value))
                                                        @foreach ($value as $name => $label)
                                                            @php
                                                                $checked = false;
                                                                if($oRole){
                                                                    if($oRole->hasPermissionTo($name)){
                                                                        $checked = true;
                                                                    }
                                                                }
                                                            @endphp
                                                            <fieldset>
                                                                {!! Form::checkbox('permissions[]', $name, $checked, ['id' => 'permission_'.$name, 'class' => 'chk-col-light-blue']) !!}
                                                                {!! Form::label('permission_'.$name, $label) !!}
                                                            </fieldset>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                        @endforeach
                                    </div>
                                @else
                                    <div class="form-group">
                                        <div class="alert alert-info">
                                            Aún no se han generado permisos en el sistema
                                        </div>
                                    </div>
                                @endif
                            </section>

                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-outline-info ladda-button" data-style="zoom-out" name="userBtn" id="userBtn">
                                    <i class="fa fa-save"></i>
                                    <span class="ladda-label">Guardar Usuario</span>
                                </button>
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
    {!! Html::script('public/backend/assets/plugins/jquery-validation/js/jquery.validate.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/jquery-validation/js/additional-methods.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/jquery.blockui.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/wizard/jquery.steps.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/dropify/dist/js/dropify.min.js', ['type' => 'text/javascript']) !!}
    <script type="text/javascript">
        var urlUsersList = '{!! route('backend.auth.users.list') !!}';
        @if(is_object($oUser))
            var urlValidateUser = '{!! route('backend.auth.users.validate', [$oUser->id]) !!}';
        @else
            var urlValidateUser = '{!! route('backend.auth.users.validate') !!}';
        @endif
    </script>
    {!! Html::script('public/backend/assets/js/form-validate/form-validation-users.min.js', ['type' => 'text/javascript']) !!}
@endsection