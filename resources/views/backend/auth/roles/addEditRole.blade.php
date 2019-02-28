@extends('backend.layouts.backend-layout')

@section('custom-css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! Html::style('public/backend/assets/css/pages/ui-bootstrap-page.css') !!}
    <!-- END PAGE LEVEL PLUGINS -->
@endsection

@section('title')
	Auth :: Roles
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Roles del Sistema</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Parametrizacion</li>
                    <li class="breadcrumb-item"><a href="{!! route('backend.auth.roles.list') !!}">Roles</a></li>
                    <li class="breadcrumb-item active">
                        @if(is_object($oRole))
                            Editar Rol
                        @else
                            Agregar Rol
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <h4 class="card-title">
                                  @if(is_object($oRole))
                                    Editar Rol
                                  @else
                                    Agregar Rol
                                  @endif
                                </h4>
                                <h6 class="card-subtitle">
                                  Por favor llene el formulario con los campos indicados
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_view_roles')
                                    <a href="{!! route('backend.auth.roles.list') !!}" class="btn btn-info btn-sm waves-effect waves-light" data-toggle="tooltip" title="Lista de Roles">
                                        <span class="btn-label">
                                            <i class="ti-menu-alt"></i>
                                        </span>
                                        Roles
                                    </a>
                                @endcan
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

                        <!-- Formulario de roles -->
                        @if(is_object($oRole))
                            {!! Form::model($oRole, ['route' => ['backend.auth.roles.update', $oRole->id], 'method' => 'PUT', 'class' => 'form p-t-20', 'name' => 'roleForm', 'id' => 'roleForm']) !!}
                            {!! Form::hidden('id', $oRole->id) !!}
                        @else
                            {!! Form::open(['route' => 'backend.auth.roles.store', 'method' => 'POST', 'name' => 'roleForm', 'id' => 'roleForm', 'class' => 'form p-t-20']) !!}
                        @endif

                            <div class="form-group">
                                <label for="name"><strong>Nombre del Rol</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="role-name">
                                            <i class="ti-text"></i>
                                        </span>
                                    </div>
                                    {!! Form::text('name', null, ['id' => 'name', 'placeholder' => 'Ingrese el nombre del rol', 'class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <h4 class="card-title">Seleccione los permisos de este Rol</h4>
                            <div class="form-group">
                                {!! Form::checkbox('selectAll', 1, false, ['id' => 'selectAll', 'class' => 'chk-col-red', 'onclick' => 'toggle(this)']) !!}
                                {!! Form::label('selectAll', 'Seleccionar Todo') !!}
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
                                                            {!! Form::checkbox('permissions[]', $name, $checked, ['id' => 'permission_'.$name, 'class' => 'chk-col-red']) !!}
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

                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-outline-info ladda-button" data-style="zoom-out" name="roleBtn" id="roleBtn">
                                    <i class="fa fa-save"></i>
                                    <span class="ladda-label">Guardar Rol</span>
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
    <script type="text/javascript">
        var urlRolesList = '{!! route('backend.auth.roles.list') !!}';
    </script>
    {!! Html::script('public/backend/assets/js/form-validate/form-validation-roles.min.js', ['type' => 'text/javascript']) !!}
@endsection