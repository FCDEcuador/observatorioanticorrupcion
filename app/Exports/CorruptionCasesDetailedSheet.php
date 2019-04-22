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

class CorruptionCasesDetailedSheet implements FromView, WithTitle, ShouldAutoSize, WithEvents
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

        //$spreadsheet->getActiveSheet()->getStyle('B2')->getBorders()->applyFromArray( [ 'allBorders' => [ 'borderStyle' => Border::BORDER_DASHDOT, 'color' => [ 'rgb' => '808080' ] ] ] );
        //$spreadsheet->getActiveSheet()->getStyle('B2')->getAlignment()->applyFromArray( [ 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, 'textRotation' => 0, 'wrapText' => TRUE ] );


        $styleArray3 = [
            'font' => [
                'bold' => true,
                'size' => '12',
            ],
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($styleArray,$styleArray2,$styleArray3) {
                
                $event->sheet->getStyle('A5')->applyFromArray($styleArray);

                $event->sheet->getStyle('A11:B14')->applyFromArray($styleArray2);

                $event->sheet->getStyle('A11:B11')->applyFromArray($styleArray3);
                
                $objDrawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $objDrawing->setName('Logo');
                $objDrawing->setDescription('Logo');
                $objDrawing->setPath(public_path('frontend/images/logo-sitio.png'));
                //$objDrawing->setHeight(100);
                $objDrawing->setResizeProportional(true);
                $objDrawing->setCoordinates('B2');

                $objDrawing->setWorksheet($event->sheet->getDelegate());

                $objDrawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $objDrawing2->setName('FCD');
                $objDrawing2->setDescription('FCD');
                $objDrawing2->setPath(public_path('frontend/images/fcd.png'));
                //$objDrawing2->setHeight(100);
                $objDrawing2->setResizeProportional(true);
                $objDrawing2->setCoordinates('G2');

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
