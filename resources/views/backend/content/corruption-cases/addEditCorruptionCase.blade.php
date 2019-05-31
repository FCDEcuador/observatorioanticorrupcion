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

@endsection

@section('title')
	Contenido :: Casos de Corrupción
@endsection

@section('main-content')	
	<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Casos de Corrupción</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! route('backend.dashboard') !!}">Dashboard</a></li>
                    <li class="breadcrumb-item">Contenido</li>
                    <li class="breadcrumb-item">
                        <a href="{!! route('backend.content.corruption-cases.list') !!}">
                            Casos de Corrupción
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        @if(is_object($oCorruptionCase))
                            Editar Caso de Corrupción
                        @else
                            Agregar Caso de Corrupción
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
                                  @if(is_object($oCorruptionCase))
                                    Editar Caso de Corrupción
                                  @else
                                    Agregar Caso de Corrupción
                                  @endif
                                </h4>
                                <h6 class="card-subtitle">
                                  Por favor llene el formulario con los campos indicados
                                </h6>
                            </div>
                            <div class="col-md-4">
                                @can('backend_view_corruptioncases')
                                    <a href="{!! route('backend.content.corruption-cases.list') !!}" class="btn btn-info btn-sm waves-effect waves-light" data-toggle="tooltip" title="Casos de Corrupción">
                                        <span class="btn-label">
                                            <i class="ti-menu-alt"></i>
                                        </span>
                                        Casos de Corrupción
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

                        
                        <!-- Formulario de usuarios -->
                        @if(is_object($oCorruptionCase))
                            {!! Form::model($oCorruptionCase, ['route' => ['backend.content.corruption-cases.update', $oCorruptionCase->id], 'method' => 'PUT', 'class' => 'validation-wizard wizard-circle form p-t-20', 'name' => 'corruptionCaseForm', 'id' => 'corruptionCaseForm', 'files' => true]) !!}
                            {!! Form::hidden('id', $oCorruptionCase->id) !!}
                        @else
                            {!! Form::open(['route' => 'backend.content.corruption-cases.store', 'method' => 'POST', 'name' => 'corruptionCaseForm', 'id' => 'corruptionCaseForm', 'class' => 'validation-wizard wizard-circle form p-t-20', 'files' => true]) !!}
                        @endif

                            <!-- Paso 1 -->
                            <h6>Datos Generales</h6>
                            <section>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="case_stage"> Etapa actual del caso : <span class="danger">*</span> </label>
                                            <select name="case_stage" id="case_stage" class="select2 custom-select form-control required" required onchange="javascript: loadCaseStageDetail('{!! route('backend.content.corruption-cases.case-stage-details') !!}', '{!! is_object($oCorruptionCase) ? $oCorruptionCase->case_stage_detail : '' !!}');">
                                                <option value="">Seleccione una Etapa</option>
                                                @if($aCaseStages->isNotEmpty())
                                                    @foreach($aCaseStages as $oCaseStage)
                                                        @php
                                                            $selected = '';
                                                            if(is_object($oCorruptionCase)){
                                                                if($oCaseStage->description == $oCorruptionCase->case_stage){
                                                                    $selected = 'selected="selected"';
                                                                }
                                                            }
                                                        @endphp
                                                        <option value="{!! $oCaseStage->description !!}" {!! $selected !!}>
                                                            {!! $oCaseStage->description !!}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="case_stage_detail"> Detalle de la Etapa : </label>
                                            <select name="case_stage_detail" id="case_stage_detail" class="select2 custom-select form-control">
                                                <option value="">Seleccione un Detalle de Etapa</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="province"> Provincia : <span class="danger">*</span> </label>
                                            <select name="province" id="province" class="select2 custom-select form-control required" required>
                                                <option value="">Seleccione una Provincia</option>
                                                @if($aProvinces->isNotEmpty())
                                                    @foreach($aProvinces as $oProvince)
                                                        @php
                                                            $selected = '';
                                                            if(is_object($oCorruptionCase)){
                                                                if($oProvince->description == $oCorruptionCase->province){
                                                                    $selected = 'selected="selected"';
                                                                }
                                                            }
                                                        @endphp
                                                        <option value="{!! $oProvince->description !!}" {!! $selected !!}>
                                                            {!! $oProvince->description !!}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state_function"> Función del Estado : <span class="danger">*</span> </label>
                                            <select name="state_function" id="state_function" class="select2 custom-select form-control required" required>
                                                <option value="">Seleccione una Función del Estado</option>
                                                @if($aStateFunctions->isNotEmpty())
                                                    @foreach($aStateFunctions as $oStateFunction)
                                                        @php
                                                            $selected = '';
                                                            if(is_object($oCorruptionCase)){
                                                                if($oStateFunction->description == $oCorruptionCase->state_function){
                                                                    $selected = 'selected="selected"';
                                                                }
                                                            }
                                                        @endphp
                                                        <option value="{!! $oStateFunction->description !!}" {!! $selected !!}>
                                                            {!! $oStateFunction->description !!}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tags"> Tags : </label>
                                            <div class="tags-default">
                                                <div class="tags-default">
                                                    {!! Form::text('tags', is_object($oCorruptionCase) ? implode(',', $oCorruptionCase->tags) : null, ['id' => 'tags', 'placeholder' => 'Por favor ingrese los tags separados por coma (,)', 'class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="involved_number"> Número de Involucrados : <span class="text-danger">*</span> </label>
                                            {!! Form::number('involved_number', null, ['id' => 'involved_number', 'data-bts-button-down-class' => 'btn btn-secondary btn-outline', 'data-bts-button-up-class' => 'btn btn-secondary btn-outline']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="linked_institutions"> Instituciones Vinculadas : <span class="danger">*</span> </label>
                                            <select name="linked_institutions[]" id="linked_institutions" class="select2 m-b-10 select2-multiple form-control" required multiple="multiple" data-placeholder="Seleccione las Instituciones">
                                                @if($aInstitutions->isNotEmpty())
                                                    @foreach($aInstitutions as $oInstitution)
                                                        @php
                                                            $selected = '';
                                                            if(is_object($oCorruptionCase)){
                                                                if(count($oCorruptionCase->linked_institutions)){
                                                                    foreach ($oCorruptionCase->linked_institutions as $institution) {
                                                                        if($oInstitution->description == $institution){
                                                                            $selected = 'selected="selected"';
                                                                        }       
                                                                    }
                                                                }
                                                            }
                                                        @endphp
                                                        <option value="{!! $oInstitution->description !!}" {!! $selected !!}>
                                                            {!! $oInstitution->description !!}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="public_officials_involved"> Funcionarios Involucrados : <span class="danger">*</span> </label>
                                            <select name="public_officials_involved[]" id="public_officials_involved" class="select2 m-b-10 select2-multiple form-control" required multiple="multiple" data-placeholder="Seleccione los Funcionarios">
                                                @if($aOfficials->isNotEmpty())
                                                    @foreach($aOfficials as $oOfficial)
                                                        @php
                                                            $selected = '';
                                                            if(is_object($oCorruptionCase)){
                                                                if(count($oCorruptionCase->public_officials_involved)){
                                                                    foreach ($oCorruptionCase->public_officials_involved as $official) {
                                                                        if($oOfficial->description == $official){
                                                                            $selected = 'selected="selected"';
                                                                        }       
                                                                    }
                                                                }
                                                            }
                                                        @endphp
                                                        <option value="{!! $oOfficial->description !!}" {!! $selected !!}>
                                                            {!! $oOfficial->description !!}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title"> Título : <span class="danger">*</span> </label>
                                            {!! Form::text('title', null, ['id' => 'title', 'class' => 'form-control', 'placeholder' => 'Ingrese el título del caso de corrupción']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="main_multimedia">
                                                <strong>Imagen Principal : </strong><br />
                                                <small>Por favor seleccione la imagen principal del caso de corrupción que se va a crear. Unicamente archivos de imagen (PNG, JPG, JPEG, GIF).</small>
                                            </label>
                                            @php
                                                $dataDefaultFile = '';
                                                if(is_object($oCorruptionCase)){
                                                    if($oCorruptionCase->main_multimedia){
                                                        $dataDefaultFile = asset($oStorage->url($oCorruptionCase->main_multimedia));
                                                    }
                                                }
                                            @endphp
                                            {!! Form::file('main_multimedia', ['id' => 'main_multimedia', 'class' => 'dropify', 'data-max-file-size' => '1M', 'data-show-errors' => 'true', 'data-default-file' => $dataDefaultFile ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="home_image">
                                                <strong>Imagen para Home : </strong><br />
                                                <small>Por favor seleccione la imagen de home del caso de corrupción que se va a crear. Unicamente archivos de imagen (PNG, JPG, JPEG, GIF).</small>
                                            </label>
                                            @php
                                                $dataDefaultFile = '';
                                                if(is_object($oCorruptionCase)){
                                                    if($oCorruptionCase->home_image){
                                                        $dataDefaultFile = asset($oStorage->url($oCorruptionCase->home_image));
                                                    }
                                                }
                                            @endphp
                                            {!! Form::file('home_image', ['id' => 'home_image', 'class' => 'dropify', 'data-max-file-size' => '1M', 'data-show-errors' => 'true', 'data-default-file' => $dataDefaultFile ]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="summary"> Resumen : <span class="danger">*</span> </label>
                                            {!! Form::textarea('summary', null, ['id' => 'summary', 'class' => 'form-control', 'placeholder' => 'Ingrese el resumen del caso de corrupción', 'required']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="history_image">
                                                <strong>Imagen de Antecedentes : </strong><br />
                                                <small>Por favor seleccione la imagen de antecedentes del caso de corrupción que se va a crear. Unicamente archivos de imagen (PNG, JPG, JPEG, GIF).</small>
                                            </label>
                                            @php
                                                $dataDefaultFile = '';
                                                if(is_object($oCorruptionCase)){
                                                    if($oCorruptionCase->history_image){
                                                        $dataDefaultFile = asset($oStorage->url($oCorruptionCase->history_image));
                                                    }
                                                }
                                            @endphp
                                            {!! Form::file('history_image', ['id' => 'history_image', 'class' => 'dropify', 'data-max-file-size' => '1M', 'data-show-errors' => 'true', 'data-default-file' => $dataDefaultFile ]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="history"> Antecedentes: </label>
                                            {!! Form::textarea('history', null, ['id' => 'history', 'class' => 'form-control', 'placeholder' => 'Ingrese los antecedentes del caso de corrupción', 'required']) !!}
                                        </div>
                                    </div>
                                </div>

                                
                                
                            </section>
                            
                            <!-- Paso 2 -->
                            <h6>Historial</h6>
                            <section>
                                <h4 class="card-title">Agregue la información acerca de lo que ocurrió en el caso</h4>
                                @php
                                       $nextWH = 0;
                                       $aWhatHappendLines = null;
                                       if(is_object($oCorruptionCase)){
                                            $aWhatHappendLines = $oCorruptionCase->whatsHappeneds()->orderBy('order', 'asc')->orderBy('year', 'asc')->get();
                                       }
                                @endphp
                                <div id="whatHappenedDiv">
                                    @if($aWhatHappendLines !== null)
                                        @if($aWhatHappendLines->isNotEmpty())
                                            @foreach($aWhatHappendLines as $oWhatHappened)
                                                @php
                                                    $nextWH++;       
                                                @endphp
                                                <div class="row" id="whatHappenedDiv_{!! $nextWH !!}">
                                                    <div class="col-md-2">
                                                        <label for="order"> Orden: </label>
                                                        <input type="number" name="order[]" id="order_{!! $nextWH !!}" class="form-control" value="{!! $oWhatHappened->order !!}" />
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="year"> Año Inicio: </label>
                                                                <input type="number" name="year[]" id="year_{!! $nextWH !!}" class="form-control" value="{!! $oWhatHappened->year !!}" />
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="year"> Mes Inicio: </label>
                                                                <select name="month[]" id="month_{!! $nextWH !!}" class="form-control">
                                                                    <option value="" {!!  ! $oWhatHappened->month ? 'selected="selected"' : '' !!}>Mes</option>
                                                                    <option value="Enero" {!!  $oWhatHappened->month == 'Enero' ? 'selected="selected"' : '' !!}>Enero</option>
                                                                    <option value="Febrero" {!!  $oWhatHappened->month == 'Febrero' ? 'selected="selected"' : '' !!}>Febrero</option>
                                                                    <option value="Marzo" {!!  $oWhatHappened->month == 'Marzo' ? 'selected="selected"' : '' !!}>Marzo</option>
                                                                    <option value="Abril" {!!  $oWhatHappened->month == 'Abril' ? 'selected="selected"' : '' !!}>Abril</option>
                                                                    <option value="Mayo" {!!  $oWhatHappened->month == 'Mayo' ? 'selected="selected"' : '' !!}>Mayo</option>
                                                                    <option value="Junio" {!!  $oWhatHappened->month == 'Junio' ? 'selected="selected"' : '' !!}>Junio</option>
                                                                    <option value="Julio" {!!  $oWhatHappened->month == 'Julio' ? 'selected="selected"' : '' !!}>Julio</option>
                                                                    <option value="Agosto" {!!  $oWhatHappened->month == 'Agosto' ? 'selected="selected"' : '' !!}>Agosto</option>
                                                                    <option value="Septiembre" {!!  $oWhatHappened->month == 'Septiembre' ? 'selected="selected"' : '' !!}>Septiembre</option>
                                                                    <option value="Octubre" {!!  $oWhatHappened->month == 'Octubre' ? 'selected="selected"' : '' !!}>Octubre</option>
                                                                    <option value="Noviembre" {!!  $oWhatHappened->month == 'Noviembre' ? 'selected="selected"' : '' !!}>Noviembre</option>
                                                                    <option value="Diciembre" {!!  $oWhatHappened->month == 'Diciembre' ? 'selected="selected"' : '' !!}>Diciembre</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="day"> Día Inicio: </label>
                                                                <input type="number" name="day[]" id="day_{!! $nextWH !!}" class="form-control" value="{!! $oWhatHappened->day !!}" />
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="year_end"> Año Fin: </label>
                                                                <input type="number" name="year_end[]" id="year_end_{!! $nextWH !!}" class="form-control" value="{!! $oWhatHappened->year !!}" />
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="month_end"> Mes Fin: </label>
                                                                <select name="month_end[]" id="month_end_{!! $nextWH !!}" class="form-control">
                                                                    <option value="" {!!  ! $oWhatHappened->month ? 'selected="selected"' : '' !!}>Mes</option>
                                                                    <option value="Enero" {!!  $oWhatHappened->month_end == 'Enero' ? 'selected="selected"' : '' !!}>Enero</option>
                                                                    <option value="Febrero" {!!  $oWhatHappened->month_end == 'Febrero' ? 'selected="selected"' : '' !!}>Febrero</option>
                                                                    <option value="Marzo" {!!  $oWhatHappened->month_end == 'Marzo' ? 'selected="selected"' : '' !!}>Marzo</option>
                                                                    <option value="Abril" {!!  $oWhatHappened->month_end == 'Abril' ? 'selected="selected"' : '' !!}>Abril</option>
                                                                    <option value="Mayo" {!!  $oWhatHappened->month_end == 'Mayo' ? 'selected="selected"' : '' !!}>Mayo</option>
                                                                    <option value="Junio" {!!  $oWhatHappened->month_end == 'Junio' ? 'selected="selected"' : '' !!}>Junio</option>
                                                                    <option value="Julio" {!!  $oWhatHappened->month_end == 'Julio' ? 'selected="selected"' : '' !!}>Julio</option>
                                                                    <option value="Agosto" {!!  $oWhatHappened->month_end == 'Agosto' ? 'selected="selected"' : '' !!}>Agosto</option>
                                                                    <option value="Septiembre" {!!  $oWhatHappened->month_end == 'Septiembre' ? 'selected="selected"' : '' !!}>Septiembre</option>
                                                                    <option value="Octubre" {!!  $oWhatHappened->month == 'Octubre' ? 'selected="selected"' : '' !!}>Octubre</option>
                                                                    <option value="Noviembre" {!!  $oWhatHappened->month_end == 'Noviembre' ? 'selected="selected"' : '' !!}>Noviembre</option>
                                                                    <option value="Diciembre" {!!  $oWhatHappened->month_end == 'Diciembre' ? 'selected="selected"' : '' !!}>Diciembre</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="day_end"> Día Fin: </label>
                                                                <input type="number" name="day_end[]" id="day_end_{!! $nextWH !!}" class="form-control" value="{!! $oWhatHappened->day !!}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="day"> Descripción: </label>
                                                        <textarea name="description[]" id="description_{!! $nextWH !!}" class="form-control" rows="4">{!! $oWhatHappened->description !!}</textarea>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a class="btn btn-danger" style="cursor: pointer; color:#FFF;" onclick="javascript: deleteWhatHappened('{!! route('backend.content.corruption-cases.deleteWH', [$oWhatHappened->id]) !!}','{!! $oWhatHappened->id !!}', {!! $nextWH !!});" title="Eliminar linea">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endif
                                </div>
                                <hr />
                                    <a class="btn btn-info" style="cursor: pointer; color:#FFF;" onclick="javascript: addWhatHappened();">
                                        <i class="fa fa-plus"></i> Agregar Línea
                                    </a>
                                <hr />
                            </section>
                            
                            <!-- Paso 3 -->
                            <h6>Causas</h6>
                            <section>
                                <h4 class="card-title">Agregue el porqué ocurrió éste caso. Causas Legales y Causas Políticas</h4>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="legal_causes"> Causas Legales: </label>
                                            {!! Form::textarea('legal_causes', null, ['id' => 'legal_causes', 'class' => 'form-control', 'placeholder' => 'Ingrese las causas legales del caso de corrupción']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="political_causes"> Causas Técnicas: </label>
                                            {!! Form::textarea('political_causes', null, ['id' => 'political_causes', 'class' => 'form-control', 'placeholder' => 'Ingrese las causas políticas del caso de corrupción']) !!}
                                        </div>
                                    </div>
                                </div>
                                
                            </section>

                            <!-- Paso 4 -->
                            <h6>Consecuencias</h6>
                            <section>
                                <h4 class="card-title">Agregue las consecuencias de este caso.</h4>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="consequences_title"> Título : <span class="danger">*</span> </label>
                                            {!! Form::text('consequences_title', null, ['id' => 'consequences_title', 'class' => 'form-control', 'placeholder' => 'Ingrese el título de las consecuencias caso de corrupción']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="consequences_introduction"> Subtítulo : <span class="danger">*</span> </label>
                                            {!! Form::text('consequences_introduction', null, ['id' => 'consequences_introduction', 'class' => 'form-control', 'placeholder' => 'Ingrese el subtítulo de las consecuencias caso de corrupción']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="economic_consequences"> Consecuencias Económicas: </label>
                                            {!! Form::textarea('economic_consequences', null, ['id' => 'economic_consequences', 'class' => 'form-control', 'placeholder' => 'Ingrese las consecuencias económicas del caso de corrupción']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="social_consequences"> Consecuencias Sociales: </label>
                                            {!! Form::textarea('social_consequences', null, ['id' => 'social_consequences', 'class' => 'form-control', 'placeholder' => 'Ingrese las consecuencias sociales del caso de corrupción']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="sources"> Fuentes: </label>
                                            {!! Form::textarea('sources', null, ['id' => 'sources', 'class' => 'form-control', 'placeholder' => 'Ingrese las fuentes']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="consequences_image">
                                                <strong>Imagen de Consecuencias : </strong><br />
                                                <small>Por favor seleccione la imagen de consecuencias del caso de corrupción que se va a crear. Unicamente archivos de imagen (PNG, JPG, JPEG, GIF).</small>
                                            </label>
                                            @php
                                                $dataDefaultFile = '';
                                                if(is_object($oCorruptionCase)){
                                                    if($oCorruptionCase->consequences_image){
                                                        $dataDefaultFile = asset($oStorage->url($oCorruptionCase->consequences_image));
                                                    }
                                                }
                                            @endphp
                                            {!! Form::file('consequences_image', ['id' => 'consequences_image', 'class' => 'dropify', 'data-max-file-size' => '1M', 'data-show-errors' => 'true', 'data-default-file' => $dataDefaultFile ]) !!}
                                        </div>
                                    </div>
                                </div>
                                
                            </section>

                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-outline-info ladda-button" data-style="zoom-out" name="corruptionCaseBtn" id="corruptionCaseBtn">
                                    <i class="fa fa-save"></i>
                                    <span class="ladda-label">Guardar Caso de Corrupción</span>
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
    {!! Html::script('public/vendor/unisharp/laravel-ckeditor/ckeditor.js', ['type' => 'text/javascript']) !!}
    
    <script type="text/javascript">
        
        var urlCorruptionCasesList = '{!! route('backend.content.corruption-cases.list') !!}';
        var nextWH = {!! $nextWH !!};
        
        var CKEditorOptions = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={!! csrf_token() !!}',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={!! csrf_token() !!}'
        };
    </script>
    
    {!! Html::script('public/backend/assets/js/form-validate/form-validation-corruption-case.min.js', ['type' => 'text/javascript']) !!}

    <script type="text/javascript">
        loadCaseStageDetail('{!! route('backend.content.corruption-cases.case-stage-details') !!}', '{!! is_object($oCorruptionCase) ? $oCorruptionCase->case_stage_detail : '' !!}');
    </script>
@endsection