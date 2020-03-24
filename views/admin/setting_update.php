<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<br />
<a href="<?= Url::to('/admin/settings') ?>">назад</a>
<br />
<h3><?= $model->keyword ?></h3>
<hr />
<?
$form = ActiveForm::begin([
    'id' => 'form-setting',
    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
	'fieldConfig' => [
		'template' => "<div class=\"col-sm-3\">{label}</div><div class=\"col-sm-9\">{input}</div><div class=\"col-sm-9 col-sm-offset-3\">{error}</div>",
		'labelOptions' => ['class' => ''],
	],
]);
?>
	<?= $form->field($model, 'value') ?>
    
	<div class="form-group">
        <div class="col-xs-9 col-xs-offset-3">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
	    </div>
    </div>
<?php ActiveForm::end() ?>