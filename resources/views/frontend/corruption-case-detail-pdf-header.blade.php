<div>
	<table width="100%">
		<tr>
			<td valign="middle" align="center">

	      		@if($oConfiguration->frontend_logo != '')
	      			<img src="{!! asset($oStorage->url($oConfiguration->frontend_logo)) !!}" width="80%" />
	      		@else
	      			<img src="{!! asset('public/frontend/images/logo-sitio.png') !!}" />
	      		@endif
			</td>
			<td valign="middle" align="center">
				@if($oConfiguration->backend_logo != '')
                    <img src="{!! asset($oStorage->url($oConfiguration->backend_logo)) !!}" />
                @else
                    <img src="{!! asset('public/frontend/images/fcd.png') !!}" class="pl-3" />
                @endif
			</td>
		</tr>
	</table>
</div>