<html>
    <head>
		<style type="text/css">
	
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 3cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 2cm;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 3cm;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;
            }
        


	.causas img{
		display:none!important;
	}
	#causas img{
		display:none!important;
	}
	
</style>

</head>
    <body>

    	<!-- Define header and footer blocks before your content -->
        <header>
            <table width="100%">
				<tr>
					<td valign="middle" align="left">
		      			<img src="{!! asset('public/frontend/images/logo-sitio.png') !!}" width="70%" />
					</td>
					<td valign="middle" align="center">
		                <img src="{!! asset('public/frontend/images/fcd.png') !!}"  width="80%" />
					</td>
				</tr>
			</table>
        </header>

        <footer>
        	<div style="text-align: center;display: block;"><strong>www.ciudadaniaydesarrollo.org</strong></div>
        	Av. Gral. Eloy Alfaro y 6 de Diciembre, Edificio Monasterio Plaza, Piso 10 | (+593) 2 333 2526 | Quito - Ecuador
            <div style="background-color: #D2B02D; padding: 5px;">

			</div>
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>

			<h1 style="font-family:Helvetica">{!! $oCorruptionCase->title !!}</h1>
		</main>
		<hr />
		
		<img src="{!! $oStorage->url($oCorruptionCase->main_multimedia) !!}" style="max-width: 100%;" />

		<h3 style="font-family:Helvetica">ANTECEDENTES</h3>
		
		@if($oCorruptionCase->history_image)
		<div>
			<img src="{!! $oStorage->url($oCorruptionCase->history_image) !!}" alt="{!! $oCorruptionCase->title !!}" style="max-width: 100%;width: 100%;">
		</div>
		@endif

		<div style="text-align: justify;font-family: Helvetica"> {!! $oCorruptionCase->history !!}</div>
		<hr />
		
		@php
			$aWhatHappened = $oCorruptionCase->whatsHappeneds()->orderBy('order', 'asc')->get();
		@endphp

		@if($aWhatHappened->isNotEmpty())
			 <h3 style="font-family:Helvetica">¿Qué ocurrió?</h3>
			 <table cellpadding="5" cellspacing="5">
			 @foreach($aWhatHappened as $oWhatHappened)
		 		<tr>
		 			<td>
		 				<div style="text-align: left;font-family: Helvetica">{!! $oWhatHappened->day != '' ? $oWhatHappened->day : '' !!} {!! $oWhatHappened->month != '' ? $oWhatHappened->month : '' !!} {!! $oWhatHappened->year != '' ? $oWhatHappened->year : '' !!}</div>
		 			</td>
		 			<td><div style="text-align: justify;font-family: Helvetica">{!! $oWhatHappened->description !!}</div></td>
		 		</tr>
			 @endforeach
			 </table>
		@endif
		<hr />
		<h3 style="font-family:Helvetica">¿Por Qué ocurrió?</h3>
		
		@if($oCorruptionCase->legal_causes != '')
			<h4 style="font-family:Helvetica">Causas Jurídicas</h4>
			<div style="text-align: justify;font-family: Helvetica" class="causas" id="causas">
				{!! $oCorruptionCase->legal_causes !!}
			</div>
		@endif
		<br />
		@if($oCorruptionCase->political_causes != '')
			<h4 style="font-family:Helvetica">Causas Técnicas</h4>
			<div style="text-align: justify;font-family: Helvetica" class="causas" id="causas">
				{!! $oCorruptionCase->political_causes !!}
			</div>
		@endif

		<hr />

		<h3 style="font-family:Helvetica">CONSECUENCIAS</h3>
		@if($oCorruptionCase->consequences_image)
		<div>
			<img src="{!! $oStorage->url($oCorruptionCase->consequences_image) !!}" alt="{!! $oCorruptionCase->title !!}" style="width: 100%;">
		</div>
		@endif
		@if($oCorruptionCase->consequences_introduction != '')
			<h4 style="font-family:Helvetica">{!! $oCorruptionCase->consequences_introduction !!}</h4>
		@endif
		@if($oCorruptionCase->consequences_title != '')
			<h5 style="font-family:Helvetica">{!! $oCorruptionCase->consequences_title !!}</h5>
		@endif
		@if($oCorruptionCase->consequences_description != '')
			<div style="text-align: justify;font-family: Helvetica">{!! $oCorruptionCase->consequences_description !!}</div>
		@endif
		@if($oCorruptionCase->economic_consequences != '')
			<h4 style="font-family:Helvetica">Económicas</h4>
			<div style="text-align: justify;font-family: Helvetica">{!! $oCorruptionCase->economic_consequences !!}</div>
		@endif
		@if($oCorruptionCase->social_consequences != '')
			<h4 style="font-family:Helvetica">Sociales y Políticas</h4>
			<div style="text-align: justify;font-family: Helvetica">{!! $oCorruptionCase->social_consequences !!}</div>
		@endif
		
		<hr />

		@if($oCorruptionCase->sources != '')
			<h4 style="font-family:Helvetica">Fuentes</h4>
			{!! $oCorruptionCase->sources !!}
		@endif

	</body>
</html>

