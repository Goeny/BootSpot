<div class="sidebarPanel sabnzbdPanel">
<?php 
if ($tplHelper->allowed(SpotSecurity::spotsec_use_sabapi, '')) { 
?>
	<h4><a class="toggle" onclick="toggleSidebarPanel('.sabnzbdPanel')" title='<?php echo _('Sluit "' . $tplHelper->getNzbHandlerName() . 'paneel"'); ?>'>[x]</a><?php echo $tplHelper->getNzbHandlerName(); ?></h4>
<?php 
	$apikey = $tplHelper->apiToHash($currentSession['user']['apikey']);
	echo "<input class='apikey' type='hidden' value='".$apikey."'>";
	if ($tplHelper->getNzbHandlerApiSupport() === false){
?>
		<table class="sabInfo" summary="SABnzbd infomatie">
			<tr>
				<td><?php echo _('Selected NZB download methode doesn\'t support sidepanel'); ?></td>
			</tr>
		</table>			
<?php	
	}
	else{
?>		<table class="sabInfo" summary="SABnzbd infomatie">
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
		<canvas id="graph" width="215" height="125"></canvas>
		<table class="sabGraphData" summary="SABnzbd Graph Data" style="display:none;">
			<tbody>
				<tr>
					<td></td>
				</tr>
			</tbody>
		</table>
		<h4><?php echo _('Queue'); ?></h4>
		<table class="sabQueue" summary="SABnzbd queue">
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