<?
use yii\helpers\MyCustom;
?>
<div class="thumbnail">
	<a class="thumbnail-cover" href="/<?= $item->slug ?>">
		<? if(!empty($item->is_sale)): ?>
			<div class="circle-gradient">акция</div>
		<? endif; ?>
		
		<? if(!empty($item->imageFiles[0])): ?>
			<img src="/uploads/thumb_<?= $item->imageFiles[0]->name ?>" />
		<? else: ?>
			<img src="/img/cover_empty.jpg" />
		<? endif; ?>
	</a>
	<div class="caption">
		<div class="thumbnail-title"><?= $item->name ?></div>
		<div class="thumbnail-price"><?= MyCustom::htmlPrice($item->price) ?> руб.</div>
		<div class="thumbnail-btn">
			<? if(!empty($item->is_sale) && !Yii::$app->session->has('user')): ?>
				<button class="btn btn-darkblue" data-toggle="modal" data-target="#pop-up-participate">
					Купить <?= !empty($item->is_sale)? 'по акции': '' ?>
				</button>
			
			<? else: ?>
				<button class="btn btn-darkblue" onclick="addToCart(this, <?= $item->id ?>)">
					Купить <?= !empty($item->is_sale)? 'по акции': '' ?>
				</button>
			<? endif; ?>
		</div>
	</div>
</div>
						