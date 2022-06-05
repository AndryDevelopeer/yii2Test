<?php

    /** @var yii\web\View $this */
    /** @var yii\bootstrap4\ActiveForm $form */
    /** @var app\models\ContactForm $model */
    /** @var  $sections  */
    /** @var  $pagination  */

    use yii\bootstrap4\Html;
    use yii\widgets\LinkPager;

    $this->title = 'Products';
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <form action="">
        <input type="text" placeholder="ID">
        <input type="submit">
    </form>
</div>
    <br>

<ul>
    <?php foreach ($sections as $section): ?>
        <li>
            <?= Html::encode("{$section->id} {$section->name}") ?>
        </li>
    <?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>