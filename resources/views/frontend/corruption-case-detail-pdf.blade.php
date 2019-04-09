	<h1 style="font-family:Helvetica">{!! $oCorruptionCase->title !!}</h1>
	<hr />
	
	<img src="{!! $oStorage->url($oCorruptionCase->main_multimedia) !!}" style="max-width: 100%;" />

	<h3 style="font-family:Helvetica">ANTECEDENTES</h3>
	
	@if($oCorruptionCase->history_image)
	<table align="center">
		<tr>
			<td>
				<img src="{!! $oStorage->url($oCorruptionCase->history_image) !!}" alt="{!! $oCorruptionCase->title !!}" >
			</td>
		</tr>
	</table>
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
	 				{!! $oWhatHappened->day != '' ? $oWhatHappened->day : '' !!} {!! $oWhatHappened->month != '' ? $oWhatHappened->month : '' !!} {!! $oWhatHappened->year != '' ? $oWhatHappened->year : '' !!}
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
		<div style="text-align: justify;font-family: Helvetica">{!! $oCorruptionCase->legal_causes !!}</div>
	@endif
	<br /><br />
	@if($oCorruptionCase->political_causes != '')
		<h4 style="font-family:Helvetica">Causas Técnicas</h4>
		<div style="text-align: justify;font-family: Helvetica">{!! $oCorruptionCase->political_causes !!}</div>
	@endif

	<hr />

	<h3 style="font-family:Helvetica">CONSECUENCIAS</h3>
	@if($oCorruptionCase->consequences_image)
		<img src="{!! $oStorage->url($oCorruptionCase->consequences_image) !!}" alt="{!! $oCorruptionCase->title !!}">
	@endif
	@if($oCorruptionCase->consequences_introduction != '')
		<h4 style="font-family:Helvetica">{!! $oCorruptionCase->consequences_introduction !!}</h4>
	@endif
	@if($oCorruptionCase->consequences_title != '')
		<h5>{!! $oCorruptionCase->consequences_title !!}</h5>
	@endif
	@if($oCorruptionCase->consequences_description != '')
		<div style="text-align: justify;font-family: Helvetica">{!! $oCorruptionCase->consequences_description !!}</div>
	@endif
	@if($oCorruptionCase->economic_consequences != '')
		<h4 style="font-family:Helvetica">Económicas</h4>
		<div style="text-align: justify;font-family: Helvetica">{!! $oCorruptionCase->economic_consequences !!}</div>
	@endif
	@if($oCorruptionCase->social_consequences != '')
		<h4 style="font-family:Helvetica">Sociales</h4>
		<div style="text-align: justify;font-family: Helvetica">{!! $oCorruptionCase->social_consequences !!}</div>
	@endif
	
	<hr />

	@if($oCorruptionCase->sources != '')
		<h6 style="font-family:Helvetica">Fuentes</h6>
		{!! $oCorruptionCase->sources !!}
	@endif