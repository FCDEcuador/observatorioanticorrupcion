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
        <td colspan="6" align="center">Información Casos de Corrupción</td>
    </tr>
</table>

<table width="100%">
    <thead>
        <tr>
            <th><b>DETALLE DE LOS CASOS</b></th>
            <th><b>FUNCIONES DEL ESTADO</b></th>
            <th><b>PROVINCIAS</b></th>
            <th><b>AÑO</b></th>
            <th><b>FUNCIONARIOS PUBLICOS INVOLUCRADOS</b></th>
            <th><b>INSTITUCIONES PUBLICAS INVOLUCRADAS</b></th>
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
                <td>{{ $oCorruptionCase->province }}</td>
                <td>{{ $minYear }}</td>
                <td>{{ implode(',', $oCorruptionCase->public_officials_involved) }}</td>
                <td>{{ implode(',', $oCorruptionCase->linked_institutions) }}</td>
            </tr>
        @endforeach
    @endif
    <tr>
        <td><b>TOTAL GENERAL</b></td>
        <td colspan="5">{!! $corruptionCases->count() !!}</td>
    </tr>
    </tbody>
</table>