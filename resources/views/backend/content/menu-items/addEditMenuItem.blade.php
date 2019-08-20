@extends('backend.layouts.backend-layout')

@section('custom-css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! Html::style('public/backend/assets/css/pages/ui-bootstrap-page.css') !!}
    <!-- END PAGE LEVEL PLUGINS -->
    {!! Html::style('public/backend/assets/plugins/wizard/steps.css') !!}
    {!! Html::style('public/backend/assets/plugins/dropify/dist/css/dropify.min.css') !!}

    <!-- page CSS -->
    {!! Html::style('public/backend/assets/plugins/select2/dist/css/select2.min.css') !!}
    {!! Html::style('public/backend/assets/plugins/bootstrap-select/bootstrap-select.min.css') !!}
    {!! Html::style('public/backend/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') !!}
    {!! Html::style('public/backend/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css') !!}
    {!! Html::style('public/backend/assets/plugins/html5-editor/bootstrap-wysihtml5.css') !!}

@endsection

@section('title')
	Contenido :: Items de Menú
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
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Home</a></li>
                    <li class="breadcrumb-item">Contenido</li>
                    <li class="breadcrumb-item"><a href="{!! route('backend.content.menu-items.list') !!}">Menús</li>
                    <li class="breadcrumb-item"><a href="{!! route('backend.content.menu-items.list', [$sMenuId]) !!}">Items de Menú</li>
                    <li class="breadcrumb-item active">
                      @if($oMenuItem)
                        Editar Item de Menú
                      @else
                        Crear Nuevo Item de Menú
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
                                      @if($oMenuItem)
                                        Editar Item de Menú
                                      @else
                                        Agregar Item de Menú
                                      @endif
                                    </h4>
                                    <h6 class="card-subtitle">
                                      Por favor llene los campos requeridos.
                                    </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_view_menuitems')
                                    <a href="{!! route('backend.content.menu-items.list') !!}" class="btn btn-info btn-sm waves-effect waves-light">
                                        <span class="btn-label">
                                            <i class="ti-menu-alt"></i>
                                        </span>
                                        Menús
                                    </a>
                                    <a class="btn btn-info btn-sm waves-effect waves-light" href="{!! route('backend.content.menu-items.list', [$sMenuId]) !!}">
                                        <span class="btn-label">
                                            <i class="fa fa-bars"></i> 
                                        </span>
                                        Items de Menú
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

                        
                        <!-- Formulario de meta tags -->
                        @if($oMenuItem)
                          {!! Form::model($oMenuItem, ['route' => ['backend.content.menu-items.update', $oMenuItem->id], 'method' => 'PUT', 'class' => 'form p-t-20', 'name' => 'menuItemForm', 'id' => 'menuItemForm']) !!}
                        @else
                          {!! Form::open(['route' => ['backend.content.menu-items.store'], 'method' => 'POST', 'class' => 'form p-t-20', 'name' => 'menuItemForm', 'id' => 'menuItemForm']) !!}
                        @endif

                            <div class="form-group">
                                <h5>Estado del Item de Menú <span class="text-danger">*</span></h5>
                                @if($oMenuItem)
                                    @php
                                        $check1 = $oMenuItem->active == 1 ? 'checked="checked"' : '';
                                        $check0 = $oMenuItem->active == 0 ? 'checked="checked"' : '';
                                    @endphp
                                    <fieldset class="controls">
                                        <label class="custom-control custom-radio">
                                            <input id="active1" name="active" type="radio" class="custom-control-input" required {!! $check1 !!} value="1">
                                            <span class="custom-control-label">Activo</span>
                                        </label>
                                    </fieldset>
                                    <fieldset>
                                      <label class="custom-control custom-radio">
                                        <input type="radio" value="0" name="active" id="active0" class="custom-control-input" {!! $check0 !!}> 
                                        <span class="custom-control-label">Inactivo</span>
                                      </label>
                                    </fieldset>
                                @else
                                    <fieldset class="controls">
                                        <label class="custom-control custom-radio">
                                            <input id="active1" name="active" type="radio" class="custom-control-input" required checked="checked" value="1">
                                            <span class="custom-control-label">Activo</span>
                                        </label>
                                    </fieldset>
                                    <fieldset>
                                      <label class="custom-control custom-radio">
                                        <input type="radio" value="0" name="active" id="active0" class="custom-control-input"> 
                                        <span class="custom-control-label">Inactivo</span>
                                      </label>
                                    </fieldset>  
                                @endif
                            </div>

                            <div class="form-group">
                              <h5>Menú <span class="text-danger">*</span></h5>
                              <div class="controls">
                                  {!! Form::select('menu_id', $menuList, $sMenuId, ['class' => 'form-control', 'placeholder' => 'Seleccione el menú', 'id' => 'menu_id',  'onchange' => 'loadMenuItems('.route('backend.content.menu-items.list.json').', '.$sMenuItemId.')', 'required', 'data-validation-required-message' => 'Por favor seleccione el menú']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                              <h5>Item de Menú de nivel superior:</h5>
                              <div class="controls">
                                  <select class="form-control" name="menu_item_id" id="menu_item_id">
                                    <option value=''>Seleccione el item de menu de nivel superior</option>
                                  </select>
                              </div>
                            </div>

                            <div class="form-group">
                              <h5>Nombre <span class="text-danger">*</span></h5>
                              <div class="controls">
                                  {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => '* Ingrese el nombre del item de menú', 'id' => 'name', 'required', 'data-validation-required-message' => 'Por favor ingrese el nombre del item de menú', 'maxlength' => '191']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                              <h5>Nombre que se verá en el menú de navegación: <span class="text-danger">*</span></h5>
                              <div class="controls">
                                  {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => '* Ingrese el nombre del item de menú con el cual se verá en el menú de navegación', 'id' => 'title', 'required', 'data-validation-required-message' => 'Por favor ingrese el nombre del item de menú con el cual se verá en el menú de navegación', 'maxlength' => '191']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                              <h5>Tipo de Item de Menú <span class="text-danger">*</span></h5>
                              <div class="controls">
                                  {!! Form::select('type', ['I' => 'Interno', 'E' => 'Externo'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione el tipo de item de menú', 'id' => 'type',  'onchange' => 'internalLinks()', 'required', 'data-validation-required-message' => 'Por favor seleccione el tipo de item de menú']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                              <h5>Seleccione el link Interno: </h5>
                              <div class="controls">
                                <select class="form-control" name="internal_links" id="internal_links" onchange="loadLink()">
                                  <option value=''>Seleccione el link interno para este item de menu</option>
                                  <optgroup label="Links Internos">
                                    <option value="/">Inicio</option>
                                    <option value="sobre-el-observatorio">Sobre el Observatorio</option>
                                    <option value="casos-de-corrupcion">Casos de Corrupción</option>
                                    <option value="historias-de-exito">Historias de Éxito</option>
                                    <option value="biblioteca-legal">Biblioteca Legal</option>
                                    <option value="estadisticas">Estadisticas</option>
                                    <option value="contactenos">Contacto</option>
                                  </optgroup>
                                  
                                  <optgroup label="Categorías de Contenido">
                                    {!! BlaudCMS\ContentCategory::dropDownItemsMenu() !!}
                                  </optgroup>

                                  @if($contentArticlesList->isNotEmpty())
                                      <optgroup label="Páginas de Contenido">
                                        @foreach($contentArticlesList as $page)
                                          <option value="{!! $page->contentCategory->slug !!}/{!! $page->slug !!}">{!! $page->contentCategory->name !!} / {!! $page->title !!}</option>
                                        @endforeach
                                      </optgroup>
                                  @endif

                                  @if($successStoriesList->isNotEmpty())
                                      <optgroup label="Historias de Exito">
                                        @foreach($successStoriesList as $successStory)
                                          <option value="{!! $successStory->url !!}">{!! $successStory->name !!}</option>
                                        @endforeach
                                      </optgroup>
                                  @endif

                                  @if($corruptionCasesList->isNotEmpty())
                                      <optgroup label="Casos de Corrupción">
                                        @foreach($corruptionCasesList as $oCorruptionCase)
                                          <option value="casos-de-corrupcion/{!! $oCorruptionCase->slug !!}">{!! $oCorruptionCase->name !!}</option>
                                        @endforeach
                                      </optgroup>
                                  @endif

                                  @if($legalLibraryList->isNotEmpty())
                                      <optgroup label="Biblioteca Legal">
                                        @foreach($legalLibraryList as $oLegalLibrary)
                                          <option value="biblioteca-legal/{!! $oLegalLibrary->slug !!}">{!! $oLegalLibrary->title !!}</option>
                                        @endforeach
                                      </optgroup>
                                  @endif

                                </select>
                              </div>
                            </div>

                            <div class="form-group">
                              <h5>Link del item de menú: <span class="text-danger">*</span></h5>
                              <div class="controls">
                                  {!! Form::text('link', null, ['class' => 'form-control', 'placeholder' => '* Ingrese el link a donde se dirigirá éste item de menú', 'id' => 'link', 'required', 'data-validation-required-message' => 'Por favor ingrese el link a donde se dirigirá éste item de menú']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                              <h5>Como se abrirá el link de este item de menú? <span class="text-danger">*</span></h5>
                              <div class="controls">
                                  {!! Form::select('target', ['_self' => 'En la misma página', '_blank' => 'En una nueva página'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione como se abrirá el link de este item de menú', 'id' => 'target', 'required', 'data-validation-required-message' => 'Por favor seleccione como se abrirá el link de éste item de menú']) !!}
                              </div>
                            </div>

                            <div class="form-group">
                              <h5>Ubicación del item de menú <span class="text-danger">*</span></h5>
                              <div class="controls">
                                  {!! Form::number('order', null, ['class' => 'form-control', 'placeholder' => '* Ingrese la ubicación o el orden en el que aparecerá este item de menú', 'id' => 'order', 'required', 'data-validation-required-message' => 'Por favor ingrese el órden en el que aparecerá éste item de menú']) !!}
                              </div>
                            </div>

                              
                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-outline-info ladda-button" data-style="zoom-out" name="menuItemBtn" id="menuItemBtn">
                                    <i class="fa fa-save"></i>
                                    <span class="ladda-label">Guardar Item de Menú</span>
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
    {!! Html::script('public/backend/assets/plugins/switchery/dist/switchery.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/select2/dist/js/select2.full.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/bootstrap-select/bootstrap-select.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js', ['type' => 'text/javascript']) !!}
    <!-- wysuhtml5 Plugin JavaScript -->
    {!! Html::script('public/backend/assets/plugins/html5-editor/wysihtml5-0.3.0.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/html5-editor/bootstrap-wysihtml5.js', ['type' => 'text/javascript']) !!}
    <script type="text/javascript">
        var sMenuId = '{!! $sMenuId !!}';
        var sMenuItemId = '{!! $sMenuItemId !!}';
        var urlMenuItemsList = '{!! route('backend.content.menu-items.list', [$sMenuId, $sMenuItemId]) !!}';
        var urlMenuItemsListJson = '{!! route('backend.content.menu-items.list.json') !!}';
    </script>
    {!! Html::script('public/backend/assets/js/form-validate/form-validation-menu-item.min.js', ['type' => 'text/javascript']) !!}
@endsection