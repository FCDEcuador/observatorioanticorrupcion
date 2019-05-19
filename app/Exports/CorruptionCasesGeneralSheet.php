<?php

namespace BlaudCMS\Exports;

use BlaudCMS\CorruptionCase;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

class CorruptionCasesGeneralSheet implements FromView, WithTitle, WithEvents, ShouldAutoSize
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

        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => '14',
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => [ 'rgb' => 'c3d5e9' ],
            ],
            
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
                
                $event->sheet->getStyle('A11')->applyFromArray($styleArray);

                $event->sheet->getStyle('A11:H20')->applyFromArray($styleArray2);

                $event->sheet->getStyle('A11:H11')->applyFromArray($styleArray3);


                $objColum = new \PhpOffice\PhpSpreadsheet\Worksheet\ColumnDimension();
                $objColum->setWidth(array(
                    'A'     => 40,
                    'B'     =>  40,
                    'C'     =>  40,
                    'D'     =>  40,
                    'E'     =>  40,
                    'F'     =>  40,
                    'G'     =>  100,
                    'H'     =>  100,
                ));
                //$objColum->setWorksheet($event->sheet->getDelegate());

                
                $objDrawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $objDrawing->setName('Logo');
                $objDrawing->setDescription('Logo');
                $objDrawing->setPath(public_path('frontend/images/logo-sitio.png'));
                $objDrawing->setWidthAndHeight(130,126);
                //$objDrawing->setResizeProportional(true);
                $objDrawing->setCoordinates('A2');

                

                $objDrawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $objDrawing2->setName('FCD');
                $objDrawing2->setDescription('FCD');
                $objDrawing2->setPath(public_path('frontend/images/fcd.png'));
                $objDrawing->setWidthAndHeight(130,128);
                //$objDrawing->setResizeProportional(true);
                $objDrawing2->setOffsetX(20);
                $objDrawing2->setCoordinates('F2');

                

                $event->sheet->insertNewColumnBefore('A',2);
                $objDrawing->setWorksheet($event->sheet->getDelegate());  
                $objDrawing2->setWorksheet($event->sheet->getDelegate());

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
