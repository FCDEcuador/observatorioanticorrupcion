@extends('backend.layouts.backend-layout')

@section('custom-css')
    
@endsection

@section('title')
	Categorías de Contenido
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Categorías de Contenido</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Contenido</li>
                    @if($hasSuperContentCategory)
                      <li class="breadcrumb-item"><a href="{!! route('backend.content.content-categories.list') !!}">Categorias</a></li>
                      @if($oSuperContentCategory->content_category_id)
                        <li class="breadcrumb-item"><a href="{!! route('backend.content.content-categories.list',[$oSuperContentCategory->content_category_id]) !!}">{!! $oSuperContentCategory->superContentCategory->name !!}</a></li>
                      @endif
                      <li class="breadcrumb-item active">{!! $oSuperContentCategory->name !!}</li>
                    @else
                      <li class="breadcrumb-item active">Categorías de Contenido</li>
                    @endif
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
                                  Lista de Categorías de Contenido
                                </h4>
                                <h6 class="card-subtitle">
                                  A continuacion la lista de categorías de contenido generadas para el portal web
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_add_contentcategories')
                                    <a href="{!! route('backend.content.content-categories.create') !!}" class="btn btn-info btn-sm waves-effect waves-light">
                                        <span class="btn-label">
                                            <i class="ti-plus"></i>
                                        </span>
                                        Agregar Categoría de Contenido
                                    </a>
                                @endcan
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive m-t-40 p-b-40">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th><i class="fa fa-cogs"></i></th>
                                            <th>Nombre</th>
                                            @if($hasSuperContentCategory)
                                              <th>Categoria Padre</th>
                                            @endif
                                            <th>Título</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($contentCategoriesList->isNotEmpty())
                                            @foreach($contentCategoriesList as $oContentCategory)
                                              @php
                                                $aSubContentCategories = $oContentCategory->contentCategories;
                                              @endphp
                                            <tr>
                                                <td> 
                                                  <div class="btn-group">
                                                        <button type="button" class="btn btn-xs btn-success dropdown-toggle waves-effect waves-light ladda-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="deleteContentCategoryBtn_{!! $oContentCategory->id !!}" data-style="zoom-out">
                                                            <span class="ladda-label">
                                                                <i class="fa fa-cog"></i>
                                                            </span>
                                                            <span class="ladda-spinner"></span>
                                                        </button>
                                                        <div class="dropdown-menu animated flipInX">
                                                          @can('backend_delete_contentcategories')
                                                              {!! Form::open(['route' => ['backend.content.content-categories.delete', $oContentCategory->id], 'method' => 'DELETE', 'name' => 'deleteContentCategoryForm_'.$oContentCategory->id, 'id' => 'deleteContentCategoryForm_'.$oContentCategory->id]) !!}
                                                          @endcan
                                                          
                                                          @if($aSubContentCategories->isNotEmpty())
                                                            @can('backend_view_contentcategories')
                                                                <a class="btn btn-xs btn-info waves-effect waves-light text-white" href="{!! route('backend.content.content-categories.list', [$oContentCategory->id]) !!}" style="width:90%;margin-left:8px;">
                                                                    <span class="btn-label">
                                                                        <i class="mdi mdi-view-list"></i>
                                                                    </span> Ver Subcategorías
                                                                </a>
                                                            @endcan
                                                          @endif
                                                          
                                                          @can('backend_add_contentcategories')
                                                              <a class="btn btn-xs btn-info waves-effect waves-light text-white" href="{!! route('backend.content.content-categories.create', [$oContentCategory->id]) !!}" style="width:90%;margin-left:8px;">
                                                                  <span class="btn-label">
                                                                      <i class="fa fa-plus"></i>
                                                                  </span> Crear Subcategoría
                                                              </a>
                                                          @endcan
                                                          
                                                          @can('backend_edit_contentcategories')
                                                              <a class="btn btn-xs btn-info waves-effect waves-light text-white" href="{!! route('backend.content.content-categories.edit', [$oContentCategory->id]) !!}" style="width:90%;margin-left:8px;">
                                                                  <span class="btn-label"><i class="mdi mdi-pencil"></i></span>
                                                                  Editar Categoría
                                                              </a>
                                                          @endcan
                                                          
                                                          @can('backend_delete_contentcategories')
                                                              <button class="btn btn-xs btn-danger waves-effect waves-light text-white" type="button" onclick="javascript: confirmDelete('deleteContentCategoryForm_{!! $oContentCategory->id !!}', 'deleteContentCategoryBtn_{!! $oContentCategory->id !!}', 'BlaudCMS :: Categorías de Contenido', 'Esta seguro que desea eliminar la categoría {!! $oContentCategory->title !!}', '{!! route('backend.content.content-categories.list') !!}', true);" style="cursor:pointer;width:90%;margin:8px;">
                                                                  <span class="btn-label"><i class="mdi mdi-delete"></i></span>
                                                                  Eliminar Categoría
                                                              </button>
                                                          {!! Form::close() !!}
                                                          @endcan
                                                        </div>
                                                  </div>
                                                </td>
                                                <td> {!! $oContentCategory->name !!} </td>
                                                @if($hasSuperContentCategory)
                                                  <td>{!! $oSuperContentCategory->name !!}</td>
                                                @endif
                                                <td> {!! $oContentCategory->title !!} </td>
                                              </tr>
                                            @endforeach
                                        @else
                                          <tr>
                                              @if($hasSuperContentCategory)
                                                <td colspan="4" class="table-info"> 
                                              @else
                                                <td colspan="3" class="table-info"> 
                                              @endif
                                                  Aún no existen categorías o secciones de contenido en el sistema.
                                              </td>
                                          </tr>
                                      @endif
                                    </tbody>
                                    </table>
                                </div>
                                <div align="center">
                                    {!! $contentCategoriesList->links() !!}
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