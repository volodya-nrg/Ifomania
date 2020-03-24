<?
use yii\helpers\MyCustom;
?>
<div id="screen-tovar-akciya">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<br />
				<h2 class="text-uppercase"><?= $product->name ?></h2>
				<br />
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<table id="tovar-akciya-tbl" cellspacing="0" cellpadding="0">
					<tr>
						<td align="left" valign="top">
							<div class="img-wrapper">
								<? if(!empty($product->is_sale)): ?>
									<div class="circle-gradient">акция</div>
								<? endif; ?>
								
								<? if(!empty($product->imageFiles[0])): ?>
									<a class="fancybox" rel="group1" href="/uploads/<?= $product->imageFiles[0]->name ?>">
										<img src="/uploads/thumb_<?= $product->imageFiles[0]->name ?>" />
									</a>
								<? else: ?>
									<img src="/img/cover_empty.jpg" />
								<? endif; ?>
							</div>
						</td>
						<td width="10"></td>
						<td align="left" valign="top" width="100">
							<? if(!empty($product->imageFiles) && sizeof($product->imageFiles) > 1): ?>
								<? foreach($product->imageFiles as $key => $val): ?>
									<? if(!$key) continue; ?>
									<div class="img-wrapper img-wrapper-sm">
										<a class="fancybox" rel="group1" href="/uploads/<?= $val->name ?>">
											<img src="/uploads/thumb_sm_<?= $val->name ?>" />
										</a>
									</div>
								<? endforeach; ?>
							<? endif; ?>
						</td>
					</tr>
				</table>
			</div>
			<div class="col-md-4">
				<p class="visible-xs visible-sm">&nbsp;</p>
				<?= $product->desc_small ?>
				<p class="visible-xs visible-sm">&nbsp;</p>
			</div>
			<div class="col-md-4 text-center">
				<? if(!empty($product->is_sale)): ?>
					<font class="text-pink text-bold text-uppercase" size="+2"><?= MyCustom::htmlPrice($product->price) ?> руб.</font> 
					<div class="circle-gradient circle-gradient-sm">акция</div>
					<br />
					<br />
					<br />
					<? if(!Yii::$app->session->has('user')): ?>
						<button class="btn btn-darkblue btn-lg" data-toggle="modal" data-target="#pop-up-participate">Купить по ации</button>
					<? else: ?>
						
						<button class="btn btn-darkblue btn-lg" onclick="addToCart(this, <?= $product->id ?>)">Купить по ации</button>
					<? endif; ?>
				<? else: ?>
					<font class="text-vinous text-bold text-uppercase" size="+2"><?= MyCustom::htmlPrice($product->price) ?> руб.</font>
					<br />
					<br />
					<br />
					<button class="btn btn-darkblue btn-lg" onclick="addToCart(this, <?= $product->id ?>)">&nbsp;&nbsp;&nbsp;Купить&nbsp;&nbsp;&nbsp;</button>
				<? endif; ?>
			</div>
		</div>
		<? if(!empty($product->description)): ?>
			<br />
			<div class="row">
				<div class="col-xs-12">
					<div class="h3 text-uppercase">Описание</div>
					<?= $product->description ?>
				</div>
			</div>
		<? endif; ?>
		<br />
		<br />
	</div>
</div>