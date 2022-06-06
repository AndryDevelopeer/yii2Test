<?php

namespace app\commands;

use app\helpers\DownloadHelper;
use app\helpers\ProductHelper;
use app\helpers\SpreadsheetHelper;
use yii\base\ErrorException;
use yii\console\Controller;
use yii\console\ExitCode;

class DownloadController extends Controller
{
    /**
     * @param int $id catalog section ID.
     * @return int Exit code
     */
    public function actionIndex(int $id): int
    {
        try {
            $filePath = (new DownloadHelper())->getFilePath();
            $table = new SpreadsheetHelper();
            $product = new ProductHelper();
            $table->write($product->getProductsBySectionId($id), $filePath);

            if ($table->error === '') {
                echo 'Файл сохранен ' . $filePath . "\n";
            } else {
                echo 'error: ' . $table->error . "\n";
            }
        } catch (ErrorException $e) {
            echo 'error: ' . $e->getMessage() . "\n";
        }
        return ExitCode::OK;
    }
}
