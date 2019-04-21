<?php

namespace BlaudCMS\Exports;

use BlaudCMS\CorruptionCase;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

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

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ];

        return [
            AfterSheet::class => function(AfterSheet $event) use ($styleArray) {
                $event->sheet->getStyle('A1:G4')->applyFromArray($styleArray);
            },
            AfterSheet::class => function(AfterSheet $event) {
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Fundación Ciudadanía y Desarrollo');
                $drawing->setDescription('Fundación Ciudadanía y Desarrollo');
                $drawing->setPath(public_path('frontend/images/fcd.png'));
                $drawing->setHeight(200);
                $drawing->setCoordinates('D1');

                $drawing->setWorksheet($event->sheet->getDelegate());
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
