<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $USER;
?>
<?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_BONUSES_ENABLED','',SITE_ID) == 'Y'): ?>
<div id="bonuses-info" class="bd-popup">
	<div class="col-xs-4">
		<img src="<?php echo SITE_TEMPLATE_PATH; ?>/images/bonuses-popover-icon.png" alt="">
	</div>
	<div class="col-xs-8">
		<div class="title"><?= GetMessage("promo_get_bonuses_title"); ?></div>
		<div class="description"><?= GetMessage("promo_get_bonuses_text"); ?></div>
	</div> 
</div>
<?php endif; ?>
<div id="auth" class="bd-popup <?php if($USER->IsAuthorized()): ?>is_auth<?php endif; ?>">
	<?php if (!$USER->IsAuthorized()): ?>
		<?php $mode = COption::GetOptionString('bd.deliverypizza', 'BD_CF_AUTH_TYPE','',SITE_ID); ?>
		<?php if ($mode == 'email'): ?>
			<div class="auth-tabs">
				<ul>
					<li class="active"><a  data-target="sign-in-email-state" href="#"><?= GetMessage("AUTH_LOGIN_BUTTON"); ?></a></li>
					<li><a href="#" data-target="sign-up-email-state"><?= GetMessage("auth_register"); ?></a></li>
				</ul>
			</div>
			<div class="auth-state sign-in-email-state">
				<form id="sign-in-email-form">
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="LOGIN"/>
					<input type="hidden" name="MODE" value="EMAIL"/>
					<div class="bd-form-row input-row-first">
						<div class="bd-input">
							<label><?= GetMessage("auth_email"); ?></label>
							<input type="email" name="EMAIL">
						</div>
					</div>
					<div class="bd-form-row input-row-last">
						<div class="bd-input">
							<label><?= GetMessage("auth_password"); ?></label>
							<input type="password" name="PASSWORD">
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("AUTH_LOGIN_BUTTON"); ?></button>
					</div>
					<div class="bd-form-row"><a href="#" class="forgot">
							<span><?= GetMessage("AUTH_FORGOT_PASSWORD_2"); ?></span></a></div>
				</form>
			</div>
			<div class="auth-state sign-up-email-state">
				<form id="sign-up-email-form">
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="REGISTER"/>
					<input type="hidden" name="MODE" value="EMAIL"/>
					<div class="bd-form-row input-row-first">
						<div class="bd-input">
							<label><?= GetMessage("auth_email"); ?></label>
							<input type="email" name="EMAIL">
						</div>
					</div>
					<div class="bd-form-row input-row">
						<div class="bd-input">
							<label><?= GetMessage("auth_password"); ?></label>
							<input type="password" name="PASSWORD">
						</div>
					</div>
					<div class="bd-form-row input-row-last">
						<div class="bd-input">
							<label><?= GetMessage("auth_password_again"); ?></label>
							<input type="password" name="PASSWORD2">
						</div>
					</div>
					<div class="bd-form-row">
						<div class="rules">
							<label class="label">
								<input type="checkbox" id="inp_agree">
								<label for="inp_agree"><span></span></label><span><?= GetMessage("auth_term_reg_1"); ?>
									<a data-modal="rules-modal" href="#"
									   class="md-trigger"><?= GetMessage("auth_term_reg_2"); ?></a></span>
							</label>
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button disabled="disabled" type="submit" class="btn"><?= GetMessage("auth_register_button"); ?></button>
					</div>
					
				</form>
			</div>
			<div class="auth-state forgot-password-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
					<input type="hidden" name="MODE" value="EMAIL"/>
					<div class="bd-form-row">
						<div class="bd-input bordered">
							<label><?= GetMessage("auth_email"); ?></label>
							<input type="text" name="EMAIL" class="phone">
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("auth_send_code"); ?></button>
					</div>
				</form>
				<div class="state-info"><?= GetMessage("auth_send_code_desc_email"); ?></div>
			</div>
			<div class="auth-state phone-confirm-password-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
					<input type="hidden" name="MODE" value="EMAIL"/>
					<input type="hidden" name="EMAIL" value=""/>
					<div class="bd-form-row">
						<div class="bd-input bordered">
							<label><?= GetMessage("auth_code"); ?></label>
							<input autocomplete="off" type="text" maxlength="4" name="REG_CONFIRM_CODE" class="phone">
						</div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("auth_send_code"); ?></button>
					</div>
				</form>

			</div>
			<div class="auth-state set-new-password-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
					<input type="hidden" name="MODE" value="EMAIL"/>
					<input type="hidden" name="EMAIL" value=""/>
					<div class="bd-form-row input-row-first">
						<div class="bd-input">
							<label><?= GetMessage("auth_password"); ?></label>
							<input type="password" name="NEW_PASSWORD" class="phone">
						</div>
					</div>
					<div class="bd-form-row input-row-last">
						<div class="bd-input">
							<label><?= GetMessage("auth_password_again"); ?></label>
							<input  name="NEW_PASSWORD_2" type="password" class="phone">
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("auth_change_password"); ?></button>
					</div>
				</form>
			</div>
		<?php else: ?>
			<div class="auth-tabs">
				<ul>
					<li class="active"><a  data-target="sign-in-default-state" href="#"><?= GetMessage("AUTH_LOGIN_BUTTON"); ?></a></li>
					<li><a href="#" data-target="sign-up-phone-state"><?= GetMessage("auth_register"); ?></a></li>
				</ul>
			</div>
			<div style="display:block;" class="auth-state sign-in-default-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="LOGIN"/>
					<input type="hidden" name="MODE" value="PHONE"/>
					<div class="bd-form-row input-row-first">
						<div class="bd-input">
							<label><?= GetMessage("auth_phone"); ?></label>
							<input type="text" name="PHONE" class="phone">
						</div>
					</div>
					<div class="bd-form-row input-row-last">
						<div class="bd-input">
							<label><?= GetMessage("auth_password"); ?></label>
							<input type="password" name="PASSWORD" class="phone">
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("AUTH_LOGIN_BUTTON"); ?></button>
					</div>
					<div class="bd-form-row"><a href="#" class="forgot">
							<span><?= GetMessage("AUTH_FORGOT_PASSWORD_2"); ?></span></a></div>
				</form>
			</div>
			<div class="auth-state sign-up-phone-state">
				<form id="sms_reg">
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="REGISTER"/>
					<input type="hidden" name="MODE" value="PHONE"/>
					<div class="bd-form-row input-row-first">
						<div class="bd-input">
							<label><?= GetMessage("auth_phone"); ?></label>
							<input type="tel" name="PHONE" class="phone">
						</div>
					</div>
					<div class="bd-form-row input-row">
						<div class="bd-input">
							<label><?= GetMessage("auth_password"); ?></label>
							<input name="PASSWORD" type="password">
						</div>
					</div>
					<div class="bd-form-row input-row-last">
						<div class="bd-input">
							<label><?= GetMessage("auth_password_again"); ?></label>
							<input name="PASSWORD2" type="password">
						</div>
					</div>
					<div class="bd-form-row">
						<div class="rules">
							<label class="label">
								<input type="checkbox" id="inp_agree">
								<label for="inp_agree"><span></span></label><span><?= GetMessage("auth_term_reg_1"); ?>
									<a data-modal="rules-modal" href="#"
									   class="md-trigger"><?= GetMessage("auth_term_reg_2"); ?></a></span>
							</label>
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button disabled type="submit" class="btn"><?= GetMessage("auth_get_code"); ?></button>
					</div>
				</form>
			</div>
			<div class="auth-state phone-confirm-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="REGISTER"/>
					<input type="hidden" name="MODE" value="PHONE"/>
					<input type="hidden" name="PHONE" value=""/>
					<input type="hidden" name="PASSWORD" value=""/>
					<div class="bd-form-row">
						<div class="bd-input bordered">
							<label><?= GetMessage("auth_code"); ?></label>
							<input autocomplete="off" maxlength="4" type="text" name="REG_CONFIRM_CODE" class="phone">
						</div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("auth_send_code"); ?></button>
					</div>
				</form>
				<div class="resend-cont"><a href="#" class="code-resend">
						<span><?= GetMessage("auth_repeat_code"); ?></span></a>
					<div class="resend-status"><?= GetMessage("auth_repeat_code_desc"); ?> <span
							class="timer">0:59</span></div>
				</div>
			</div>
			<div class="auth-state forgot-password-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
					<input type="hidden" name="MODE" value="PHONE"/>
					<div class="bd-form-row">
						<div class="bd-input bordered">
							<label><?= GetMessage("auth_phone"); ?></label>
							<input type="text" name="PHONE" class="phone">
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("auth_send_code"); ?></button>
					</div>
				</form>
				<div class="state-info"><?= GetMessage("auth_send_code_desc"); ?></div>
			</div>
			<div class="auth-state phone-confirm-password-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
					<input type="hidden" name="MODE" value="PHONE"/>
					<input type="hidden" name="PHONE" value=""/>
					<div class="bd-form-row">
						<div class="bd-input bordered">
							<label><?= GetMessage("auth_code"); ?></label>
							<input autocomplete="off" type="text" maxlength="4" name="REG_CONFIRM_CODE" class="phone">
						</div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("auth_send_code"); ?></button>
					</div>
				</form>
				<div class="resend-cont"><a href="#" class="code-resend">
						<span><?= GetMessage("auth_repeat_code"); ?></span></a>
					<div class="resend-status"><?= GetMessage("auth_repeat_code_desc"); ?> <span
							class="timer">0:59</span></div>
				</div>
			</div>
			<div class="auth-state set-new-password-state">
				<form>
					<input type="hidden" name="CSRF" value=""/>
					<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
					<input type="hidden" name="MODE" value="PHONE"/>
					<input type="hidden" name="PHONE" value=""/>
					<div class="bd-form-row input-row-first">
						<div class="bd-input">
							<label><?= GetMessage("auth_password"); ?></label>
							<input type="password" name="NEW_PASSWORD" class="phone">
						</div>
					</div>
					<div class="bd-form-row input-row-last">
						<div class="bd-input">
							<label><?= GetMessage("auth_password_again"); ?></label>
							<input  name="NEW_PASSWORD_2" type="password" class="phone">
						</div>
					</div>
					<div class="bd-form-messages">
						<div class="bd-error"></div>
					</div>
					<div class="bd-form-row actions">
						<button type="submit" class="btn"><?= GetMessage("auth_change_password"); ?></button>
					</div>
				</form>
			</div>
		<?php endif; ?>

	<?php else: ?>
		<div class="auth-state logged-in-state">
			<?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_BONUSES_ENABLED','',SITE_ID) == 'Y'): ?>
			<div class="bonuses">
				<div class="title"><?= GetMessage("my_bonuses"); ?></div>
				<div class="value"><?php echo number_format($_SESSION['BONUS_VALUE'],0 ,'.',' '); ?><span class="currency font-fix"><?=CURRENCY_FONT;?></span></div>
			</div>
			<?php endif; ?>
			<nav>
				<ul>
					<li><a href="<?=SITE_DIR?>my/"><?= GetMessage("my_history"); ?></a></li>
					<?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_BONUSES_ENABLED','',SITE_ID) == 'Y'): ?>
					<li><a href="<?=SITE_DIR?>my/bonus/"><?= GetMessage("my_bonuses_page"); ?></a></li>
					<?php endif; ?>
					<li><a href="<?=SITE_DIR?>my/edit/"><?= GetMessage("my_profile"); ?></a></li>
					<li><a class="go-to-love" href="<?=SITE_DIR?>#section-whatIsLove"><?= GetMessage("my_love"); ?></a></li>
				</ul>
			</nav>
			<button onclick="window.location.href='?logout=yes'" class="exit-btn"><?= GetMessage("my_exit"); ?></button>
		</div>
	<?php endif; ?>
