	<h1 style="font-family:Arial">{!! $oCorruptionCase->title !!}</h1>
	<hr />
	
	<img src="{!! $oStorage->url($oCorruptionCase->main_multimedia) !!}" style="max-width: 100%;" />

	<h3 style="font-family:Arial">ANTECEDENTES</h3>
	
	@if($oCorruptionCase->history_image)
		<center><img src="{!! $oStorage->url($oCorruptionCase->history_image) !!}" alt="{!! $oCorruptionCase->title !!}" style="margin: 0 auto;"></center>
	@endif

	<div style="text-align: justify;font-family: Arial"> {!! $oCorruptionCase->history !!}</div>
	<hr />
	
	@php
		$aWhatHappened = $oCorruptionCase->whatsHappeneds()->orderBy('order', 'asc')->get();
	@endphp

	@if($aWhatHappened->isNotEmpty())
		 <h3 style="font-family:Arial">¿Qué ocurrió?</h3>
		 <table cellpadding="5" cellspacing="5">
		 @foreach($aWhatHappened as $oWhatHappened)
	 		<tr>
	 			<td>
	 				{!! $oWhatHappened->day != '' ? $oWhatHappened->day : '' !!} {!! $oWhatHappened->month != '' ? $oWhatHappened->month : '' !!} {!! $oWhatHappened->year != '' ? $oWhatHappened->year : '' !!}
	 			</td>
	 			<td><div style="text-align: justify;font-family: Arial">{!! $oWhatHappened->description !!}</div></td>
	 		</tr>
		 @endforeach
		 </table>
	@endif
	<hr />
	<h3 style="font-family:Arial">¿Por Qué ocurrió?</h3>
	
	@if($oCorruptionCase->legal_causes != '')
		<h4 style="font-family:Arial">Causas Jurídicas</h4>
		<div style="text-align: justify;font-family: Arial">{!! $oCorruptionCase->legal_causes !!}</div>
	@endif
	<br /><br />
	@if($oCorruptionCase->political_causes != '')
		<h4 style="font-family:Arial">Causas Técnicas</h4>
		<div style="text-align: justify;font-family: Arial">{!! $oCorruptionCase->political_causes !!}</div>
	@endif

	<hr />

	<h3 style="font-family:Arial">CONSECUENCIAS</h3>
	@if($oCorruptionCase->consequences_image)
		<img src="{!! $oStorage->url($oCorruptionCase->consequences_image) !!}" alt="{!! $oCorruptionCase->title !!}">
	@endif
	@if($oCorruptionCase->consequences_introduction != '')
		<h4 style="font-family:Arial">{!! $oCorruptionCase->consequences_introduction !!}</h4>
	@endif
	@if($oCorruptionCase->consequences_title != '')
		<h5>{!! $oCorruptionCase->consequences_title !!}</h5>
	@endif
	@if($oCorruptionCase->consequences_description != '')
		<div style="text-align: justify;font-family: Arial">{!! $oCorruptionCase->consequences_description !!}</div>
	@endif
	@if($oCorruptionCase->economic_consequences != '')
		<h4 style="font-family:Arial">Económicas</h4>
		<div style="text-align: justify;font-family: Arial">{!! $oCorruptionCase->economic_consequences !!}</div>
	@endif
	@if($oCorruptionCase->social_consequences != '')
		<h4 style="font-family:Arial">Sociales</h4>
		<div style="text-align: justify;font-family: Arial">{!! $oCorruptionCase->social_consequences !!}</div>
	@endif
	
	<hr />

	@if($oCorruptionCase->sources != '')
		<h6 style="font-family:Arial">Fuentes</h6>
		{!! $oCorruptionCase->sources !!}
	@endif