<table width="100%">
    <tr>
        <td>
             <img width="200" height="170" src="http://www.observatorioanticorrupcion.ec/public/frontend/images/logo-sitio.png" />
             <img width="200px" height="170px" src="http://www.observatorioanticorrupcion.ec/public/frontend/images/fcd.png" />
        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td colspan="6" align="center" style="text-align:center;font-size: 30px;">Información Casos de Corrupción</td>
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