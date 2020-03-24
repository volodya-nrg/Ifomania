<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$session = Yii::$app->session;
?>
<br />
<a href="<?= Url::to('/admin/pages') ?>">назад</a>
<hr />
<? if($session->hasFlash('error')): ?>
	<div class="alert alert-danger">
		<ul>
			<? foreach($session->getFlash('error') as $val): ?>
				<li><?= $val ?></li>
			<? endforeach; ?>
		</ul>
	</div>
<? endif; ?>
<?
$form = ActiveForm::begin([
    'id' => 'form-product',
    'options' => ['class' => 'form-horizontal'],
	'fieldConfig' => [
		'template' => "<div class=\"col-sm-3\">{label}</div><div class=\"col-sm-9\">{input}</div><div class=\"col-sm-9 col-sm-offset-3\">{error}</div>",
		'labelOptions' => ['class' => ''],
	],
]);
?>
	<? if(!empty($model->id)): ?>
		<?= $form->field($model, 'slug')->textInput(['readonly' => true]) ?>
	<? endif; ?>

	<?= $form->field($model, 'title') ?>
	<?= $form->field($model, 'h1') ?>
	<?= $form->field($model, 'text')->textArea(['rows'=> 1, 'class'=>'ckeditor']) ?>
	<?= $form->field($model, 'meta_keywords') ?>
	<?= $form->field($model, 'meta_desc') ?>

	<div class="form-group">
        <div class="col-xs-9 col-xs-offset-3">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
			
			<? if($model->id): ?>
				<?= Html::button('Удалить', [
					'class' => 'btn btn-danger pull-right',
					'onclick' => 'deletePage('.$model->id.')'
				]) ?>
			<? endif; ?>
        </div>
    </div>
<?php ActiveForm::end() ?>