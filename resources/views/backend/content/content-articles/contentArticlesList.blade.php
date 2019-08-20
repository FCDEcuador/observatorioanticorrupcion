@extends('backend.layouts.backend-layout')

@section('custom-css')
    
@endsection

@section('title')
	Artículos de Contenido
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Artículos de Contenido</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Contenido</li>
                    <li class="breadcrumb-item"><a href="{!! route('backend.content.content-categories.list') !!}">Categorías de Contenido</a></li>
                    <li class="breadcrumb-item active">Artículos de Contenido</li>
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
                                  Lista de Artículos de Contenido
                                </h4>
                                <h6 class="card-subtitle">
                                  A continuacion la lista de artículos de contenido generados para el portal web
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_add_contentarticles')
                                    <a href="{!! route('backend.content.content-articles.create') !!}" class="btn btn-info btn-sm waves-effect waves-light">
                                        <span class="btn-label">
                                            <i class="ti-plus"></i>
                                        </span>
                                        Agregar Artículo de Contenido
                                    </a>
                                @endcan
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40 p-b-40">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th><i class="fa fa-cogs"></i></th>
                                            <th>Imagen</th>
                                            <th>Titulo</th>
                                            <th>Categoría</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($contentArticlesList->isNotEmpty())
                                            @foreach($contentArticlesList as $oContentArticle)
                                              <tr>
                                                <td> 
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deleteContentArticleBtn_{!! $oContentArticle->id !!}" data-style="zoom-out">
                                                            <span class="ladda-label">
                                                                <i class="fa fa-cog"></i>
                                                            </span>
                                                            <span class="ladda-spinner"></span>
                                                        </button>
                                                        <div class="dropdown-menu animated flipInX">
                                                            @can('backend_edit_contentarticles')
                                                                <a class="btn btn-xs btn-info waves-effect waves-light text-white" href="{!! route('backend.content.content-articles.edit', [$oContentArticle->id]) !!}" style="width:90%;margin-left:8px;margin-top:5px">
                                                                    <span class="btn-label">
                                                                        <i class="fa fa-pencil text-white"></i>
                                                                    </span>
                                                                    Editar Artículo
                                                                </a>
                                                            @endcan
                                                            @can('backend_delete_contentarticles')
                                                                <a class="btn btn-xs btn-danger waves-effect waves-light text-white" onclick="javascript: confirmDelete('deleteContentArticleForm_{!! $oContentArticle->id !!}', 'deleteContentArticleBtn_{!! $oContentArticle->id !!}', 'BlaudCMS :: Artículos de Contenido', 'Esta seguro que desea eliminar el artículo {!! $oContentArticle->title !!}', '{!! route('backend.content.content-articles.list') !!}', true);"  style="width:90%;margin-left:8px;margin-top:5px;">
                                                                    <span class="btn-label">
                                                                        <i class="fa fa-trash text-white"></i>
                                                                    </span>
                                                                    Eliminar Artículo
                                                                </a>
                                                                {!! Form::open(['route' => ['backend.content.content-articles.delete', $oContentArticle->id], 'method' => 'DELETE', 'name' => 'deleteContentArticleForm_'.$oContentArticle->id, 'id' => 'deleteContentArticleForm_'.$oContentArticle->id]) !!}
                                                                {!! Form::close() !!}
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                  @if($oContentArticle->main_multimedia)
                                                    <img src="{!! asset($oStorage->url($oContentArticle->main_multimedia)) !!}" class="" height="40" alt="{!! $oContentArticle->title !!}" />
                                                  @else
                                                    <img src="{!! asset('public/backend/assets/images/default-thumbnail.png') !!}" class="img-circle" height="40" alt="{!! $oContentArticle->title !!}" />
                                                  @endif
                                                </td>
                                                <td> {!! $oContentArticle->title !!} </td>
                                                <td> {!! $oContentArticle->contentCategory->name !!}</td>
                                              </tr>
                                            @endforeach
                                        @else
                                          <tr>
                                              <td colspan="4" class="table-info"> 
                                                  Aún no existen artículos de contenido en el sistema.
                                              </td>
                                          </tr>
                                      @endif
                                    </tbody>
                                    </table>
                                </div>
                                <div align="center">
                                    {!! $contentArticlesList->links() !!}
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