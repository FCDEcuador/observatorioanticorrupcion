<table width="100%">
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
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td colspan="6" align="center">Información Casos de Corrupción</td>
    </tr>
</table>



<table width="100%">
    <thead>
        <tr>
            <th width="80" >DETALLE DE LOS CASOS</th>
            <th width="80" >FUNCIONES DEL ESTADO</th>
            <th width="80" >TERRITORIO</th>
            <th width="80" >AÑO</th>
            <th width="140" >FUNCIONARIOS PUBLICOS INVOLUCRADOS</th>
            <th width="140" >INSTITUCIONES PUBLICAS INVOLUCRADAS</th>
        </tr>
    </thead>
    <tbody>
    @if($corruptionCases->isNotEmpty())
        @foreach($corruptionCases as $oCorruptionCase)
            @php
                $minYear = $oCorruptionCase->whatsHappeneds()->min('year');
            @endphp
            <tr>
                <td>{{ $oCorruptionCase->title }}</td>
                <td>{{ $oCorruptionCase->state_function }}</td>
                <td>{{ implode(',', $oCorruptionCase->province) }}</td>
                <td>{{ $minYear }}</td>
                <td>{{ implode(',', $oCorruptionCase->public_officials_involved) }}</td>
                <td>{{ implode(',', $oCorruptionCase->linked_institutions) }}</td>
            </tr>
        @endforeach
    @endif
    <tr>
        <td>TOTAL GENERAL</td>
        <td>{!! $corruptionCases->count() !!}</td>
    </tr>
    </tbody>
</table>