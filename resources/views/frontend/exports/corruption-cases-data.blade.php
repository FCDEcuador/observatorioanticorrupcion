<table width="100%">
    <thead>
        <tr>
            <th>CASO DE CORRUPCION</th>
            <th>ETAPA DEL CASO</th>
            <th>DETALLE DE ETAPA DEL CASO</th>
            <th>TERRITORIO</th>
            <th>AÑO</th>
            <th>FUINCION DEL ESTADO</th>
            <th>FUNCIONARIOS PUBLICOS INVOLUCRADOS</th>
            <th>INSTITUCIONES PUBLICAS INVOLUCRADAS</th>
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
                <td>{{ $oCorruptionCase->case_stage }}</td>
                <td>{{ $oCorruptionCase->case_stage_detail }}</td>
                <td>{{ implode(',', $oCorruptionCase->province) }}</td>
                <td>{{ $minYear }}</td>
                <td>{{ $oCorruptionCase->state_function }}</td>
                <td>{{ implode(',', $oCorruptionCase->public_officials_involved) }}</td>
                <td>{{ implode(',', $oCorruptionCase->linked_institutions) }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>