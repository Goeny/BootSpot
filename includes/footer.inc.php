	</div>

    <?php if ($tplHelper->allowed(SpotSecurity::spotsec_view_statics, '')) { ?>
        <script type='text/javascript'>
            // Define some global variables showing or hiding specific parts of the UI
            // based on users' security rights
            var spotweb_security_allow_spotdetail = <?php echo (int) $tplHelper->allowed(SpotSecurity::spotsec_view_spotdetail, ''); ?>;
            var spotweb_security_allow_view_spotimage = <?php echo (int) $tplHelper->allowed(SpotSecurity::spotsec_view_spotimage, ''); ?>;
            var spotweb_security_allow_view_comments = <?php echo (int) $tplHelper->allowed(SpotSecurity::spotsec_view_comments, ''); ?>;
            var spotweb_currentfilter_params = "<?php echo str_replace('&amp;', '&', $tplHelper->convertFilterToQueryParams()); ?>";
            var spotweb_retrieve_commentsperpage = <?php if ($settings->get('retrieve_full_comments')) { echo 250; } else { echo 10; } ?>;
            var spotweb_nzbhandler_type = '<?php echo $tplHelper->getNzbHandlerType(); ?>';
        </script>
        <script src='?page=statics&amp;type=js&amp;lang=<?php echo urlencode($currentSession['user']['prefs']['user_language']); ?>&amp;mod=<?php echo $tplHelper->getStaticModTime('js'); ?>' type='text/javascript'></script>

        <script type='text/javascript'>
            initSpotwebJs();
            <?php if (!empty($toRunJsCode)) {
                echo $toRunJsCode;
            } # if
            ?>
        </script>
    <?php } ?>

	
<!-- BEGIN SABNZBD PANEL -->
<div class="modal fade sabnzbdPanel" id="mySAB" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">
        	<img src="templates/bootspot/images/sablogo.png" height="32" /> 
            SABnzbd Panel
        </h4>
      </div>
      <div class="modal-body sabnzbdPanel">
<div id="sabnzbdPanel">
<?php 
if ($tplHelper->allowed(SpotSecurity::spotsec_use_sabapi, '')) { 
	$apikey = $tplHelper->apiToHash($currentSession['user']['apikey']);
	echo "<input class='apikey' type='hidden' value='".$apikey."'>";
	if ($tplHelper->getNzbHandlerApiSupport() === false){
?>
		<table class="sabInfo table" summary="SABnzbd infomatie">
			<tr>
				<td><?php echo _('Selected NZB download methode doesn\'t support sidepanel'); ?></td>
			</tr>
		</table>			
<?php	
	}
	else{
?>		<table class="sabInfo table" summary="SABnzbd infomatie">
			<tr>
				<td><?php echo _('Status:'); ?></td><td class="state"></td>
			</tr>
			<tr>
				<td><?php echo _('Free storage:'); ?></td><td class="diskspace"></td>
			</tr>
			<tr>
				<td><?php echo _('Speed:'); ?></td><td class="speed"></td>
			</tr>
			<tr>
				<td><?php echo _('Max. speed:'); ?></td><td class="speedlimit"></td>
			</tr>
			<tr>
				<td><?php echo _('To go:'); ?></td><td class="timeleft"></td>
			</tr>
			<tr>
				<td><?php echo _('ETA:'); ?></td><td class="eta"></td>
			</tr>
			<tr>
				<td><?php echo _('Queue:'); ?></td><td class="mb"></td>
			</tr>
		</table>
		<canvas id="graph table" width="215" height="125"></canvas>
		<table class="sabGraphData" summary="SABnzbd Graph Data" style="display:none;">
			<tbody>
				<tr>
					<td></td>
				</tr>
			</tbody>
		</table>
		<h4><?php echo _('Queue'); ?></h4>
		<table class="sabQueue table" summary="SABnzbd queue">
			<tbody>
				<tr>
					<td></td>
				</tr>
			</tbody>
		</table>
		<?php 	
		}
	} 
?>
</div>
</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>	
<!-- EINDE SABNZBD PANEL -->	
	
	
	</body>
</html>
