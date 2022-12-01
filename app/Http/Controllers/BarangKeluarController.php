<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

use App\Models\BarangMasuk;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPUnit\Framework\Constraint\Count;

class BarangKeluarController extends Controller
{
    public function index()
    {
        return view('BarangKeluar.index', [
            'title' => 'Keluar Barang',
        ]);
    }
    public function create()
    {
        return view('BarangKeluar.create', [
            'title' => 'Tambah | Barang',
            'categorys' => Auth::user()->categories,
        ]);
    }

    public function show(BarangKeluar $barangKeluar)
    {
        $data = $barangKeluar;
        return response()->json($data);
    }

    public function edit(BarangKeluar $barangKeluar)
    {
        $this->authorize('update', $barangKeluar);
        return view('BarangKeluar.update', [
            'title' => 'Data | Update',
            'data' => $barangKeluar,
            'categoris' =>  Auth::user()->categories
        ]);
    }


    public function exportExcel(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'startColor' => [
                    'argb' => 'FFFF00',
                ],
                'endColor' => [
                    'argb' => 'FFFF00',
                ],
            ],
        ];

        $style_row_marge = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];
        $sheet->setCellValue('A1', "Laporan Pengeluaran Barang");
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->applyFromArray($style_col);


        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "Owner");
        $sheet->setCellValue('C3', "Serial Number");
        $sheet->setCellValue('D3', "Device");
        $sheet->setCellValue('E3', "Type");
        $sheet->setCellValue('F3', "Merk");
        $sheet->setCellValue('G3', "Penaggung Jawab");
        $sheet->setCellValue('H3', "Tanggal");

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);


        $no = 1;
        $numrow = 4;
        $numrowSN = 4;

        $categori_id = Auth::user()->categories()->pluck('id');

        $filterBarang = BarangKeluar::whereIn('category_id', $categori_id)->with(['device_categories', 'penanggung_jawabs']);
        $datas = $filterBarang->filter(['bulan' => $request->bulan, 'tahun' => $request->tahun, 'tanggal' => $request->tanggal, 'search' => $request->search])
            ->latest('tanggalKeluar')->get();

        foreach ($datas as $data) {
            $sheet->setCellValue("A{$numrow}", $no);
            $sheet->mergeCells("A{$numrow}:A" . ($numrow + count($data->serialNumber) - 1));
            $sheet->setCellValue('B' . $numrow, $data->pemilik);
            $sheet->mergeCells("B{$numrow}:B" . ($numrow + count($data->serialNumber) - 1));
            foreach ($data->serialNumber as $sn) {
                $sheet->setCellValue('C' . $numrowSN, $sn);
                $sheet->getStyle('C' . $numrowSN)->applyFromArray($style_row);
                $numrowSN++;
            }

            $sheet->setCellValue('D' . $numrow, $data->device);
            $sheet->mergeCells("D{$numrow}:D" . ($numrow + count($data->serialNumber) - 1));
            $sheet->setCellValue('E' . $numrow, $data->type);
            $sheet->mergeCells("E{$numrow}:E" . ($numrow + count($data->serialNumber) - 1));
            $sheet->setCellValue('F' . $numrow, $data->merek);
            $sheet->mergeCells("F{$numrow}:F" . ($numrow + count($data->serialNumber) - 1));
            $sheet->setCellValue('G' . $numrow, $data->penanggung_jawabs->name);
            $sheet->mergeCells("G{$numrow}:G" . ($numrow + count($data->serialNumber) - 1));
            $sheet->setCellValue('H' . $numrow, $data->tanggalKeluar);
            $sheet->mergeCells("H{$numrow}:H" . ($numrow + count($data->serialNumber) - 1));

            $sheet->getStyle("A{$numrow}:A" . ($numrow + count($data->serialNumber) - 1))->applyFromArray($style_row_marge);
            $sheet->getStyle("B{$numrow}:C" . ($numrow + count($data->serialNumber) - 1))->applyFromArray($style_row_marge);
            $sheet->getStyle("D{$numrow}:D" . ($numrow + count($data->serialNumber) - 1))->applyFromArray($style_row_marge);
            $sheet->getStyle("E{$numrow}:E" . ($numrow + count($data->serialNumber) - 1))->applyFromArray($style_row_marge);
            $sheet->getStyle("F{$numrow}:F" . ($numrow + count($data->serialNumber) - 1))->applyFromArray($style_row_marge);
            $sheet->getStyle("G{$numrow}:G" . ($numrow + count($data->serialNumber) - 1))->applyFromArray($style_row_marge);
            $sheet->getStyle("H{$numrow}:H" . ($numrow + count($data->serialNumber) - 1))->applyFromArray($style_row_marge);



            $no++;
            $numrow = $numrow + count($data->serialNumber);
        };

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet->setTitle("Laporan Pengeluaran Barang");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="myfile.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function exportExcelAsnet(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'startColor' => [
                    'argb' => 'FFFF00',
                ],
                'endColor' => [
                    'argb' => 'FFFF00',
                ],
            ],
        ];

        $style_row_marge = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];
        $sheet->setCellValue('A1', "Laporan Pengeluaran Barang");
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->applyFromArray($style_col);


        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "Device");
        $sheet->setCellValue('C3', "Merk");
        $sheet->setCellValue('D3', "Qty");
        $sheet->setCellValue('E3', "Penaggung Jawab");
        $sheet->setCellValue('F3', "Tanggal");
        $sheet->setCellValue('G3', "Serial Number");

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);


        $no = 1;
        $numrow = 4;
        $numrowSN = 4;


        $categori_id = Auth::user()->categories()->pluck('id');

        $filterBarang = BarangKeluar::whereIn('category_id', $categori_id)->with(['device_categories', 'penanggung_jawabs']);
        $datas = $filterBarang->filter(['bulan' => $request->bulan, 'tahun' => $request->tahun, 'tanggal' => $request->tanggal, 'search' => $request->search, 'status' => $request->status])
            ->latest('tanggalKeluar')->get();


        foreach ($datas as $data) {
            $sheet->setCellValue("A{$numrow}", $no);
            $sheet->mergeCells("A{$numrow}:A" . ($numrow + (empty($data->serialNumber) ? 1 : count($data->serialNumber)) - 1));
            $sheet->setCellValue('B' . $numrow, $data->device_categories->name);
            $sheet->mergeCells("B{$numrow}:B" . ($numrow + (empty($data->serialNumber) ? 1 : count($data->serialNumber)) - 1));
            $sheet->setCellValue('C' . $numrow, $data->merek);
            $sheet->mergeCells("C{$numrow}:C" . ($numrow + (empty($data->serialNumber) ? 1 : count($data->serialNumber)) - 1));
            $sheet->setCellValue('D' . $numrow, $data->unitKeluar . ($data->device_categories->jenis_id == 1 ? " Unit" : " Meter"));
            $sheet->mergeCells("D{$numrow}:D" . ($numrow + (empty($data->serialNumber) ? 1 : count($data->serialNumber)) - 1));
            $sheet->setCellValue('E' . $numrow, $data->penanggung_jawabs->name);
            $sheet->mergeCells("E{$numrow}:E" . ($numrow + (empty($data->serialNumber) ? 1 : count($data->serialNumber)) - 1));
            $sheet->setCellValue('F' . $numrow, $data->tanggalKeluar);
            $sheet->mergeCells("F{$numrow}:F" . ($numrow + (empty($data->serialNumber) ? 1 : count($data->serialNumber)) - 1));
            if (!empty($data->serialNumber)) {
                foreach ($data->serialNumber as $sn) {
                    $sheet->setCellValue('G' . $numrowSN, $sn);
                    $sheet->getStyle('G' . $numrowSN)->applyFromArray($style_row);
                    $numrowSN++;
                }
            } else {
                $sheet->setCellValue('G' . $numrowSN, "-");
                $numrowSN++;
            }


            $sheet->getStyle("A{$numrow}:A" . ($numrow + (empty($data->serialNumber) ? 1 : count($data->serialNumber)) - 1))->applyFromArray($style_row_marge);
            $sheet->getStyle("B{$numrow}:B" . ($numrow + (empty($data->serialNumber) ? 1 : count($data->serialNumber)) - 1))->applyFromArray($style_row_marge);
            $sheet->getStyle("C{$numrow}:C" . ($numrow + (empty($data->serialNumber) ? 1 : count($data->serialNumber)) - 1))->applyFromArray($style_row_marge);
            $sheet->getStyle("D{$numrow}:D" . ($numrow + (empty($data->serialNumber) ? 1 : count($data->serialNumber)) - 1))->applyFromArray($style_row_marge);
            $sheet->getStyle("E{$numrow}:E" . ($numrow + (empty($data->serialNumber) ? 1 : count($data->serialNumber)) - 1))->applyFromArray($style_row_marge);
            $sheet->getStyle("F{$numrow}:F" . ($numrow + (empty($data->serialNumber) ? 1 : count($data->serialNumber)) - 1))->applyFromArray($style_row_marge);
            $sheet->getStyle("G{$numrow}:G" . ($numrow + (empty($data->serialNumber) ? 1 : count($data->serialNumber)) - 1))->applyFromArray($style_row_marge);




            $no++;
            $numrow = $numrow + (empty($data->serialNumber) ? 1 : count($data->serialNumber));
        };

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(30);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet->setTitle("Laporan Pengeluaran Barang");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="myfile.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }



    public function destroy(BarangKeluar $barangKeluar)
    {
        $valid = BarangKeluar::destroy($barangKeluar->id);
        if ($valid) {
            $dataUpdate = [
                'category_id' => $barangKeluar->category_id,
                'keterangan' => "User " . Auth::user()->username . " Menghapus Barang ({$barangKeluar->device}) dari Table Pengeluaran Barang",
                'method' => "DELETE",
            ];

            if (Auth::user()->categories->pluck('id')[0] != 1) {
                $dataUpdate['keterangan'] = "User " . Auth::user()->username . " Menghapus Barang ({$barangKeluar->device_categories->name})  dari Table Pengeluaran Barang";
            }

            ActivityLog::create($dataUpdate);

            Storage::disk('local')->delete('public/ImagesBarangKeluar/' . $barangKeluar->gambar);
            return redirect(Route('barang-keluar.index'));
        }
    }

    public function undo(Request $request)
    {
        $barangKeluar = BarangKeluar::where('id', $request->data)->first();
	
        $valid = BarangKeluar::destroy($barangKeluar->id);
        if ($valid) {
            if ($request->command == "hapus") {
                $unitKelaur = $barangKeluar->unitKeluar;
                $barangMasuk = BarangMasuk::where('id', $barangKeluar->masuk_id)->first();
                $unit = $barangMasuk->unit;
                $dataHapus = [
                    'unit' => $unitKelaur + $unit,
                ];

                if (!empty($barangKeluar->serialNumber)) {
                    $dataHapus['serialNumber'] = array_merge($barangMasuk->serialNumber, $barangKeluar->serialNumber);
                }
                $barangMasuk->update($dataHapus);
            }
	
	   $dataUpdate = [
                'category_id' => $barangKeluar->category_id,
		'keterangan' =>  "User " . Auth::user()->username . " Menghapus Barang ({$barangKeluar->device_categories->name})  dari Table Pengeluaran Barang",
                'method' => "DELETE",
		'id_masuk' => $barangKeluar->masuk_id,
            ];

            if ($barangKeluar->device_id != 1) {
		$dataUPdate['keterangan'] =  "User " . Auth::user()->username . " Menghapus Barang ({$barangKeluar->device_categories->name})  dari Table Pengeluaran Barang {$barangKeluar->unitKeluar} Meter";
            } else {
		$dataUpdate['dataBaru'] = $barangKeluar->serialNumber;
	    }

            ActivityLog::create($dataUpdate);

            Storage::disk('local')->delete('public/ImagesBarangKeluar/' . $barangKeluar->gambar);
            return redirect(Route('barang-keluar.index'));
        }
    }

}
