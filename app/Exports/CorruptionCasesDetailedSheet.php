<?php

namespace BlaudCMS\Exports;

use BlaudCMS\CorruptionCase;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CorruptionCasesDetailedSheet implements FromView, WithTitle, ShouldAutoSize
{

	private $caseStage;

    public function __construct(string $caseStage)
    {
        $this->caseStage = $caseStage;
    }

    public function view(): View
    {
        $data = [
        	'corruptionCasesList' => CorruptionCase::where('case_stage', $this->caseStage)->get(),
        	'corruptionCasesData' => CorruptionCase::select(\DB::raw('count(id) as corruptionCaseNum, case_stage_detail'))
                     								->where('case_stage', $this->caseStage)
                     								->groupBy('case_stage_detail')
                     								->orderBy('corruptionCaseNum', 'asc')
                     								->get(),
        ];
        return view('frontend.exports.corruption-cases-detail', $data);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->caseStage;
    }
}
