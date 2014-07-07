<?php
include "includes/form-messages.inc.php";

if (isset($result)) {
    if ($result->isSubmitted()) {
        /* Show the results in JSON */
        showResults($result);

        return;
    } # if
} # if

/*
 * If we are called driectly, exit
 */
if (!isset($spot)) {
    return ;
} # if
?>

<form class="postcommentform form-horizontal" name="postcommentform" action="<?php echo $tplHelper->makePostCommentAction(); ?>" method="post">
	<input type="hidden" name="postcommentform[submitpost]" value="Post">
	<input type="hidden" name="postcommentform[xsrfid]" value="<?php echo $tplHelper->generateXsrfCookie('postcommentform'); ?>">
	<input type="hidden" name="postcommentform[inreplyto]" value="<?php echo htmlspecialchars($spot['messageid']); ?>">
	<input type="hidden" name="postcommentform[newmessageid]" value="">
	<input type="hidden" name="postcommentform[randomstr]" value="<?php echo $tplHelper->getCleanRandomString(12); ?>">
	<fieldset>
		<div class="form-group col col-lg-12">
			<input type="hidden" name="postcommentform[rating]" value="0">
			<textarea class="form-control" name="postcommentform[body]" id="postcommentform[body]"></textarea>
		</div>
		<div class="form-group col col-lg-12">
			<span class="col col-lg-4 col-lg-offset-4 well well-sm">
			<?php
			$smileyList = $tplHelper->getSmileyList();
			foreach ($smileyList as $name => $image) {
				echo "<a onclick=\"addText(' [img=" . $name . "]', 'postcommentform[body]'); return false;\"><img src=\"" . $image . "\" alt=\"" . $name . "\" name=\"" . $name . "\"></a> ";
			}
			?>
			</span>
		</div>
		<div class="form-group col col-lg-12">	
			<input class="btn btn-primary" type="submit" name="dummysubmit" title="<?php echo _('Add comment'); ?>" value="<?php echo _('Post'); ?>">
		</div>
	</fieldset>
</form>