</div>
<div id="rules-modal" class="md-modal md-effect-1">
	<div class="md-content"><a href="#" class="md-close">
			<svg viewBox="0 0 129 129">
				<path
					d="M7.6,121.4c0.8,0.8,1.8,1.2,2.9,1.2s2.1-0.4,2.9-1.2l51.1-51.1l51.1,51.1c0.8,0.8,1.8,1.2,2.9,1.2c1,0,2.1-0.4,2.9-1.2   c1.6-1.6,1.6-4.2,0-5.8L70.3,64.5l51.1-51.1c1.6-1.6,1.6-4.2,0-5.8s-4.2-1.6-5.8,0L64.5,58.7L13.4,7.6C11.8,6,9.2,6,7.6,7.6   s-1.6,4.2,0,5.8l51.1,51.1L7.6,115.6C6,117.2,6,119.8,7.6,121.4z"/>
			</svg>
		</a>
		<div class="title"><?= GetMessage("auth_agree_personal_information"); ?></div>
		<div class="rules-text-cont scrollbar-macosx">
			<noindex>
<?= GetMessage("auth_inf_1"); ?> <?=\COption::GetOptionString('bd.deliverypizza', 'BD_PERSONAL_DATA_COMPANY_NAME','',SITE_ID);?> <?= GetMessage("auth_inf_2"); ?> <?=\COption::GetOptionString('bd.deliverypizza', 'BD_PERSONAL_DATA_COMPANY_ADDRESS','',SITE_ID);?><?= GetMessage("auth_inf_3"); ?> <?=$_SERVER['HTTP_HOST']?> <?= GetMessage("auth_inf_4"); ?><?=$_SERVER['HTTP_HOST']?> <?= GetMessage("auth_inf_5"); ?>
<?= GetMessage("auth_inf_6"); ?>
			</noindex>
		</div>
	</div>
</div>