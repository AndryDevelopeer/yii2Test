<?php

namespace app\controllers;

use app\helpers\DownloadHelper;
use app\helpers\ProductHelper;
use app\helpers\SpreadsheetHelper;
use app\models\SectionForm;
use yii\web\Controller;
use yii\helpers\Html;
use Yii;

class CatalogController extends Controller
{
    public function actionProducts()
    {
        $form = new SectionForm();

        if ($form->load(Yii::$app->request->post())) {
            if ($form->validate()) {
                $id = Html::encode($form->id);
                $product = new ProductHelper();
                $table = new SpreadsheetHelper();
                $filePath = (new DownloadHelper())->getFilePath();
                $table->write($product->getProductsBySectionId($id), $filePath);
                if ($table->error === '') {
                    return Yii::$app->response->sendFile($filePath);
                } else {
                    Yii::$app->session->setFlash('error', $table->error);
                }
            } else {
                Yii::$app->session->setFlash('success', 'не верно указан ID раздела');
            }
        } else {
            $form->id = 0;
        }
        return $this->render('products', [
            'form' => $form,
        ]);
    }
}
