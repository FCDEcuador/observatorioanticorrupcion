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
            <th width="100pt" ><b>DETALLE DE LOS CASOS</b></th>
            <th width="100pt" ><b>FUNCIONES DEL ESTADO</b></th>
            <th width="100pt" ><b>PROVINCIAS</b></th>
            <th width="100pt" ><b>AÑO</b></th>
            <th width="100pt" ><b>FUNCIONARIOS PUBLICOS INVOLUCRADOS</b></th>
            <th width="100pt" ><b>INSTITUCIONES PUBLICAS INVOLUCRADAS</b></th>
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
        <td>{!! $corruptionCases->count() !!}</td>
    </tr>
    </tbody>
</table>