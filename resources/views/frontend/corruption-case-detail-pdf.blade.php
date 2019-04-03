	<h1>{!! $oCorruptionCase->title !!}</h1>
	<hr />
	
	<img src="{!! $oStorage->url($oCorruptionCase->main_multimedia) !!}" />

	<h3>ANTECEDENTES</h3>
	
	@if($oCorruptionCase->history_image)
		<img src="{!! $oStorage->url($oCorruptionCase->history_image) !!}" alt="{!! $oCorruptionCase->title !!}">
	@endif

	{!! $oCorruptionCase->history !!}
	<hr />
	
	@php
		$aWhatHappened = $oCorruptionCase->whatsHappeneds()->orderBy('order', 'asc')->get();
	@endphp

	@if($aWhatHappened->isNotEmpty())
		 <h3>¿Qué ocurrió?</h3>
		 <table cellpadding="5" cellspacing="5">
		 @foreach($aWhatHappened as $oWhatHappened)
	 		<tr>
	 			<td>
	 				{!! $oWhatHappened->day != '' ? $oWhatHappened->day : '' !!} {!! $oWhatHappened->month != '' ? $oWhatHappened->month : '' !!} {!! $oWhatHappened->year != '' ? $oWhatHappened->year : '' !!}
	 			</td>
	 			<td>{!! $oWhatHappened->description !!}</td>
	 		</tr>
		 @endforeach
		 </table>
	@endif
	<hr />
	<h3>¿Por Qué ocurrió?</h3>
	
	@if($oCorruptionCase->legal_causes != '')
		<h4>Causas Jurídicas</h4>
		{!! $oCorruptionCase->legal_causes !!}
	@endif
	<br /><br />
	@if($oCorruptionCase->political_causes != '')
		<h4>Causas Técnicas</h4>
		{!! $oCorruptionCase->political_causes !!}
	@endif

	<hr />

	<h3>CONSECUENCIAS</h3>
	@if($oCorruptionCase->consequences_image)
		<img src="{!! $oStorage->url($oCorruptionCase->consequences_image) !!}" alt="{!! $oCorruptionCase->title !!}">
	@endif
	@if($oCorruptionCase->consequences_introduction != '')
		<h4>{!! $oCorruptionCase->consequences_introduction !!}</h4>
	@endif
	@if($oCorruptionCase->consequences_title != '')
		<h5>{!! $oCorruptionCase->consequences_title !!}</h5>
	@endif
	@if($oCorruptionCase->consequences_description != '')
		{!! $oCorruptionCase->consequences_description !!}
	@endif
	@if($oCorruptionCase->economic_consequences != '')
		<h4>Económicas</h4>
		{!! $oCorruptionCase->economic_consequences !!}
	@endif
	@if($oCorruptionCase->social_consequences != '')
		<h4>Sociales</h4>
		{!! $oCorruptionCase->social_consequences !!}
	@endif
	
	<hr />

	@if($oCorruptionCase->sources != '')
		<h6>Fuentes</h6>
		{!! $oCorruptionCase->sources !!}
	@endif