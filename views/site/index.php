<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LinkForm $model */
/** @var string|null $shortLink */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Сократитель ссылок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-shortifier">

    <?php $form = ActiveForm::begin(['id' => 'shortifier-form']); ?>

        <?= $form->field($model, 'link')->textInput(['autofocus' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Сократить', ['class' => 'btn btn-primary', 'name' => 'shortifier-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>

    <?php if ($shortLink) { ?>
        <div class="alert alert-success mt-5">Сокращенная ссылка: <a href="<?= $shortLink ?>" target="_blank"><?= $shortLink ?></a></div>
    <?php } ?>

</div>
