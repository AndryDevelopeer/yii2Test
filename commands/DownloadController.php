<?php

    namespace app\commands;

    use app\controllers\ProductController;
    use app\controllers\SpreadsheetController;
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
                $products = ProductController::getProductsByIdSection($id);
                $table = new SpreadsheetController();
                $path = $table->writeFile($products);
                echo 'Файл сохранен ' . $path . "\n";
            } catch (ErrorException $e) {
                echo $e->getMessage();
            }
            return ExitCode::OK;
        }
    }
