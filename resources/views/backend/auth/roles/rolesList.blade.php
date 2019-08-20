@extends('backend.layouts.backend-layout')

@section('custom-css')
    
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
                    <li class="breadcrumb-item">Auth</li>
                    <li class="breadcrumb-item active">Roles</li>
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
                                  Lista de Roles del Sistema
                                </h4>
                                <h6 class="card-subtitle">
                                  A continuacion la lista de roles generados en el sistema
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_add_roles')
                                    <a href="{!! route('backend.auth.roles.create') !!}" class="btn btn-info btn-sm waves-effect waves-light" data-toggle="tooltip" title="Agregar Rol">
                                        <span class="btn-label">
                                            <i class="ti-plus"></i>
                                        </span>
                                        Agregar Rol
                                    </a>
                                @endcan
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40 p-b-40">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr class="bg-info text-white">
                                                <th><i class="fa fa-cogs"></i></th>
                                                <th>Nombre</th>
                                                <th>Guard</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($rolesList->isNotEmpty())
                                                @foreach($rolesList as $oRole)
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group">
                                                                @if($oRole->name != 'Super Administrator')
                                                                    <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deleteRoleBtn_{!! $oRole->id !!}" data-style="zoom-out">
                                                                        <span class="ladda-label">
                                                                            <i class="fa fa-cog"></i>
                                                                        </span>
                                                                        <span class="ladda-spinner"></span>
                                                                    </button>
                                                                    <div class="dropdown-menu animated flipInX">
                                                                        @can('backend_delete_roles')
                                                                            {!! Form::open(['route' => ['backend.auth.roles.delete', $oRole->id], 'method' => 'DELETE', 'name' => 'deleteRoleForm_'.$oRole->id, 'id' => 'deleteRoleForm_'.$oRole->id]) !!}
                                                                        @endcan
                                                                        @can('backend_edit_roles')
                                                                            <a class="btn btn-xs btn-info waves-effect waves-light text-white" style="width:90%;margin-left:8px;" href="{!! route('backend.auth.roles.edit', [$oRole->id]) !!}">
                                                                                <span class="btn-label"><i class="mdi mdi-pencil"></i></span>
                                                                                Editar Rol
                                                                            </a>
                                                                            <div class="dropdown-divider"></div>
                                                                        @endcan
                                                                        @can('backend_delete_roles')
                                                                            <button class="btn btn-xs btn-danger waves-effect waves-light text-white" type="button" onclick="javascript: confirmDelete('deleteRoleForm_{!! $oRole->id !!}', 'deleteRoleBtn_{!! $oRole->id !!}', 'BlaudCMS :: Roles', 'Esta seguro que desea eliminar el rol {!! $oRole->name !!}', '{!! route('backend.auth.roles.list') !!}', true);" style="cursor:pointer;width:90%;margin:8px;">
                                                                                <span class="btn-label"><i class="mdi mdi-delete"></i></span>
                                                                                Eliminar Rol
                                                                            </button>
                                                                            {!! Form::close() !!}
                                                                        @endcan
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>{!! $oRole->name !!}</td>
                                                        <td>{!! $oRole->guard_name !!}</td>
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
                                    {!! $rolesList->links() !!}
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
        var urlRolesList = '{!! route('backend.auth.roles.list') !!}';
    </script>

    {!! Html::script('public/backend/assets/js/pages/roles-list.min.js', ['type' => 'text/javascript']) !!}
@endsection