<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<br />
<a href="<?= Url::to('/admin/comments') ?>">назад</a>
<hr />
<?
$form = ActiveForm::begin([
    'id' => 'form-product',
    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
	'fieldConfig' => [
		'template' => "<div class=\"col-sm-3\">{label}</div><div class=\"col-sm-9\">{input}</div><div class=\"col-sm-9 col-sm-offset-3\">{error}</div>",
		'labelOptions' => ['class' => ''],
	],
]);
?>
	<?= $form->field($model, 'avatar')->fileInput(['multiple' => false, 'accept' => 'image/*']) ?>
	
	<? if(!empty($model->avatar)): ?>
		<div class="form-group">
			<div class="col-xs-9 col-xs-offset-3">
				<div class="img-wrapper pull-left">
					<img src="/uploads/<?= $model->avatar ?>" />
				</div>
			</div>
			<?= $form->field($model, 'avatar')->hiddenInput(['value'=> $model->avatar])->label(false); ?>
		</div>
	<? endif; ?>

	<?= $form->field($model, 'fio') ?>
	<?= $form->field($model, 'text')->textArea(['rows'=> 6]) ?>
	<?= $form->field($model, 'is_hide')->radioList([0=>'Нет', 1=>'Да']) ?>

	<div class="form-group">
        <div class="col-xs-9 col-xs-offset-3">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
			
			<? if($model->id): ?>
				<?= Html::button('Удалить', [
					'class' => 'btn btn-danger pull-right',
					'onclick' => 'deleteComment('.$model->id.')'
				]) ?>
			<? endif; ?>
        </div>
    </div>
<?php ActiveForm::end() ?>