<?php

namespace app\helpers;

use PhpOffice\PhpSpreadsheet\Style\{Border, Alignment};
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\base\ErrorException;

class SpreadsheetHelper
{
    public string $error = '';

    private array $letters = [
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I',
        'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
        'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
    ];

    private array $borders = [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color'       => ['rgb' => '666'],
        ],
    ];

    public function write(array $prodData, string $filePath): void
    {
        try {
            $headers = ['id', 'group_id', 'name', 'marking', 'rating'];
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $arRes = [];

            foreach (range('A', 'Z') as $columnID) {
                $sheet
                    ->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }
            foreach ($headers as $key => $value) {
                $sheet->setCellValue($this->letters[$key] . '1', $value);
                $sheet->getStyle($this->letters[$key] . '1')->applyFromArray([
                    'font'      => [
                        'name'  => 'Roboto',
                        'size'  => 14,
                        'bold'  => false,
                        'color' => ['rgb' => '666'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'borders'   => $this->borders,
                ]);
            }
            if (!empty($prodData)) {
                foreach ($prodData as $data) {
                    $arRes[] = [
                        'id'       => $data->id,
                        'group_id' => $data->group_id,
                        'name'     => $data->name,
                        'marking'  => $data->marking,
                        'rating'   => $data->rating,
                    ];
                }
                $borderStyleArray = [
                    'font'    => [
                        'name'  => 'Roboto',
                        'size'  => 12,
                        'bold'  => false,
                        'color' => ['rgb' => '666'],
                    ],
                    'borders' => $this->borders,
                ];
                $coordinate = 'A2:' . $this->letters[count($headers) - 1] . (count($arRes) + 1);
                $sheet
                    ->getStyle($coordinate)
                    ->applyFromArray($borderStyleArray);

                $spreadsheet
                    ->getActiveSheet()
                    ->fromArray($arRes, NULL, 'A2');
            }
            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);
        } catch (ErrorException $e) {
            $this->error = $e->getMessage();
        }
    }
}
