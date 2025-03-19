<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Alignment as StyleAlignment;

class Risk2 implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $formattedData;
    protected $counter = 1;

    public function __construct($formattedData)
    {
        $this->formattedData = $formattedData;
    }

    public function collection()
    {
        return collect($this->formattedData);
    }

    public function headings(): array
    {
        return [
            ['IDENTIFIKASI, PENILAIAN, DAN PENGENDALIAN RISIKO PENYUAPAN'],
            [],
            ['No', 'Nama Proses', 'Potensi Risk Penyuapan', 'Skema Penyuapan / Modus Operandi', '*S', '*P', 'Level', 'Tindakan Terhadap Risiko', 'Sisa Risiko', '', '', 'Rencana Tindakan / Mitigasi'],
            ['', '', '', '', '', '', '', '', '*S',     '*P',    'Level', ''],
        ];
    }

    public function map($row): array
    {

        $tindak_lanjut = is_array($row['tindak_lanjut']) ? $row['tindak_lanjut'] : [$row['tindak_lanjut']];

        $mappedRows = [];
        $maxRows = count($tindak_lanjut);

        for ($i = 0; $i < $maxRows; $i++) {
            $mappedRows[] = [
                $i === 0 ? $this->counter++ : '',
                $i === 0 ? $row['issue'] : '',
                $i === 0 ? $row['risiko'] : '',
                $i === 0 ? $row['before'] : '',
                $i === 0 ? $row['severity'] : '',
                $i === 0 ? $row['probability'] : '',
                $i === 0 ? $row['scores'] : '',
                $tindak_lanjut[$i] ?? '',
                $i === 0 ? $row['severityrisk'] : '',
                $i === 0 ? $row['probabilityrisk'] : '',
                $i === 0 ? ($row['severityrisk'] * $row['probabilityrisk']) : '',
                $i === 0 ? $row['after'] : '',
            ];
        }

        return $mappedRows;
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cells di baris 1, kolom A hingga L
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getAlignment()->setVertical('center');
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(3)->setRowHeight(20);
        $sheet->getRowDimension(4)->setRowHeight(20);

        $sheet->getStyle('A3:L3')->getFont()->setBold(true);
        $sheet->getStyle('A3:L3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3:L3')->getAlignment()->setVertical('center');
        $sheet->getStyle('A3:L3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A4:L4')->getFont()->setBold(true);
        $sheet->getStyle('A4:L4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A4:L4')->getAlignment()->setVertical('center');
        $sheet->getStyle('A4:L4')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getColumnDimension('A')->setWidth(5);   // No
        $sheet->getColumnDimension('B')->setWidth(30);  // Nama Proses
        $sheet->getColumnDimension('C')->setWidth(25);  // Potensi Risk Penyuapan
        $sheet->getColumnDimension('D')->setWidth(25);  // Skema Penyuapan / Modus Operandi
        $sheet->getColumnDimension('E')->setWidth(5);  // *S
        $sheet->getColumnDimension('F')->setWidth(5);  // *P
        $sheet->getColumnDimension('G')->setWidth(10);  // Level
        $sheet->getColumnDimension('H')->setWidth(25);  // Tindakan Terhadap Risiko
        $sheet->getColumnDimension('I')->setWidth(5);  // *S
        $sheet->getColumnDimension('J')->setWidth(5);  // *P
        $sheet->getColumnDimension('K')->setWidth(10);  // Level
        $sheet->getColumnDimension('L')->setWidth(25);  // Rencana Tindakan / Mitigasi

        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle("A5:L{$highestRow}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle("A5:M{$highestRow}")->getAlignment()->setWrapText(true);
        $sheet->getStyle("A5:M{$highestRow}")
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_LEFT)  // Rata kiri
            ->setVertical(StyleAlignment::VERTICAL_TOP);
        $sheet->getStyle("E5:G{$highestRow}")
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle("I5:K{$highestRow}")
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A3:L4')->getAlignment()->setWrapText(true);
        $sheet->mergeCells('I3:K3');

        // Merge sel di baris 3 dan 4 untuk kolom A sampai L sesuai dengan header
        $sheet->mergeCells('A3:A4');
        $sheet->mergeCells('B3:B4');
        $sheet->mergeCells('C3:C4');
        $sheet->mergeCells('D3:D4');
        $sheet->mergeCells('E3:E4');
        $sheet->mergeCells('F3:F4');
        $sheet->mergeCells('G3:G4');
        $sheet->mergeCells('H3:H4');
        $sheet->mergeCells('L3:L4');
    }
}
