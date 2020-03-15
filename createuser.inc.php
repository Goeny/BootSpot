<?php
    require __DIR__.'/includes/form-messages.inc.php';

if (!showResults($result)) {
    ?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
<form class="createuserform" name="createuserform" action="<?php echo $tplHelper->makeCreateUserAction(); ?>" method="post">
	<input type="hidden" name="createuserform[xsrfid]" value="<?php echo $tplHelper->generateXsrfCookie('createuserform'); ?>">
	<fieldset>
		<dl>
			<dt><label for="createuserform[username]"><?php echo _('Username'); ?></label></dt>
			<dd><input type="text" name="createuserform[username]" value="<?php echo htmlspecialchars($createuserform['username']); ?>"></dd>

			<dt><label for="createuserform[firstname]"><?php echo _('Firstname'); ?></label></dt>
			<dd><input type="text" name="createuserform[firstname]" value="<?php echo htmlspecialchars($createuserform['firstname']); ?>"></dd>

			<dt><label for="createuserform[lastname]"><?php echo _('Lastname'); ?></label></dt>
			<dd><input type="text" name="createuserform[lastname]" value="<?php echo htmlspecialchars($createuserform['lastname']); ?>"></dd>
			
			<dt><label for="createuserform[mail]"><?php echo _('E-mailaddress'); ?></label></dt>
			<dd><input type="text" name="createuserform[mail]" value="<?php echo htmlspecialchars($createuserform['mail']); ?>"></dd>

<?php if ($tplHelper->allowed(SpotSecurity::spotsec_send_notifications_services, 'email') && !$this->_settings->get('sendwelcomemail')) { ?>
			<dt><label for="createuserform[sendmail]"><?php echo _('Send e-mail to new user?'); ?></label></dt>
			<dd><input type="checkbox" name="createuserform[sendmail]"></dd>
<?php } ?>
			<dd><input class="greyButton" type="submit" name="createuserform[submitcreate]" value="<?php echo _('Add'); ?>"></dd>
		</dl>
	</fieldset>
</form>
      </div>
    </div>
  </div>
</div>
<?php
}
