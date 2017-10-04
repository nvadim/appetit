<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

?>
<script type="text/javascript">
  <?php foreach($arResult["GIFT_BOX"] as $key=>$gb): ?>
    window.limit<?php echo $key+1; ?> = <?php echo intval($gb['ORDER_FROM']); ?>;
  <?php endforeach; ?>
  <?php
    $percent = $_SESSION['BASKET_SUM']/$arResult["GIFT_BOX"][2]['ORDER_FROM']*100;
    $isActive = ($_SESSION['BASKET_SUM']>$arResult["GIFT_BOX"][0]['ORDER_FROM']);
  ?>
</script>