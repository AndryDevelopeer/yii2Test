<?php


    namespace app\controllers;

    use app\models\SectionForm;
    use Yii;
    use yii\web\Controller;
    use yii\helpers\Html;

    class CatalogController extends Controller
    {
        public function actionProducts()
        {
            $form = new SectionForm();

            if ($form->load(Yii::$app->request->post())) {
                if ($form->validate()) {
                    $id = Html::encode($form->id);
                    $products = ProductController::getProductsByIdSection($id);
                    $table = new SpreadsheetController();
                    $filePath = $table->writeFile($products);
                    if ($filePath)
                        return Yii::$app->response->sendFile($filePath);
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