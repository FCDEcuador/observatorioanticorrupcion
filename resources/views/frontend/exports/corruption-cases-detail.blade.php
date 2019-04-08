<table>
    <thead>
    <tr>
        <th>
            <img src="{!! URL::asset('public/frontend/images/logo-sitio.png') !!}" />
        </th>
        <th>
            <img src="{!! URL::asset('public/frontend/images/fcd.png') !!}" />
        </th>
    </tr>
    </thead>
</table>

<table>
    <thead>
    <tr>
        <th><strong>DETALLE DE LOS CASOS</strong></th>
        <th><strong>SUBETAPA</strong></th>
    </tr>
    </thead>
    <tbody>
    @if($corruptionCasesList->isNotEmpty())
        @foreach($corruptionCasesList as $oCorruptionCase)
            <tr>
                <td>{{ $oCorruptionCase->title }}</td>
                <td>{{ $oCorruptionCase->case_stage_detail }}</td>
            </tr>
        @endforeach
    @endif
    @if($corruptionCasesData->isNotEmpty())
        @foreach($corruptionCasesData as $oCorruptionCase)
            <tr>
                <td><strong>{{ strtoupper($oCorruptionCase->case_stage_detail) }}</strong></td>
                <td>{{ $oCorruptionCase->corruptionCaseNum }}</td>
            </tr>
        @endforeach
    @endif
    <tr>
        <td><strong>TOTAL GENERAL</strong></td>
        <td>{!! $corruptionCasesList->count() !!}</td>
    </tr>
    </tbody>
</table>