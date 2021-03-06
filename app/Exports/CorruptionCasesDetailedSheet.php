<?php

namespace BlaudCMS\Exports;

use BlaudCMS\CorruptionCase;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

class CorruptionCasesDetailedSheet implements FromView, WithTitle, WithEvents, ShouldAutoSize
{

	private $caseStage;

    public function __construct(string $caseStage)
    {
        $this->caseStage = $caseStage;
    }

    public function registerEvents(): array
    {

        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => '14',
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ]
            
        ];

        $styleArray2 = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '808080'],
                
                ],
            ]
        ];

        $styleArray3 = [
            'font' => [
                'bold' => true,
                'size' => '12',
            ],
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($styleArray,$styleArray2,$styleArray3) {
                
                $event->sheet->getStyle('A9')->applyFromArray($styleArray);

                $event->sheet->getStyle('A11:B25')->applyFromArray($styleArray2);

                $event->sheet->getStyle('A11:B11')->applyFromArray($styleArray3);
                
                $objDrawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $objDrawing->setName('Logo');
                $objDrawing->setDescription('Logo');
                $objDrawing->setPath(public_path('frontend/images/logo-sitio.png'));
                $objDrawing->setHeight(70);
                //$objDrawing->setOffsetX(60);
                //$objDrawing->setOffsetY(70);
                //$objDrawing->setResizeProportional(true);
                $objDrawing->setCoordinates('A2');

                

                $objDrawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $objDrawing2->setName('FCD');
                $objDrawing2->setDescription('FCD');
                $objDrawing2->setPath(public_path('frontend/images/fcd.png'));
                $objDrawing2->setHeight(80);
                $objDrawing2->setOffsetX(60);
                //$objDrawing->setResizeProportional(true);
                $objDrawing2->setOffsetY(70);
                $objDrawing2->setCoordinates('D2');

                

                $event->sheet->insertNewColumnBefore('A',2);  
                $objDrawing->setWorksheet($event->sheet->getDelegate());
                $objDrawing2->setWorksheet($event->sheet->getDelegate());
            },
            
        ];
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
