@extends('backend.layouts.backend-layout')

@section('custom-css')
    
@endsection

@section('title')
	Historias de Éxito
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Historias de Éxito</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Contenido</li>
                    <li class="breadcrumb-item active">Historias de Éxito</li>
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
                                  Lista de Historias de Éxito
                                </h4>
                                <h6 class="card-subtitle">
                                  A continuacion la lista de historias de éxito generados para el portal web
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_add_successstories')
                                    <a href="{!! route('backend.content.success-stories.create') !!}" class="btn btn-info btn-sm waves-effect waves-light">
                                        <span class="btn-label">
                                            <i class="ti-plus"></i>
                                        </span>
                                        Agregar Historia de Éxito
                                    </a>
                                @endcan
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40 p-b-40">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr class="bg-info text-white">
                                                <th><i class="fa fa-cogs"></i></th>
                                                <th>Imagen</th>
                                                <th>Nombre</th>
                                                <th>Título</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($successStoriesList->isNotEmpty())
                                                @foreach($successStoriesList as $oSuccessStory)
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deleteSuccessStoryBtn_{!! $oSuccessStory->id !!}" data-style="zoom-out">
                                                                    <span class="ladda-label">
                                                                        <i class="fa fa-cog"></i>
                                                                    </span>
                                                                    <span class="ladda-spinner"></span>
                                                                </button>
                                                                <div class="dropdown-menu animated flipInX">
                                                                    @can('backend_edit_successstories')
                                                                        <a class="dropdown-item" href="{!! route('backend.content.success-stories.edit', [$oSuccessStory->id]) !!}">
                                                                            <small>
                                                                                <i class="mdi mdi-pencil"></i> Editar Historia de Éxito
                                                                            </small>
                                                                        </a>
                                                                    @endcan
                                                                    @can('backend_delete_successstories')
                                                                        <a class="dropdown-item" onclick="javascript: confirmDelete('deleteSuccessStoryForm_{!! $oSuccessStory->id !!}', 'deleteSuccessStoryBtn_{!! $oSuccessStory->id !!}', 'BlaudCMS :: Historias de Exito', 'Esta seguro que desea eliminar la historia de éxito {!! $oSuccessStory->name !!}', '{!! route('backend.content.success-stories.list') !!}', true);" href="#">
                                                                            <small>
                                                                                <i class="mdi mdi-delete"></i> Eliminar Historia de Éxito
                                                                            </small>
                                                                        </a>
                                                                        {!! Form::open(['route' => ['backend.content.success-stories.delete', $oSuccessStory->id], 'method' => 'DELETE', 'name' => 'deleteSuccessStoryForm_'.$oSuccessStory->id, 'id' => 'deleteSuccessStoryForm_'.$oSuccessStory->id]) !!}
                                                                        {!! Form::close() !!}
                                                                    @endcan
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if($oSuccessStory->image)
                                                                <img src="{!! asset($oStorage->url($oSuccessStory->image)) !!}" class="" height="40" alt="{!! $oSuccessStory->name !!}" />
                                                            @else
                                                                <img src="{!! asset('backend/assets/images/default-thumbnail.png') !!}" class="img-circle" height="40" alt="{!! $oSuccessStory->name !!}" />
                                                            @endif
                                                        </td>
                                                        <td>{!! $oSuccessStory->name !!}</td>
                                                        <td>{!! $oSuccessStory->title !!}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="table-warning">
                                                    <td colspan="4">Aun no se han generado historias de éxito para el portal web.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div align="center">
                                    {!! $successStoriesList->links() !!}
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
    {!! Html::script('backend/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('backend/assets/plugins/jquery.blockui.min.js', ['type' => 'text/javascript']) !!}
@endsection