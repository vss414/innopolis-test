<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// http://demos.krajee.com/widget-details/select2
/* @var $this yii\web\View */
/* @var $model app\models\Resume */
/* @var $form yii\widgets\ActiveForm */
/* @var $competences array */
?>

<div class="resume-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'competences')->widget(\kartik\select2\Select2::classname(), [
        'data' => $competences,
        'options' => ['placeholder' => 'Select a competences...'],
        'pluginOptions' => [
            'tags' => true,
            'allowClear' => true,
            'multiple' => true,
            'showToggleAll' => false,
            'maximumSelectionLength' => 5
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
