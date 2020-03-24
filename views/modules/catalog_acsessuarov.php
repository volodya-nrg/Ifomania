<?
use yii\helpers\Url;
?>
<div id="screen-catalog-acsessuarov">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<br />
				<div class="h2 text-center text-uppercase">Каталог аксессуаров</div>
				<br />
				<p class="text-center text-muted">
					<i>We currently hold one of the most innovative and modern product lines in the world. Trading for 10 years we have grown within the market, to bring the newest products available. All of our products are printed with a “QR Code” on the box, bling us to ensure all logistic needs are met.</i>
				</p>
				<br />
				<br />
				<div align="center">
					<? if(!empty($products)): ?>
						<? foreach($products as $val): ?>
							<?= $this->render('@app/views/modules/thumbnail_item', ['item'=>$val]); ?>
						<? endforeach; ?>
					<? endif; ?>
				</div>
				<br />
				<div id="screen-catalog-acsessuarov-show-all" class="text-center">
					<a class="a-vinous" href="<?= Url::to(['/site/catalog']) ?>"><font size="+1">Просмотреть весь каталог</font></a>
					<br />
					<br />
				</div>
			</div>	
		</div>
	</div>
</div>