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

class CorruptionCasesGeneralSheet implements FromView, WithTitle, ShouldAutoSize, WithEvents
{

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Datos Generales';
    }

    public function registerEvents(): array
    {

        //Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
        //    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        //});

        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => '16px',
            ],
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ];

        $styleArray2 = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'FFFF0000'],
                ],
            ],
        ];

        $styleArray3 = [
            'font' => [
                'bold' => true,
                'size' => '16px',
            ],
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($styleArray) {
                
                $event->sheet->getStyle('A9')->applyFromArray($styleArray);

                $event->sheet->getStyle('A11:F13')->applyFromArray($styleArray2);

                $event->sheet->getStyle('A11:F11')->applyFromArray($styleArray3);
                
                $objDrawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $objDrawing->setName('Logo');
                $objDrawing->setDescription('Logo');
                $objDrawing->setPath(public_path('frontend/images/logo-sitio.png'));
                $objDrawing->setWidthAndHeight(148,74);
                $objobjDrawing->setResizeProportional(true);
                $objDrawing->setCoordinates('C2');

                $objDrawing->setWorksheet($event->sheet->getDelegate());

                $objDrawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $objDrawing2->setName('FCD');
                $objDrawing2->setDescription('FCD');
                $objDrawing2->setPath(public_path('frontend/images/fcd.png'));
                $objDrawing2->setWidthAndHeight(148,74);
                $objobjDrawing2->setResizeProportional(true);
                $objDrawing2->setCoordinates('H2');

                $drawing2->setWorksheet($event->sheet->getDelegate());
            },
            
        ];
    }

    public function view(): View
    {
        return view('frontend.exports.corruption-cases', [
            'corruptionCases' => CorruptionCase::all()
        ]);
    }



}
