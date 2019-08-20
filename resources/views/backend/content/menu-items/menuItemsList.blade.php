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
                <h3 class="text-themecolor">Items de Menú</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Contenido</li>
                    <li class="breadcrumb-item"><a href="{!! route('backend.content.menu-items.list') !!}">Menús</li>
                    <li class="breadcrumb-item active">Lista de Items de Menú</li>
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
                                  Items de Menú
                                </h4>
                                <h6 class="card-subtitle">
                                  A continuación la lista de items de menú generados para {!! $oMenu->name !!}
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_view_menuitems')
                                    <a class="btn btn-info btn-sm waves-effect waves-light" href="{!! route('backend.content.menu-items.list') !!}">
                                        <span class="btn-label">
                                            <i class="fa fa-bars"></i>
                                        </span>
                                        Menús
                                    </a>
                                @endcan
                                @can('backend_add_menuitems')
                                    <a class="btn btn-info btn-sm waves-effect waves-light" href="{!! route('backend.content.menu-items.create', [$oMenu->id]) !!}">
                                        <span class="btn-label">
                                            <i class="fa fa-plus"></i>
                                        </span>
                                        Nuevo Item de Menú
                                    </a>
                                @endcan
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40 p-b-40">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th><i class="fa fa-cogs"></i></th>
                                            <th>Orden</th>
                                            <th>Nombre</th>
                                            <th>Menú</th>
                                            <th>Item Superior</th>
                                            <th>Tipo</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($menuItemsList->isNotEmpty())
                                        @foreach($menuItemsList as $oMenuItem)
                                          @php
                                            $numMenuItems = $oMenuItem->menuItems()->count();
                                          @endphp
                                          @if($oMenuItem->active == 0)
                                            <tr class="danger">
                                          @else
                                            <tr>
                                          @endif
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deleteMenuItemBtn_{!! $oMenuItem->id !!}" data-style="zoom-out">
                                                            <span class="ladda-label">
                                                                <i class="fa fa-cog"></i>
                                                            </span>
                                                            <span class="ladda-spinner"></span>
                                                        </button>
                                                        <div class="dropdown-menu animated flipInX">
                                                            @if( ! $numMenuItems)
                                                                @can('backend_delete_menuitems')
                                                                  {!! Form::open(['route' => ['backend.content.menu-items.delete', $oMenuItem->id], 'method' => 'DELETE', 'style' => 'margin:0;', 'class' => 'form-horizontal']) !!}
                                                                @endcan
                                                              @endif
                                                              
                                                              @can('backend_edit_menuitems')
                                                                <a href="{!! route('backend.content.menu-items.edit', [$oMenuItem->id]) !!}" class="btn btn-xs btn-info waves-effect waves-light text-white" style="width:90%;margin-left:8px;margin-top: 5px;">
                                                                  <span class="btn-label">
                                                                      <i class="fa fa-pencil"></i>
                                                                  </span>
                                                                  Editar Menú
                                                                </a>
                                                              @endcan
                                                              
                                                              @if( ! $oMenuItem->menu_item_id)
                                                                @if($numMenuItems)
                                                                  @can('backend_view_menuitems')
                                                                    <a href="{!! route('backend.content.menu-items.list', [$oMenu->id, $oMenuItem->id]) !!}" class="btn btn-xs btn-info waves-effect waves-light text-white" style="width:90%;margin-left:8px;margin-top: 5px;">
                                                                      <span class="btn-label">
                                                                          <i class="fa fa-bars"></i>
                                                                      </span>
                                                                      Ver Sub menús
                                                                    </a>
                                                                  @endcan
                                                                @endif
                                                                @can('backend_add_menuitems')
                                                                  <a href="{!! route('backend.content.menu-items.create', [$oMenu->id, $oMenuItem->id]) !!}" class="btn btn-xs btn-primary waves-effect waves-light text-white" style="width:90%;margin-left:8px;margin-top: 5px;">
                                                                    <span class="btn-label">
                                                                        <i class="fa fa-plus"></i>
                                                                    </span>
                                                                    Agregar Sub Menú
                                                                  </a>
                                                                @endcan
                                                              @endif
                                                              
                                                              @if( ! $numMenuItems)
                                                                @can('backend_delete_menuitems')
                                                                  <button class="btn btn-xs btn-danger waves-effect waves-light text-white" type="submit" style="width:90%;margin-left:8px;margin-top: 5px;">
                                                                    <span class="btn-label">
                                                                        <i class="fa fa-trash"></i>
                                                                    </span>
                                                                    Eliminar Menú
                                                                  </button>
                                                                  {!! Form::close() !!}
                                                                @endcan
                                                              @else
                                                                <button class="btn btn-xs btn-secondary waves-effect waves-light text-white" data-toggle="tooltip" data-original-title="Eliminar Item de Menu" type="button" style="width:90%;margin-left:8px;margin-top: 5px;">
                                                                    <span class="btn-label">
                                                                        <i class="fa fa-trash"></i>
                                                                    </span>
                                                                    Eliminar Menú
                                                                </button>
                                                              @endif  
                                                        </div>
                                                    </div>
                                                  </td>
                                              <td>{!! $oMenuItem->order !!}</td>
                                              <td>{!! $oMenuItem->name !!}</td>
                                              <td>{!! $oMenuItem->menu->name !!}</td>
                                              <td>
                                                @if($oMenuItem->menu_item_id)
                                                  {!! $oMenuItem->superMenuItem->name !!}
                                                @else
                                                  &nbsp;
                                                @endif
                                              </td>
                                              <td>
                                                @if($oMenuItem->type == 'I')
                                                  <span class="label label-info">Interno</span>
                                                @else
                                                  <span class="label label-warning">Externo</span>
                                                @endif
                                              </td>
                                              <td>
                                                @if($oMenuItem->active == 1)
                                                  <span class="label label-success">Activo</span>
                                                @else
                                                  <span class="label label-danger">Inactivo</span>
                                                @endif
                                              </td>
                                            </tr>
                                        @endforeach
                                      @else
                                        <tr>
                                          <td class="info" colspan="5">
                                              Aún no menús en el sistema
                                          </td>
                                        </tr>
                                      @endif
                                    </tbody>
                                    </table>
                                </div>
                                <div align="center">
                                    {!! $menuItemsList->links() !!}
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