<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Lookup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-lg-5">
        <div class="lookup-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'type')->textInput(['maxlength' => 100]) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => 100]) ?>

            <?= $form->field($model, 'code')->textInput() ?>

            <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

            <?php if ($model->isNewRecord) $model->active='1'; ?>
            
            <?= $form->field($model, 'active')->dropDownList(
                ['1'=>'Yes', '2' => 'No'],
                ['prompt'=>'--- Select ---'] 
            ) ?>

            <?= $form->field($model, 'sort_order')->textInput() ?>

<?php /*
            <?= $form->field($model, 'created_at')->textInput() ?>

            <?= $form->field($model, 'created_by')->textInput() ?>

            <?= $form->field($model, 'updated_by')->textInput() ?>

            <?= $form->field($model, 'updated_at')->textInput() ?>
*/ ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>


<?php
$script = <<< JS
    
    // incident location
    $("#lookup-code").bind("blur", function() {
        var code = $(this).val() || 0;
        $('#lookup-sort_order').val(code);

    });

JS;
$this->registerJs($script);

?>