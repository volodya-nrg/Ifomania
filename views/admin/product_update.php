<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<br />
<a href="<?= Url::to('/admin/products') ?>">назад</a>
<br />
<? if(!empty($model->id)): ?>
	<h3><?= $model->name ?></h3>
<? else: ?>
	<h3>Новый товар</h3>
<? endif; ?>
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
	<?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Фото:') ?>
	
	<? if(!empty($aOldImages) && is_array($aOldImages) && sizeof($aOldImages)): ?>
		<div class="form-group">
			<div class="col-xs-9 col-xs-offset-3">
				<? foreach($aOldImages as $val): ?>
					<div class="img-wrapper pull-left">
						<div class="img-wrapper-remove" onclick="deleteProductImage(this, <?= $val['product_id'] ?>, '<?= $val['name'] ?>')" title="удалить"><i class="fa fa-close fa-fw"></i></div>
						<img src="/uploads/thumb_sm_<?= $val['name'] ?>" />
					</div>
				<? endforeach; ?>
			</div>
		</div>
	<? endif; ?>
    
	<? if(!empty($model->id)): ?>
		<?= $form->field($model, 'slug')->textInput(['readonly' => true]) ?>
	<? endif; ?>
	
	<?= $form->field($model, 'title') ?>
    <?= $form->field($model, 'name') ?>
	<?= $form->field($model, 'price') ?>
	<?= $form->field($model, 'desc_small')->textArea(['rows' => '1', 'class'=>'ckeditor']) ?>
	<?= $form->field($model, 'description')->textArea(['rows' => '1', 'class'=>'ckeditor']) ?>
	<?= $form->field($model, 'meta_key') ?>
	<?= $form->field($model, 'meta_desc')->textArea(['rows' => '3']) ?>
	<?= $form->field($model, 'is_sale')->radioList([0=>'Нет', 1=>'Да']) ?>
	<?= $form->field($model, 'is_hide')->radioList([0=>'Нет', 1=>'Да']) ?>

	<div class="form-group">
        <div class="col-xs-9 col-xs-offset-3">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
			
			<? if($model->id): ?>
				<?= Html::button('Удалить', [
					'class' => 'btn btn-danger pull-right',
					'onclick' => 'deleteProduct('.$model->id.')'
				]) ?>
			<? endif; ?>
        </div>
    </div>
<?php ActiveForm::end() ?>