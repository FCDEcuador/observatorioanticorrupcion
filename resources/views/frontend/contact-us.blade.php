@extends('frontend.layouts.frontend-layout')

@section('title')
	Contactenos
@endsection

@section('custom-css')
	{!! Html::style('public/backend/assets/plugins/ladda/ladda-themeless.min.css') !!}
    {!! Html::style('public/backend/assets/plugins/bootstrap-sweetalert/sweetalert.css') !!}
@endsection

@section('main-content')
	
	
	<!-- BEGIN SECCION BUSCAR -->
		<div class="row mt-3 p-3 bg-light">
			<div class="col-6">
				<div class="titulo border-bottom border-info text-info text-uppercase">Contacto</div>
			</div>
			<div class="col-12 mt-3">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7971252446946!2d-78.48202418524664!3d-0.1867578998637365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMTEnMTIuMyJTIDc4wrAyOCc0Ny40Ilc!5e0!3m2!1sen!2sec!4v1550254701839" class="w-100" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
			</div>
		</div>


		<div class="row p-3 justify-content-center">
			<div class="col-sm-6">
				<p>¿Quieres obtener información adicional de Ciudadanía y Desarrollo, compartir una idea con nosotros o hacer un comentario? Envíanos un correo electrónico o info@ciudadaniaydesarrollo.org o llena el formulario a continuación.</p>
				
				<p>Dirección: Av. Gral. Eloy Alfaro y 6 de Diciembre, Edificio Monasterio Plaza Piso 10 - Quito</p>
				
				<p>E-mail:  <a href="mailto:info@ciudadaniaydesarrollo.org">info@ciudadaniaydesarrollo.org</a></p>
 				<p>Teléfono:(+593 – 2) 333-2526</p>
				<p>Quito-Ecuador</p>
			</div>
		</div>

		<div class="row p-3">
			<div class="col-12 text-center" id="contactFormThankYouDiv">
				<h1>Muchas gracias!</h1>
			</div>
			<div class="col-12 " id="contactFormDiv">
				{!! Form::open(['route' => ['contact-us.send'], 'method' => 'POST', 'name' => 'contactForm', 'id' => 'contactForm']) !!}

				  	<div class="form-group row justify-content-center">
				    	{!! Form::label('name', 'Nombre', ['class' => 'col-sm-2 col-form-label text-uppercase text-sm-right text-secondary']) !!}
				    	<div class="col-sm-4">
				      		{!! Form::text('name', old('name'), ['id' => 'name', 'class' => 'form-control', 'required']) !!}
				    	</div>
				  	</div>

				  	<div class="form-group row justify-content-center">
				    	{!! Form::label('email', 'Email', ['class' => 'col-sm-2 col-form-label text-uppercase text-sm-right text-secondary']) !!}
				    	<div class="col-sm-4">
				      		{!! Form::email('email', old('email'), ['id' => 'email', 'class' => 'form-control', 'required']) !!}
				    	</div>
				  	</div>
				  
				  	<div class="form-group row justify-content-center">
				    	{!! Form::label('subject', 'Asunto', ['class' => 'col-sm-2 col-form-label text-uppercase text-sm-right text-secondary']) !!}
				    	<div class="col-sm-4">
				      		{!! Form::text('subject', old('subject'), ['id' => 'subject', 'class' => 'form-control', 'required']) !!}
				    	</div>
				  	</div>
				  
				  	<div class="form-group row justify-content-center">
				    	{!! Form::label('message', 'Mensaje', ['class' => 'col-sm-2 col-form-label text-uppercase text-sm-right text-secondary']) !!}
				    	<div class="col-sm-4">
				      		{!! Form::textarea('message', old('message'), ['id' => 'message', 'class' => 'form-control', 'required']) !!}
				    	</div>
				  	</div>
				  
				  	<div class="align-self-center d-flex justify-content-center">
				  		<button type="submit" class="btn btn-info btn-sm ladda-button" data-style="zoom-out" name="contactSendBtn" id="contactSendBtn">
                            <span class="ladda-label">Enviar</span>
                        </button>
				  	</div>

				{!! Form::close() !!}
			</div>
		</div>
	<!-- END SECCION BUSCAR -->
		
	@if($oConfiguration->facebook_account != '' || $oConfiguration->twitter_account != '' || $oConfiguration->instagram_account != '')
		<div class="row p-3 justify-content-center">
			<div class="col-sm-6">
				<p class="text-center">Síguenos en nuestras redes sociales:</p>
			</div>
		</div>

		<div class="row p-3 justify-content-center">
			<div class="col-8 col-sm-3">
				<div class="border-left borazul">
					@if($oConfiguration->facebook_account != '')
						<a href="{!! $oConfiguration->facebook_account !!}" class="text-secondary mt-3 pl-3" target="_blank" rel="noopener noreferrer"><span class="pr-3"><i class="fab fa-facebook-f"></i> ECSinCorrupcion</span></a><br>
					@endif
					@if($oConfiguration->twitter_account != '')
						<a href="{!! $oConfiguration->twitter_account !!}" class="text-secondary mt-3 pl-3" target="_blank" rel="noopener noreferrer"><span class="pr-3"><i class="fab fa-twitter"></i> @ECSinCorrupcion</span></a><br>
					@endif
					@if($oConfiguration->instagram_account != '')
						<a href="{!! $oConfiguration->instagram_account !!}" class="text-secondary mt-3 pl-3" target="_blank" rel="noopener noreferrer"><span class="pr-3"><i class="fab fa-instagram"></i> @fcd_ecuador</span></a>
					@endif
				</div>
			</div>
		</div>
	@endif
	
@endsection



@section('custom-js')

	{!! Html::script('public/backend/assets/plugins/jquery-validation/js/jquery.validate.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/jquery-validation/js/additional-methods.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/bootstrap-sweetalert/sweetalert.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/js/ui-sweetalert.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/ladda/spin.min.js', ['type' => 'text/javascript']) !!}
    {!! Html::script('public/backend/assets/plugins/ladda/ladda.min.js', ['type' => 'text/javascript']) !!}

    {!! Html::script('public/frontend/js/form-validate/form-validation-contact-form.min.js', ['type' => 'text/javascript']) !!}

    <script type="text/javascript">
    	$(document).ready(function(){
            @if(session()->exists('successMsg'))
                showAlert('Observatorio Anti Corrupción', '{!! session('successMsg') !!}', 'success');
            @endif

            @if(session()->exists('warningMsg'))
                showAlert('Observatorio Anti Corrupción', '{!! session('warningMsg') !!}', 'warning');
            @endif

            @if(session()->exists('errorMsg'))
                showAlert('Observatorio Anti Corrupción', '{!! session('errorMsg') !!}', 'error');
            @endif
        });
    </script>

@endsection