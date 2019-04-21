<?php

namespace BlaudCMS\Exports;

use BlaudCMS\CorruptionCase;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use \Maatwebsite\Excel\Sheet;

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
            ],
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ];

        //$spreadsheet->getActiveSheet()->getStyle('B2')->getAlignment()->applyFromArray( [ 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, 'textRotation' => 0, 'wrapText' => TRUE ] );

        return [
            AfterSheet::class => function(AfterSheet $event) use ($styleArray) {
                $event->sheet->getActiveSheet()->getStyle('A1:F4')->applyFromArray($styleArray);
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
