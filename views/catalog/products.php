<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $f */

/** @var app\models\ContactForm $form */

use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="site-contact">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="form-group">
            <?php $f = ActiveForm::begin() ?>
            <?= $f->field($form, 'id') ?>
            <?= Html::submitButton('Скачать', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
