<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RiskOpportunityExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $formattedData;
    protected $counter = 1; // Untuk penomoran

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
            // Baris pertama: judul utama
            ['RISK & REGISTER OPPORTUNITY'],
            // Baris kedua kosong sebagai spasi
            [],
            // Baris ketiga: header tabel
            [
                'No',
                'Issue',
                'Pihak Berkepentingan',
                'Risiko',
                'Peluang',
                'Tingkatan',
                'Tindakan Lanjut',
                'Target PIC',
                'Tanggal Penyelesaian',
                'Status',
                'Actual Risk',
                'Before',
                'After',
            ],
        ];
    }

    public function map($row): array
    {
        // Pastikan data yang berupa array
        $pihak = is_array($row['pihak']) ? array_unique($row['pihak']) : [$row['pihak']];
        $tindak_lanjut = is_array($row['tindak_lanjut']) ? $row['tindak_lanjut'] : [$row['tindak_lanjut']];
        $targetpic = is_array($row['targetpic']) ? $row['targetpic'] : [$row['targetpic']];
        $tgl_penyelesaian = is_array($row['tgl_penyelesaian']) ? $row['tgl_penyelesaian'] : [$row['tgl_penyelesaian']];

        $mappedRows = [];
        // Hitung baris maksimal untuk detail (jika ada lebih dari satu data)
        $maxRows = max(count($pihak), count($tindak_lanjut), count($targetpic), count($tgl_penyelesaian));

        for ($i = 0; $i < $maxRows; $i++) {
            $mappedRows[] = [
                $i === 0 ? $this->counter++ : '',
                $i === 0 ? $row['issue'] : '',
                $i === 0 ? implode(', ', $pihak) : '',
                $i === 0 ? $row['risiko'] : '',
                $i === 0 ? $row['peluang'] : '',
                $i === 0 ? $row['tingkatan'] : '',
                $tindak_lanjut[$i] ?? '',
                $targetpic[$i] ?? '',
                $tgl_penyelesaian[$i] ?? '',
                $i === 0 ? $row['status'] : '',
                $i === 0 ? $row['scores'] : '',
                $i === 0 ? $row['before'] : '',
                $i === 0 ? $row['after'] : '',
            ];
        }
        // Baris kosong sebagai pemisah antar record
        $mappedRows[] = ['', '', '', '', '', '', '', '', '', '', '', '', ''];

        return $mappedRows;
    }

    public function styles(Worksheet $sheet)
    {
        // Gabungkan sel dari A1 sampai M1 untuk judul utama
        $sheet->mergeCells('A1:M1');
        // Set judul utama
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        // Atur tinggi baris untuk judul dan header
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(3)->setRowHeight(20);

        // Styling untuk header (baris ke-3)
        $sheet->getStyle('A3:M3')->getFont()->setBold(true);
        $sheet->getStyle('A3:M3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3:M3')->getAlignment()->setVertical('center');
        $sheet->getStyle('A3:M3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // Aktifkan AutoFilter pada header
        $sheet->setAutoFilter('A3:M3');

        // Set lebar kolom agar sesuai
        $sheet->getColumnDimension('A')->setWidth(5);   // No
        $sheet->getColumnDimension('B')->setWidth(30);  // Issue
        $sheet->getColumnDimension('C')->setWidth(25);  // Pihak Berkepentingan
        $sheet->getColumnDimension('D')->setWidth(15);  // Risiko
        $sheet->getColumnDimension('E')->setWidth(15);  // Peluang
        $sheet->getColumnDimension('F')->setWidth(15);  // Tingkatan
        $sheet->getColumnDimension('G')->setWidth(20);  // Tindakan Lanjut
        $sheet->getColumnDimension('H')->setWidth(15);  // Target PIC
        $sheet->getColumnDimension('I')->setWidth(15);  // Tanggal Penyelesaian
        $sheet->getColumnDimension('J')->setWidth(15);  // Status
        $sheet->getColumnDimension('K')->setWidth(30);  // Actual Risk
        $sheet->getColumnDimension('L')->setWidth(15);  // Before
        $sheet->getColumnDimension('M')->setWidth(15);  // After

        // Terapkan border pada seluruh data (mulai baris 4 hingga baris terakhir)
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle("A4:M{$highestRow}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // Aktifkan wrap text pada seluruh data agar isi sel dibungkus
        $sheet->getStyle("A4:M{$highestRow}")->getAlignment()->setWrapText(true);
    }
}
