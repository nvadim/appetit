<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if(count($arResult['SLIDES'])>0):
?>

	<div class="slider-container">
	<div class="spinner"></div>
	     <div class="bd-slider carousel">
		     <?php foreach($arResult['SLIDES'] as $slide): ?>
			    <?php $img = \CFile::GetFileArray($slide['DETAIL_PICTURE']); ?>
			    <?php if(!empty($slide['DETAIL_PICTURE'])): ?>
			    <div class="carousel-cell">
				    <?php if(!empty($slide['PROPERTY_URL_VALUE'])): ?>
				        <a href="<?=$slide['PROPERTY_URL_VALUE']?>"><img src="<?php echo $img['SRC']; ?>"></a>
				    <?php else: ?>
					    <img src="<?php echo $img['SRC']; ?>">
				    <?php endif; ?>
				 </div>
			    	<?php endif; ?>
			 <?php endforeach; ?>
          
        </div>
	</div>
<?php endif; ?>