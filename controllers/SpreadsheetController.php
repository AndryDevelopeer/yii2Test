<?php


    namespace app\controllers;

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use Yii;
    use PhpOffice\PhpSpreadsheet\Style\{Font, Border, Alignment};
    use yii\base\ErrorException;

    class SpreadsheetController
    {
        const LETTERS = [
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I',
            'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
            'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
        ];

        const BORDERS = [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color'       => ['rgb' => '666'],
            ],
        ];

        public function writeFile(array $prodData): string
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
                    $sheet->setCellValue(self::LETTERS[$key] . '1', $value);
                    $sheet->getStyle(self::LETTERS[$key] . '1')->applyFromArray([
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
                        'borders'   => self::BORDERS,
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
                    $arRes2 = self::customMultiSort($arRes, 'name');
                    $borderStyleArray = [
                        'font'    => [
                            'name'  => 'Roboto',
                            'size'  => 12,
                            'bold'  => false,
                            'color' => ['rgb' => '666'],
                        ],
                        'borders' => self::BORDERS,
                    ];
                    $coordinate = 'A2:' . self::LETTERS[count($headers) - 1] . (count($arRes) + count($arRes2) + 2);
                    $sheet
                        ->getStyle($coordinate)
                        ->applyFromArray($borderStyleArray);

                    $spreadsheet
                        ->getActiveSheet()
                        ->fromArray($arRes, NULL, 'A2');
                    $spreadsheet
                        ->getActiveSheet()
                        ->fromArray($arRes2, NULL, 'A' . (count($arRes) + 3));
                }

                $writer = new Xlsx($spreadsheet);
                $filePath = Yii::getAlias('@app') . "/upload/exel/" . time() . "_table.xlsx";
                $writer->save($filePath);
                return $filePath;
            } catch (ErrorException $e) {
                return $e->getMessage();
            }
        }

        private function customMultiSort(array $array, string $field): array
        {
            $sortArr = [];
            foreach ($array as $key => $val) {
                $sortArr[$key] = $val[$field];
            }
            array_multisort($sortArr, $array);

            return $array;
        }
    }