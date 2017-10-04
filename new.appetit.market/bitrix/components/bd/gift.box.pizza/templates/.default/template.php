<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
if (method_exists($this, 'setFrameMode')) {
	$this->setFrameMode(true);
}
?>
<div class="poplavok">
    <div class="podarki_box podarki_close" style="display:block;">
        <span class="open"><i><?=GetMessage("GIFTS");?></i></span>
        <div class="shkala">
            <div class="obertka"><div class="delenija"></div></div>
        </div>
    </div><!-- .podarki_close -->
    <div class="podarki_box podarki_open" style="display:none;">
        <span class="close"></span>
        <div class="bd">
            <div class="title"><?=GetMessage("GET_GIFT");?></div>
            <p class="opis"><?=GetMessage("GET_GIFT_DESC1");?> <?=$arResult["GIFT_BOX"][2]['OT_GIFT']?> <i class="rouble">i</i> <?=GetMessage("GET_GIFT_DESC2");?></p>
            <div class="intr">
                <div class="shkala">
                    <div class="obertka"><div class="delenija"></div></div>
                </div>
                
                <div class="pandochki" id="pandochki-cs">
                	<?php $frame = $this->createFrame("pandochki-cs", false)->begin(); ?>
                    <?foreach ($arResult["GIFT_BOX"] as $GIFT):?>
                    <div class="free_panda <?=$GIFT['TECH_GIFT']?>">
                        <div class="for_pod"> > <?=$GIFT['OT_GIFT']?> <i class="rouble">i</i></div>
                        <a href="/menu/gifts/" class="zabr"><?=GetMessage("GIFT_BUTTON");?></a>
                    </div>
                    <?endforeach;?>
                    <?php $frame->end(); ?>
                </div> 
            </div> 
        </div>  
    </div><!-- .podarki_open -->        
</div>    