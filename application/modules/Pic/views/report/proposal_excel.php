<?php
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
date_default_timezone_set("Asia/Jakarta");

$excel = new PHPExcel();

$excel
    ->getProperties()
    ->setCreator('Pandurasa Kharisma')
    ->setLastModifiedBy('Pandurasa Kharisma')
    ->setTitle('Proposal Report')
    ->setSubject('Proposal Report')
    ->setDescription('Proposal Report')
    ->setKeywords('Proposal Report');

$style_col = [
    'font' => ['bold' => true], // Set font nya jadi bold
    'alignment' => [
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
    ],
    'borders' => [
        'top' => ['style' => PHPExcel_Style_Border::BORDER_THIN], // Set border top dengan garis tipis
        'right' => ['style' => PHPExcel_Style_Border::BORDER_THIN], // Set border right dengan garis tipis
        'bottom' => ['style' => PHPExcel_Style_Border::BORDER_THIN], // Set border bottom dengan garis tipis
        'left' => ['style' => PHPExcel_Style_Border::BORDER_THIN], // Set border left dengan garis tipis
    ],
];

$style_row = [
    'alignment' => [
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
    ],
    'borders' => [
        'top' => ['style' => PHPExcel_Style_Border::BORDER_THIN], // Set border top dengan garis tipis
        'right' => ['style' => PHPExcel_Style_Border::BORDER_THIN], // Set border right dengan garis tipis
        'bottom' => ['style' => PHPExcel_Style_Border::BORDER_THIN], // Set border bottom dengan garis tipis
        'left' => ['style' => PHPExcel_Style_Border::BORDER_THIN], // Set border left dengan garis tipis
    ],
];

// $excel->setActiveSheetIndex(0)->setCellValue('A1', 'Report A&P');
// $excel->getActiveSheet()->mergeCells('A1:F1');

// $excel->setActiveSheetIndex(0)->setCellValue('A2', 'Tanggal : ' . '');
// $excel->getActiveSheet()->mergeCells('A2:F2');


$excel->setActiveSheetIndex(0)->setCellValue('A1', "NO");
$excel->setActiveSheetIndex(0)->setCellValue('B1', "NO PROPOSAL");
$excel->setActiveSheetIndex(0)->setCellValue('C1', "REF CODE");
$excel->setActiveSheetIndex(0)->setCellValue('D1', "BRAND");
$excel->setActiveSheetIndex(0)->setCellValue('E1', "ACTIVITY");
$excel->setActiveSheetIndex(0)->setCellValue('F1', "START PERIODE");
$excel->setActiveSheetIndex(0)->setCellValue('G1', "END PERIODE");
$excel->setActiveSheetIndex(0)->setCellValue('H1', "COSTING");
$excel->setActiveSheetIndex(0)->setCellValue('I1', "OBJECTIVE");
$excel->setActiveSheetIndex(0)->setCellValue('J1', "MECHANISM");
$excel->setActiveSheetIndex(0)->setCellValue('K1', "COMMENT");


$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('I1')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('J1')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('K1')->applyFromArray($style_col);



$no = 1;
$numrow = 2;
foreach ($proposal->result() as $data) {


    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
    $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->Number);
    $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->NoRef);
    $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->BrandName);
    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->promo_name);
    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->StartPeriode);
    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->EndPeriode);
    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->TotalCosting);
    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->Objective);
    $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->Mechanism);
    $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->Comment);


    $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);


    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);

    $no++; // Tambah 1 setiap kali looping
    $numrow++; // Tambah 1 setiap kali looping
}

// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
// Set orientasi kertas jadi LANDSCAPE
$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
// Set judul file excel nya
$excel->getActiveSheet(0)->setTitle("A&P REPORT");
$excel->setActiveSheetIndex(0);
// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Proposal Report.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');
$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$write->save('php://output');
