<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php if(!empty($arResult['SOCIAL'])): ?>
	<?php foreach ($arResult['SOCIAL'] as $soc): ?>
		<a href="<?=$soc['url'];?>" class="sprite sprite-social_<?=$soc['class']?>" target="_blank"></a>
	<?php endforeach; ?>
<?php endif; ?>