<?php

namespace BlaudCMS\Exports;

use BlaudCMS\CorruptionCase;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CorruptionCasesExport implements WithMultipleSheets
{
    use Exportable;
    
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        
        $sheets[] = new CorruptionCasesGeneralSheet();
        $aCaseStage = CorruptionCase::select('case_stage')->distinct()->get();
        if($aCaseStage->isNotEmpty()){
        	foreach($aCaseStage as $caseStage){
        		$sheets[] = new CorruptionCasesDetailedSheet($caseStage->case_stage);
        	}
        }
        $sheets[] = new CorruptionCasesDataSheet();
        
        return $sheets;
    }
}
