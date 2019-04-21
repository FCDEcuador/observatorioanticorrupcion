<table width="100%">
    <tr>
        <td>
             <img src="http://www.observatorioanticorrupcion.ec/public/frontend/images/logo-sitio.png" />
             <img src="http://www.observatorioanticorrupcion.ec/public/frontend/images/fcd.png" />
        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td colspan="6" align="center"><h1>Información Casos de Corrupción</h1></td>
    </tr>
</table>

<table width="100%">
    <thead>
        <tr>
            <th><strong>DETALLE DE LOS CASOS</strong></th>
            <th><strong>FUNCIONES DEL ESTADO</strong></th>
            <th><strong>PROVINCIAS</strong></th>
            <th><strong>AÑO</strong></th>
            <th><strong>FUNCIONARIOS PUBLICOS INVOLUCRADOS</strong></th>
            <th><strong>INSTITUCIONES PUBLICAS INVOLUCRADAS</strong></th>
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
        <td><strong>TOTAL GENERAL</strong></td>
        <td colspan="5">{!! $corruptionCases->count() !!}</td>
    </tr>
    </tbody>
</table>