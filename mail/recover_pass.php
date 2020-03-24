<?
use yii\helpers\Url;

$link = Url::to(['create-new-pass', 'secret' => $secret], true);
?>
<h1>Восстановление пароля</h1>
<hr />
Для восстановления пароля необходимо пройти по ссылке ниже.
<br />
<a href="<?= $link ?>" target="_blank"><?= $link ?></a>