<table>
   <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
   <tr>
        <td colspan="6" >Información Casos de Corrupción</td>
    </tr>
</table>

<table>
    <thead>
    <tr>
        <th>DETALLE DE LOS CASOS</th>
        <th>SUBETAPA</th>
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
    <tr>
        <td></td>
    </tr>
    @if($corruptionCasesData->isNotEmpty())
        @foreach($corruptionCasesData as $oCorruptionCase)
            <tr>
                <td>{{ strtoupper($oCorruptionCase->case_stage_detail) }}</td>
                <td>{{ $oCorruptionCase->corruptionCaseNum }}</td>
            </tr>
        @endforeach
    @endif
    <tr>
        <td>TOTAL GENERAL</td>
        <td>{!! $corruptionCasesList->count() !!}</td>
    </tr>
    </tbody>
</table>