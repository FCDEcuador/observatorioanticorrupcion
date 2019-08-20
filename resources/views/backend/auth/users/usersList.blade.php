@extends('backend.layouts.backend-layout')

@section('custom-css')
    
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
                    <li class="breadcrumb-item active">Usuarios</li>
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
                                  Lista de Usuarios del Sistema
                                </h4>
                                <h6 class="card-subtitle">
                                  A continuacion la lista de usuarios generados en el sistema
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_add_users')
                                    <a href="{!! route('backend.auth.users.create') !!}" class="btn btn-info btn-sm waves-effect waves-light" data-toggle="tooltip" title="Agregar Usuario">
                                        <span class="btn-label">
                                            <i class="ti-plus"></i>
                                        </span>
                                        Agregar Usuario
                                    </a>
                                @endcan
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40 p-b-40">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr class="bg-info text-white">
                                                <th><i class="fa fa-cogs"></i></th>
                                                <th>Avatar</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Tipo</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($usersList->isNotEmpty())
                                                @foreach($usersList as $oUser)
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group">
                                                                @if($oUser->id == Auth::user()->id)
                                                                    <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deleteRoleBtn_{!! $oUser->id !!}" data-style="zoom-out">
                                                                        <span class="ladda-label">
                                                                            <i class="fa fa-cog"></i>
                                                                        </span>
                                                                        <span class="ladda-spinner"></span>
                                                                    </button>
                                                                    <div class="dropdown-menu animated flipInX">
                                                                        <a class="btn btn-xs btn-primary waves-effect waves-light text-white" style="width:90%;margin-left:8px;" href="{!! route('backend.profile') !!}">
                                                                            <span class="btn-label"><i class="mdi mdi-account"></i></span>
                                                                            Mi Perfil
                                                                        </a>
                                                                    </div>
                                                                @elseif($oUser->email != 'admin@blaudcms.com')
                                                                    <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deleteUserBtn_{!! $oUser->id !!}" data-style="zoom-out">
                                                                        <span class="ladda-label">
                                                                            <i class="fa fa-cog"></i>
                                                                        </span>
                                                                        <span class="ladda-spinner"></span>
                                                                    </button>
                                                                    <div class="dropdown-menu animated flipInX">
                                                                        @can('backend_edit_users')
                                                                            <a class="btn btn-xs btn-info waves-effect waves-light text-white" style="width:90%;margin-left:8px;" href="{!! route('backend.auth.users.edit', [$oUser->id]) !!}">
                                                                                <span class="btn-label"><i class="mdi mdi-pencil"></i></span>
                                                                                Editar Usuario
                                                                            </a>
                                                                            <div class="dropdown-divider"></div>
                                                                        @endcan
                                                                        @can('backend_delete_users')
                                                                            <a class="btn btn-xs btn-danger waves-effect waves-light text-white" onclick="javascript: confirmDelete('deleteUserForm_{!! $oUser->id !!}', 'deleteUserBtn_{!! $oUser->id !!}', 'BlaudCMS :: Usuarios', 'Esta seguro que desea eliminar el usuario {!! $oUser->full_name !!}', '{!! route('backend.auth.users.list') !!}', true);" style="cursor:pointer;width:90%;margin:8px;cursor: pointer;">
                                                                                <span class="btn-label"><i class="mdi mdi-delete"></i></span>
                                                                                Eliminar Usuario
                                                                            </a>
                                                                            {!! Form::open(['route' => ['backend.auth.users.delete', $oUser->id], 'method' => 'DELETE', 'name' => 'deleteUserForm_'.$oUser->id, 'id' => 'deleteUserForm_'.$oUser->id]) !!}
                                                                            {!! Form::close() !!}
                                                                        @endcan
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if($oUser->avatar != '')
                                                                <img src="{!! asset($oStorage->url($oUser->avatar)) !!}" alt="{!! $oUser->full_name !!}" width="40" class="img-circle" />
                                                            @else
                                                                <img src="{!! asset('public/backend/assets/images/default-user.png') !!}" alt="{!! Auth::user()->full_name !!}" width="40" class="img-circle" />
                                                            @endif
                                                        </td>
                                                        <td>{!! $oUser->full_name !!}</td>
                                                        <td>{!! $oUser->email !!}</td>
                                                        <td>
                                                            @if($oUser->type === 'S')
                                                                <span class="label label-success">
                                                                    Super Administrador
                                                                </span>
                                                            @elseif($oUser->type === 'A')
                                                                <span class="label label-warning">
                                                                    Administrador
                                                                </span>
                                                            @elseif($oUser->type === 'B')
                                                                <span class="label label-info">
                                                                    Back Office
                                                                </span>
                                                            @elseif($oUser->type === 'R')
                                                                <span class="label label-primary">
                                                                    Reporteador
                                                                </span>
                                                            @elseif($oUser->type === 'U')
                                                                <span class="label label-inverse">
                                                                    Usuario Estandar
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($oUser->status === 1)
                                                                <span class="label label-success">Activo</span>
                                                            @else
                                                                <span class="label label-danger">Inactivo</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="table-warning">
                                                    <td colspan="4">Aun no se han generado roles para el sistema.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div align="center">
                                    {!! $usersList->links() !!}
                                </div>


                            </div>
                        </div>
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
    {!! Html::script('public/backend/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/jquery.blockui.min.js', ['type' => 'text/javascript']) !!}
    
    <!--Custom JavaScript -->
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        var urlUsersList = '{!! route('backend.auth.users.list') !!}';
    </script>

    {!! Html::script('public/backend/assets/js/pages/users-list.min.js', ['type' => 'text/javascript']) !!}
@endsection