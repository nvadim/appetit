<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
if (method_exists($this, 'setFrameMode')) {
	$this->setFrameMode(true);
}
?>
	<div class="call_back_popup cb_start" style="display:none;">
    	<span class="close"></span>
    	<div class="title"><?=GetMessage("CALLBACK_TITLE");?></div>
        <form>
        	<div class="ln"><span><?=GetMessage("CALLBACK_NAME");?>:</span><input type="text" class="callback_name" value="" placeholder=""></div>
        	<div class="ln"><span><?=GetMessage("CALLBACK_PHONE");?>:</span><input type="text" maxlength="16" class="callback_phone phone" value="" placeholder="+7 ___ ___ __ __"></div>
        	<div class="ln"><span></span><input type="submit" class="callback_order" value="<?=GetMessage("CALLBACK_BUTTON");?>"></div>
        </form>	
    </div><!-- .call_back_popup -->
    <div class="call_back_popup callback_success cb_ok" style="display:none;">
    	<span class="close"></span>
    	<div class="inner">
            <div class="title_success"><?=GetMessage("CALLBACK_SUCCESS_TITLE");?></div>
            <p class="desc"><?=GetMessage("CALLBACK_SUCCESS_DESC");?></p>
        </div>
    </div>