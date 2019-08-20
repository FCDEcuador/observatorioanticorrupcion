@extends('backend.layouts.backend-layout')

@section('custom-css')
    
@endsection

@section('title')
	Meta Tags
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Meta Tags</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Parametrizacion</li>
                    <li class="breadcrumb-item active">Meta Tags</li>
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
                                  Lista de Meta Tags
                                </h4>
                                <h6 class="card-subtitle">
                                  A continuacion la lista de meta tags generados para el portal web
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_add_metatags')
                                    <a href="{!! route('backend.parametrization.meta-tags.create') !!}" class="btn btn-info btn-sm waves-effect waves-light" data-toggle="tooltip" title="Agregar Meta Tag">
                                        <span class="btn-label">
                                            <i class="ti-plus"></i>
                                        </span>
                                        Agregar Meta Tag
                                    </a>
                                @endcan
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40 p-b-40">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr class="bg-info text-white">
                                                <th><i class="fa fa-cogs"></i></th>
                                                <th>Tipo</th>
                                                <th>Nombre</th>
                                                <th>Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($metaTagsList->isNotEmpty())
                                                @foreach($metaTagsList as $oMetaTag)
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deleteMetaTagBtn_{!! $oMetaTag->id !!}" data-style="zoom-out">
                                                                    <span class="ladda-label">
                                                                        <i class="fa fa-cog"></i>
                                                                    </span>
                                                                    <span class="ladda-spinner"></span>
                                                                </button>
                                                                <div class="dropdown-menu animated flipInX">
                                                                    @can('backend_edit_metatags')
                                                                        <a class="dropdown-item" href="{!! route('backend.parametrization.meta-tags.edit', [$oMetaTag->id]) !!}">
                                                                            <small>
                                                                                <i class="mdi mdi-pencil"></i> Editar Meta Tag
                                                                            </small>
                                                                        </a>
                                                                    @endcan
                                                                    @can('backend_delete_metatags')
                                                                        <a class="dropdown-item" onclick="javascript: confirmDelete('deleteMetaTagForm_{!! $oMetaTag->id !!}', 'deleteMetaTagBtn_{!! $oMetaTag->id !!}', 'BlaudCMS :: Meta Tags', 'Esta seguro que desea eliminar el meta tag {!! $oMetaTag->name !!}', '{!! route('backend.parametrization.meta-tags.list') !!}', true);" href="#">
                                                                            <small>
                                                                                <i class="mdi mdi-delete"></i> Eliminar Meta Tag
                                                                            </small>
                                                                        </a>
                                                                        {!! Form::open(['route' => ['backend.parametrization.meta-tags.delete', $oMetaTag->id], 'method' => 'DELETE', 'name' => 'deleteMetaTagForm_'.$oMetaTag->id, 'id' => 'deleteMetaTagForm_'.$oMetaTag->id]) !!}
                                                                        {!! Form::close() !!}
                                                                    @endcan
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{!! $oMetaTag->type !!}</td>
                                                        <td>{!! $oMetaTag->name !!}</td>
                                                        <td>{!! $oMetaTag->value !!}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="table-warning">
                                                    <td colspan="4">Aun no se han generado meta tags para el portal web.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div align="center">
                                    {!! $metaTagsList->links() !!}
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