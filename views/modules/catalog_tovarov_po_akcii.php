<div id="screen-catalog-tovarov-po-akcii">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<br />
				<h2 class="text-center text-uppercase">Каталог товаров по ации</h2>
				<br />
				<p class="text-center text-muted">
					<i>We currently hold one of the most innovative and modern product lines in the world. Trading for 10 years we have grown within the market, to bring the newest products available. All of our products are printed with a “QR Code” on the box, bling us to ensure all logistic needs are met.</i>
				</p>
				<br />
				<br />
				<div align="center">
					<? if(!empty($products_sale)): ?>
						<? foreach($products_sale as $val): ?>
							<?= $this->render('@app/views/modules/thumbnail_item', ['item'=>$val]); ?>
						<? endforeach; ?>
					<? endif; ?>
				</div>
				<br />
			</div>
		</div>	
	</div>
</div>