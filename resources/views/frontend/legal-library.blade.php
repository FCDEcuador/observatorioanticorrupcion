@extends('frontend.layouts.frontend-layout')

@section('title')
	
@endsection

@section('custom-css')	
@endsection



@section('main-content')
	
	<!-- BEGIN SECCION BUSCAR -->
		<div class="row mt-3 p-3 bg-light">
			<div class="col-sm-6">
				<div class="titulo border-bottom border-info text-info text-uppercase">Biblioteca legal</div>
			</div>
			<div class="col-12 mt-3">
				<p class="text-justify">A continuación te presentamos las principales leyes, reglamentos y decretos que abordan temas y mecanismos de prevención y sanción a los actos de corrupción en Ecuador. Utiliza el buscador para acceder a los documentos de tu interés.</p>
			</div>
		</div>

		<div class="row p-3 bg-light">
			<div class="col-12 ">
				{!! Form::open(['route' => ['legal-library'], 'method' => 'GET', 'name' => 'legalLibraryForm', 'id' => 'legalLibraryForm']) !!}
				  <div class="form-group row justify-content-center">
				    <label for="sTags" class="col-sm-3 col-form-label text-uppercase text-left text-sm-right text-secondary">Término de búsqueda</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="sTags" name="sTags" required>
				    </div>
				  </div>
				  <div class="form-group row justify-content-center">
				    <label for="iIssueYear" class="col-sm-3 col-form-label text-uppercase text-left text-sm-right text-secondary">Año de emisión</label>
				    <div class="col-sm-4">
				      <input type="number" class="form-control" id="iIssueYear" name="iIssueYear">
				    </div>
				  </div>
				  <div class="align-self-center d-flex justify-content-center">
				  	<button type="submit" class="btn btn-info btn-sm">Buscar</button>
				  </div>
				{!! Form::close() !!}
			</div>
		</div>
	<!-- END SECCION BUSCAR -->


	<!-- BEGIN SECCION RESULTADO DE BUSQUEDA -->
	<div class="row mt-5 ">
		<div class="col-4 d-none d-sm-block">
			<h6 class="border-bottom border-default text-default font-weight-bold">CASO</h6>
		</div>
		<div class="col-8 d-none d-sm-block">
			<h6 class="border-bottom border-default text-default font-weight-bold">DESCRIPCIÓN</h6>
		</div>
	</div>
	<div class="row mt-3">
		@if($legalLibraryList->isNotEmpty())
			@foreach($legalLibraryList as $oLegalLibrary)
				<div class="col-12 mb-3 border-bottom border-info pb-3">
					<div class="row">
						<div class="col-sm-4 ">
							<h6 class="text-info">{!! $oLegalLibrary->title !!}</h6>
						</div>
						<div class="col-sm-8">
							<div class="text-justify">
								{!! $oLegalLibrary->description !!}
							</div>
							<a href="{!! $oStorage->url($oLegalLibrary->pdf_document) !!}" role="button" class="btn btn-info btn-sm float-right" target="_blank" rel="noopener noreferrer">Descargar</a>
						</div>
					</div>
				</div>
			@endforeach
		@endif
		

		<div class="col-12">
			{!! $legalLibraryList->links() !!}
		</div>
	</div>

	<!-- END SECCION RESULTADO DE BUSQUEDA -->
	
@endsection



@section('custom-js')
@endsection