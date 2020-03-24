<?
use yii\helpers\Url;
use yii\helpers\MyCustom;
?>
<div id="screen-my-pokypki">
	<div class="container">
		<div class="row">
			<div class="col-sm-9">
				<br />
				<h3 class="text-uppercase">Мои покупки</h3>
				<br />
				<? if(!empty($products)): ?>
					<? foreach($products as $product): ?>
						<div class="thumbnail thumbnail-sm">
							<a class="thumbnail-cover" href="/<?= $product->slug ?>">
								<? if(!empty($product->imageFiles[0])): ?>
									<img src="/uploads/<?= $product->imageFiles[0]->name; ?>" />
								<? else: ?>
									<img src="/img/cover_empty.jpg" />
								<? endif; ?>
							</a>
							<div class="caption">
								<div class="thumbnail-title"><?= $product->name ?></div>
								<div class="thumbnail-price"><?= MyCustom::htmlPrice($product->price) ?> руб.</div>
								<div class="thumbnail-btn">
									<span class="h3">КУПЛЕНО!</span>
								</div>
							</div>
						</div>
					<? endforeach; ?>
				
				<? else: ?>
					<div class="text-center text-muted"><font size="+1">пока нет ни одной покупки</font></div>
				<? endif; ?>
				<br />
				<br />
				<center>
					<a class="a-vinous" href="<?= Url::to(['/site/catalog']) ?>">
						<font size="+1">Перейти в каталог товаров</font>
					</a>
				</center>
				<br />
			</div>
			<div class="col-sm-3 text-center">
				<br />
				<br />
				<br />
				<? include(__DIR__.'/sidebar.php'); ?>
			</div>
		</div>
	</div>
</div>