@extends('backend.layouts.backend-layout')

@section('custom-css')
    
@endsection

@section('title')
	Menús
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Menús</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Contenido</li>
                    <li class="breadcrumb-item active">Lista de Menús</li>
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
                                  Lista de Menús
                                </h4>
                                <h6 class="card-subtitle">
                                  A continuación la lista de menús generados en el sistema
                                </h6>
                            </div>
                            <div class="col-md-4">
                                <a href="{!! route('backend.dashboard') !!}" class="btn btn-info btn-sm waves-effect waves-light" data-toggle="tooltip" title="Dashboard">
                                    <span class="btn-label">
                                        <i class="ti-dashboard"></i>
                                    </span>
                                    Dashboard
                                </a>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40 p-b-40">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th><i class="fa fa-cogs"></i></th>
                                            <th>Nombre</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($menusList->isNotEmpty())
                                          @foreach($menusList as $oMenu)
                                            @php
                                              $numMenuItems = $oMenu->menuItems()->count();
                                            @endphp
                                            @if($oMenu->active == 0)
                                              <tr class="table-danger">
                                            @else
                                              <tr>
                                            @endif
                                                
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deleteMenuBtn_{!! $oMenu->id !!}" data-style="zoom-out">
                                                            <span class="ladda-label">
                                                                <i class="fa fa-cog"></i>
                                                            </span>
                                                            <span class="ladda-spinner"></span>
                                                        </button>
                                                        <div class="dropdown-menu animated flipInX">
                                                            @can('backend_view_menuitems')
                                                                @if($numMenuItems)
                                                                    <a href="{!! route('backend.content.menu-items.list', [$oMenu->id]) !!}" class="btn btn-xs btn-info waves-effect waves-light text-white" style="width:90%;margin-left:8px;">
                                                                        <span class="btn-label">
                                                                            <i class="fa fa-bars"></i>
                                                                        </span>
                                                                        Ver items
                                                                    </a>
                                                                    <div class="dropdown-divider"></div>
                                                                @endif
                                                            @endcan
                                                            @can('backend_add_menuitems')
                                                                <a href="{!! route('backend.content.menu-items.create', [$oMenu->id]) !!}" class="btn btn-xs btn-info waves-effect waves-light text-white" style="width:90%;margin-left:8px;">
                                                                    <span class="btn-label">
                                                                        <i class="fa fa-plus"></i>
                                                                    </span>
                                                                    Agregar item
                                                                </a>
                                                            @endcan  
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                  {!! $oMenu->name !!}
                                                </td>
                                                <td>
                                                  @if($oMenu->active == 1)
                                                    <span class="label label-success">Activo</span>
                                                  @else
                                                    <span class="label label-danger">Inactivo</span>
                                                  @endif
                                                </td>
                                              </tr>
                                          @endforeach
                                        @else
                                          <tr>
                                            <td class="info" colspan="3">
                                                Aún no existen menús en el sistema
                                            </td>
                                          </tr>
                                        @endif
                                    </tbody>
                                    </table>
                                </div>
                                <div align="center">
                                    {!! $menusList->links() !!}
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
@endsection