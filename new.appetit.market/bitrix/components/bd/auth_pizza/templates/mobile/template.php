<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $USER;
?>
<div class="content auth-content" style="display: none;">
	<div class="status-bar auth-status-bar"><a href="#" class="back"></a>
		<div class="title"></div>
		<div class="auth-tabs">
			<ul>
				<li data-target="sign-in" class="active"><a href="#"><?= GetMessage("AUTH_LOGIN_BUTTON"); ?></a></li>
				<li data-target="sign-up"><a href="#"><?= GetMessage("auth_register"); ?></a></li>
			</ul>
		</div>
	</div>
	<div class="auth">
	<?php $mode = COption::GetOptionString('bd.deliverypizza', 'BD_CF_AUTH_TYPE', '', SITE_ID); ?>
		<script type="text/javascript">
			window.auth_type = '<?=$mode;?>';
		</script>
	<?php if ($mode == 'email'): ?>
		<div class="auth-state sign-in-email-state">
			<form id="sign-in-email-form">
				<input type="hidden" name="CSRF" value=""/>
				<input type="hidden" name="ACTION" value="LOGIN"/>
				<input type="hidden" name="MODE" value="EMAIL"/>
				<div class="bd-input">
					<input type="email" name="EMAIL" placeholder="<?= GetMessage("auth_email"); ?>">
				</div>
				<div class="bd-input">
					<input type="password" name="PASSWORD" placeholder="<?= GetMessage("auth_password"); ?>">
				</div>
				<div class="auth-info">
					<div class="auth-btn-cont">
						<button type="submit" class="auth-btn"><?= GetMessage("AUTH_LOGIN_BUTTON"); ?></button>
					</div>
					<div class="info-text error-text bd-error"></div>
					<div class="pass-reminder"><a onclick="setAuthState('forgot-password-state')" href="#"><?= GetMessage("AUTH_FORGOT_PASSWORD_2"); ?></a></div>
				</div>
			</form>
		</div>

		<div class="auth-state sign-up-email-state">
			<form id="sign-up-email-form">
				<input type="hidden" name="CSRF" value=""/>
				<input type="hidden" name="ACTION" value="REGISTER"/>
				<input type="hidden" name="MODE" value="EMAIL"/>
				<div class="bd-input">
					<input type="text" name="EMAIL" placeholder="<?= GetMessage("auth_email"); ?>">
				</div>
				<div class="bd-input">
					<input type="password" name="PASSWORD" placeholder="<?= GetMessage("auth_password"); ?>">
				</div>
				<div class="bd-input">
					<input type="password" name="PASSWORD2" placeholder="<?= GetMessage("auth_password_again"); ?>">
				</div>
				<div class="auth-info">
					<div class="rules">
						<label class="label">
							<input type="checkbox" id="inp_agree">
							<label for="inp_agree"><span></span></label><span><?= GetMessage("auth_term_reg_1"); ?> <a
									data-modal="rules-modal" href="#"
									class="md-trigger" onclick="setAuthState('agreement-state')"><?= GetMessage("auth_term_reg_2"); ?></a></span>
						</label>
					</div>
				</div>
				<div class="auth-info">
					<div class="recaptcha-cont"></div>
					<div class="info-text error-text  bd-error"></div>
					<div class="auth-btn-cont">
						<button type="submit"  disabled="disabled" class="auth-btn"><?= GetMessage("auth_register_button"); ?></button>
					</div>
				</div>
			</form>
		</div>

		<div class="auth-state forgot-password-state">
			<form>
				<input type="hidden" name="CSRF" value=""/>
				<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
				<input type="hidden" name="MODE" value="EMAIL"/>
				<div class="bd-input">
					<input type="email" name="EMAIL" placeholder="<?= GetMessage("auth_email"); ?>">
				</div>
				<div class="auth-info">
					<div class="info-text error-text  bd-error"></div>
					<div class="auth-btn-cont">
						<button type="submit" class="auth-btn"><?= GetMessage("auth_send_code"); ?></button>
					</div>
			</form>
			<div class="info-text"><?= GetMessage("auth_send_code_desc_email"); ?></div>
		</div></div>

		<div class="auth-state phone-confirm-password-state">
		<form>
			<input type="hidden" name="CSRF" value=""/>
			<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
			<input type="hidden" name="MODE" value="EMAIL"/>
			<input type="hidden" name="EMAIL" value=""/>
			<div class="bd-input">
				<input autocomplete="off" type="text" maxlength="4" name="REG_CONFIRM_CODE"
				       placeholder="<?= GetMessage("auth_code"); ?>">
			</div>
			<div class="info-text error-text  bd-error"></div>
			<div class="auth-info">
				<div class="auth-btn-cont">
					<button type="submit"  class="auth-btn"><?= GetMessage("auth_send_code"); ?></button>
				</div>
				<div class="info-text resend-status" style="display: none;"><?= GetMessage("auth_repeat_code_desc"); ?> <span class="timer">0:59</span></div>
				<div class="pass-reminder resend-cont"><a href="#" class="code-resend"><?= GetMessage("auth_repeat_code"); ?></a>
				</div>
			</div>
		</form>
	</div>

		<div class="auth-state set-new-password-state">
		<form>
			<input type="hidden" name="CSRF" value=""/>
			<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
			<input type="hidden" name="MODE" value="EMAIL"/>
			<input type="hidden" name="EMAIL" value=""/>
			<div class="bd-input">
				<input type="password" name="NEW_PASSWORD" placeholder="<?= GetMessage("auth_password"); ?>">
			</div>
			<div class="bd-input">
				<input type="password" name="NEW_PASSWORD_2" placeholder="<?= GetMessage("auth_password_again"); ?>">
			</div>
			<div class="auth-info">
				<div class="auth-btn-cont">
					<button type="submit" class="auth-btn"><?= GetMessage("auth_change_password"); ?></button>
				</div>
			</div>
		</form>
	</div>
	<?php else: ?>
		<div class="auth-state sign-in-default-state">
			<form>
				<input type="hidden" name="CSRF" value=""/>
				<input type="hidden" name="ACTION" value="LOGIN"/>
				<input type="hidden" name="MODE" value="PHONE"/>
				<div class="bd-input">
					<input type="text" name="PHONE" placeholder="<?= GetMessage("auth_phone"); ?>">
				</div>
				<div class="bd-input">
					<input type="password" name="PASSWORD" placeholder="<?= GetMessage("auth_password"); ?>">
				</div>
				<div class="auth-info">
					<div class="auth-btn-cont">
						<button type="button" class="auth-btn"><?= GetMessage("AUTH_LOGIN_BUTTON"); ?></button>
					</div>
					<div class="info-text error-text bd-error"></div>
					<div class="pass-reminder"  onclick="setAuthState('forgot-password-state')"><a href="#"><?= GetMessage("AUTH_FORGOT_PASSWORD_2"); ?></a></div>
				</div>
			</form>
		</div>

		<div class="auth-state sign-up-phone-state">
			<form id="sms_reg">
				<input type="hidden" name="CSRF" value=""/>
				<input type="hidden" name="ACTION" value="REGISTER"/>
				<input type="hidden" name="MODE" value="PHONE"/>
				<div class="bd-input">
					<input type="tel" name="PHONE" placeholder="<?= GetMessage("auth_phone"); ?>">
				</div>
				<div class="bd-input">
					<input type="password" name="PASSWORD" placeholder="<?= GetMessage("auth_password"); ?>">
				</div>
				<div class="bd-input">
					<input type="password" name="PASSWORD2" placeholder="<?= GetMessage("auth_password_again"); ?>">
				</div>
				<div class="auth-info">
					<div class="rules">
						<label class="label">
							<input type="checkbox" id="inp_agree">
							<label for="inp_agree"><span></span></label><span><?= GetMessage("auth_term_reg_1"); ?> <a
									data-modal="rules-modal" href="#"
									class="md-trigger" onclick="setAuthState('agreement-state')"><?= GetMessage("auth_term_reg_2"); ?></a></span>
						</label>
					</div>
					<div class="info-text error-text bd-error"></div>
					<div class="auth-btn-cont">
						<button type="submit" disabled="disabled"
						        class="auth-btn"><?= GetMessage("auth_get_code"); ?></button>
					</div>
					<div class="info-text"><?= GetMessage("auth_send_code_desc"); ?></div>
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
				<div class="bd-input">
					<input autocomplete="off" maxlength="4" type="text" name="REG_CONFIRM_CODE"
					       placeholder="<?= GetMessage("auth_code"); ?>">
				</div>
				<div class="auth-info">
					<div class="info-text error-text bd-error"></div>
					<div class="auth-btn-cont">
						<button type="submit" class="auth-btn"><?= GetMessage("auth_send_code"); ?></button>
					</div>
					<div class="info-text resend-status"><?= GetMessage("auth_repeat_code_desc"); ?> <span class="timer">0:59</span></div>
					<div class="pass-reminder"><a href="#" class="code-resend"><?= GetMessage("auth_repeat_code"); ?></a>
					</div>
			</form>
			<div class="info-text"><?= GetMessage("auth_send_code_desc"); ?></div>
		</div></div>

		<div class="auth-state forgot-password-state">
			<form>
				<input type="hidden" name="CSRF" value=""/>
				<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
				<input type="hidden" name="MODE" value="PHONE"/>
				<div class="bd-input">
					<input type="text" name="PHONE" placeholder="<?= GetMessage("auth_phone"); ?>">
				</div>
				<div class="auth-info">
					<div class="info-text error-text bd-error"></div>
					<div class="auth-btn-cont">
						<button type="submit" class="auth-btn"><?= GetMessage("auth_send_code"); ?></button>
					</div>
			</form>
			<div class="info-text"><?= GetMessage("auth_send_code_desc"); ?></div>
		</div></div>

		<div class="auth-state phone-confirm-password-state">
			<form>
				<input type="hidden" name="CSRF" value=""/>
				<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
				<input type="hidden" name="MODE" value="PHONE"/>
				<input type="hidden" name="PHONE" value=""/>
				<div class="bd-input">
					<input autocomplete="off" type="text" maxlength="4" name="REG_CONFIRM_CODE"
					       placeholder="<?= GetMessage("auth_code"); ?>">
				</div>
				<div class="auth-info">
					<div class="auth-btn-cont">
						<button type="submit"
						        class="auth-btn"><?= GetMessage("auth_send_code"); ?></button>
					</div>
					<div class="info-text resend-status"><?= GetMessage("auth_repeat_code_desc"); ?> <span class="timer">0:59</span></div>
					<div class="pass-reminder"><a href="#" class="code-resend"><?= GetMessage("auth_repeat_code"); ?></a>
					</div>
				</div>
			</form>
		</div>

		<div class="auth-state set-new-password-state">
			<form>
				<input type="hidden" name="CSRF" value=""/>
				<input type="hidden" name="ACTION" value="RESET_PASSWORD"/>
				<input type="hidden" name="MODE" value="PHONE"/>
				<input type="hidden" name="PHONE" value=""/>
				<div class="bd-input">
					<input type="password" name="NEW_PASSWORD" placeholder="<?= GetMessage("auth_password"); ?>">
				</div>
				<div class="bd-input">
					<input type="password" name="NEW_PASSWORD_2" placeholder="<?= GetMessage("auth_password_again"); ?>">
				</div>
				<div class="auth-info">
					<div class="info-text error-text bd-error"></div>
					<div class="auth-btn-cont">
						<button type="submit" class="auth-btn"><?= GetMessage("auth_change_password"); ?></button>
					</div>
				</div>
			</form>
		</div>
	<?php endif; ?>
	<div class="auth-state agreement-state">
		<div class="agreement-content">	
			<noindex>
<?= GetMessage("auth_inf_1"); ?> <?=\COption::GetOptionString('bd.deliverypizza', 'BD_PERSONAL_DATA_COMPANY_NAME','',SITE_ID);?> <?= GetMessage("auth_inf_2"); ?> <?=\COption::GetOptionString('bd.deliverypizza', 'BD_PERSONAL_DATA_COMPANY_ADDRESS','',SITE_ID);?><?= GetMessage("auth_inf_3"); ?> <?=$_SERVER['HTTP_HOST']?> <?= GetMessage("auth_inf_4"); ?><?=$_SERVER['HTTP_HOST']?> <?= GetMessage("auth_inf_5"); ?>
<?= GetMessage("auth_inf_6"); ?>
			</noindex>
			</div></div>
	</div>
</div>