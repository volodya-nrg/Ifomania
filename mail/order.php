<?
use yii\helpers\Url;
use yii\helpers\MyCustom;

use app\models\Products;
use app\models\Images;

$products = [];
foreach(explode('|', $Order->products) as $val){
	list($product_id, $amount) = explode(":", $val);
	
	$objProduct = Products::findOne((int)$product_id);
	$objProduct->imageFiles = Images::find()->where(['product_id' => $objProduct->id])
											->orderBy('pos DESC')
											->all();
	$products[] = ['data' => $objProduct, 'total' => (int)$amount];
}
?> 
<h1>Заказ № <?= $Order->id ?></h1>
<hr />
E-mail: <?= $Order->email ?><br />
Номер телефона: <?= $Order->tel ?><br />
ФИО: <?= $Order->fio ?><br />
Город: <?= $Order->city ?><br />
Доставка: <?= $Order->delivery ?><br />
Адрес: <?= $Order->address ?><br />
Оплата: <?= $Order->payment ?><br />
Комментарий: <?= $Order->comment ?><br />
Время заказа: <?= date("Y.m.d H:i:s") ?><br />

<? if(!empty($Order->is_paid)): ?>
	Статус: ОПЛАЧЕН
	
<? else: ?>
	Статус: НЕ ОПЛАЧЕН
	<br />
	<center>
		<form action="https://demomoney.yandex.ru/eshop.xml" method="POST">
			<input name="shopId" value="<?= Yii::$app->params['shopId'] ?>" type="hidden">
			<input name="scid" value="<?= Yii::$app->params['scid'] ?>" type="hidden">
			<input name="customerNumber" value="<?= $Order->email ?>" type="hidden">
			<input name="sum" value="<?= $Order->total_sum ?>" type="hidden">
			<input name="orderNumber" value="<?= $Order->id ?>" type="hidden">
			<input type="submit" value="Оплатить">
		</form>
	</center>
<? endif; ?>
	
<br />
<br />
<?
	$style_border = 'style="border: whitesmoke solid 1px"';
?>
<table border="0" cellspacing="0" cellpadding="5" <?= $style_border ?> width="100%">
	<thead>
		<tr>
			<th <?= $style_border ?>>
				Фото
			</th>
			<th <?= $style_border ?>>
				Название
			</th>
			<th <?= $style_border ?>>
				Цена за 1 шт.
			</th>
			<th <?= $style_border ?>>
				Кол-во
			</th>
			<th <?= $style_border ?>>
				Сумма
			</th>
		</tr>
	</thead>	
	<? foreach($products as $product): ?>
		<tr style="border-bottom: lightgray solid 1px">
			<td align="center" valign="middle" <?= $style_border ?>>
				<? if(!empty($product['data']->imageFiles[0])): ?>
					<img height="30" 
						 src="<?= Url::to('/uploads/thumb_'.$product['data']->imageFiles[0]->name, true) ?>" />
				
				<? else: ?>
					<img height="30" src="<?= Url::to('/img/cover_empty.jpg', true) ?>" />
				<? endif; ?>
			</td>
			<td align="left" valign="middle" <?= $style_border ?>>
				<a href="<?= Url::to('/'.$product['data']->slug, true) ?>" target="_blank">
					<?= $product['data']->name ?>
				</a>	
			</td>
			<td align="center" valign="middle" <?= $style_border ?>>
				<?= MyCustom::htmlPrice($product['data']->price) ?> руб.
			</td>
			<td align="center" valign="middle" <?= $style_border ?>>
				<?= $product['total'] ?> шт.
			</td>
			<td align="center" valign="middle" <?= $style_border ?>>
				<?= MyCustom::htmlPrice($product['data']->price * $product['total']) ?> руб.
			</td>
		</tr>
	<? endforeach; ?>
	<tfoot>
		<tr>
			<td align="right" colspan="5" <?= $style_border ?>>
				<br />
				<strong>Общая сумма: <font size="+1"><?= MyCustom::htmlPrice($Order->total_sum) ?></font> руб.</strong>
				<br />
				<br />
			</td>
		</tr>
	</tfoot>	
</table>