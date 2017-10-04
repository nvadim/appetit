<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
if (method_exists($this, 'setFrameMode')) {
	$this->setFrameMode(false);
}
?>
<script type="text/javascript">
	window.gift_level_1 = <?=$arResult["GIFT_BOX"][2]["OT_GIFT"]?>;
	window.gift_level_2 = <?=$arResult["GIFT_BOX"][1]["OT_GIFT"]?>;
	window.gift_level_3 = <?=$arResult["GIFT_BOX"][0]["OT_GIFT"]?>;
	window.yaCounterId = <?=$arParams['YACOUNTER']?>;
</script>