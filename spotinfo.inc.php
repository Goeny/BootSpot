<?php
	require_once "includes/header.inc.php";
	$spot = $tplHelper->formatSpot($spot);

	// We definieeren hier een aantal settings zodat we niet steeds dezelfde check hoeven uit te voeren
	$show_nzb_button = ( (!empty($spot['nzb'])) && 
						 ($spot['stamp'] > 1290578400) && 
						 ($tplHelper->allowed(SpotSecurity::spotsec_retrieve_nzb, ''))
						);
	$show_watchlist_button = ($currentSession['user']['prefs']['keep_watchlist'] && $tplHelper->allowed(SpotSecurity::spotsec_keep_own_watchlist, ''));
	$allowedToPost = $tplHelper->allowedToPost();
	$isBlacklisted = ($spot['listidtype'] == 1);
	$isWhitelisted = ($spot['listidtype'] == 2); 
	$allow_blackList = (($tplHelper->allowed(SpotSecurity::spotsec_blacklist_spotter, '')) && ($allowedToPost) && (!$isBlacklisted) && (!empty($spot['spotterid'])));
	$allow_whiteList = (($tplHelper->allowed(SpotSecurity::spotsec_blacklist_spotter, '')) && ($allowedToPost) && (!$isBlacklisted) && (!$isWhitelisted) && (!empty($spot['spotterid'])));
	$show_spot_edit = $tplHelper->allowed(SpotSecurity::spotsec_show_spot_was_edited, '');
	$show_editor = $tplHelper->allowed(SpotSecurity::spotsec_view_spot_editor, '');

	/* Determine minimal width of the image, we cannot set it in the CSS because we cannot calculate it there */
	$imgMinWidth = 260;
	if (is_array($spot['image'])) {
		$imgMinWidth = min(260, $spot['image']['width']);
	} # if

    /* Create an episode string, if so required */
    $episodeString = '';
    if (!empty($spot['season'])) {
        $episodeString .= '<a href="' . $tplHelper->makeSeasonSearchUrl($spot) . '">' . _('season') . ' ' .$spot['season'] . "</a>";
    } // if

    if (!empty($spot['episode'])) {
        $episodeString = $tplHelper->commaAdd($episodeString, '<a href="' . $tplHelper->makeEpisodeSearchUrl($spot) . '">' . _('episode') . ' ' .$spot['episode'] . "</a>");
    } // if

    if (!empty($spot['partscurrent'])) {
        $episodeString = $tplHelper->commaAdd($episodeString, _("deel") . ' ' . (int) $spot['partscurrent']);
        if (!empty($spot['partstotal'])) {
            $episodeString = $tplHelper->commaAdd($episodeString, _("van ") . ' ' . (int) $spot['partstotal']);
        } // if
    } elseif (!empty($spot['partstotal'])) {
        $episodeString = $tplHelper->commaAdd($episodeString, _("in totaal") . ' ' . (int) $spot['partstotal'] . "delen");
    } // eisf
?>

<div id="details" class="details <?php echo $tplHelper->cat2CssClass($spot) ?>">
	<form class="blacklistspotterform" name="blacklistspotterform" action="<?php echo $tplHelper->makeListAction(); ?>" method="post">
		<input type="hidden" name="blacklistspotterform[submitaddspotterid]" value="Blacklist">
		<input type="hidden" name="blacklistspotterform[xsrfid]" value="<?php echo $tplHelper->generateXsrfCookie('blacklistspotterform'); ?>">
		<input type="hidden" name="blacklistspotterform[spotterid]" value="<?php echo htmlspecialchars($spot['spotterid']); ?>">
		<input type="hidden" name="blacklistspotterform[origin]" value="Reported via Spotweb for spot <?php echo htmlspecialchars($spot['messageid']); ?>">
		<input type="hidden" name="blacklistspotterform[idtype]" value="1">
	</form>




	<div class="navbar navbar-default navbar-fixed-top">
  		<div class="container">
  			<div class="navbar-header">
    			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      				<span class="icon-bar"></span>
      				<span class="icon-bar"></span>
      				<span class="icon-bar"></span>
    			</button>
  			</div>
  			<div class="navbar-collapse collapse navbar-responsive-collapse">
    			<ul class="nav navbar-nav">
					<li><a onClick="location.href = document.referrer;" title="<?php echo _('Back to mainview (ESC / U)'); ?>"><i class="fa fa-backward"></i></a></li>
					<li><a href="#"><?php echo $spot['formatname']; ?></a></li>
					<li>
						<?php
						if($spot['rating'] == 0) {
						?>
							<a href="#"><?php echo _('This spot has no rating yet'); ?></a>
						<?php
						} 
						elseif($spot['rating'] > 0) {
							$star = '<i class="fa fa-star"></i>';
						?>
						<a href="#"><?php echo str_repeat($star, $spot['rating']); ?></a>
						<?php
						}
						?>
					</li>
					<?php
					if ($tplHelper->allowed(SpotSecurity::spotsec_report_spam, '')) {
						if ($currentSession['user']['userid'] > 2) {
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Options <b class="caret"></b></a>
						<ul class="dropdown-menu">
					<?php
							if (!$tplHelper->isReportPlaced($spot['messageid'])) {
					?>	
							<li><a onclick="openDialog('editdialogdiv', '<?php echo _('Report spam'); ?>', '?page=render&tplname=reportspot&data[messageid]=<?php echo urlencode($spot['messageid']); ?>', postReportForm, 'autoclose', null, null);" class="spamreport-button" title="<?php echo _('Report this spot as spam'); ?>"><?php echo _('Report this spot as spam'); ?></a></li>
					<?php
							}
							else{
					?>
							<li><a onclick="return false;" class="spamreport-button success" title="<?php echo _('You already reported this spot as spam'); ?>"><?php echo _('You already reported this spot as spam'); ?></a></li>
					<?php
							}
					?>
						</ul>
					</li>
					<?php
						}
					}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
				<?php 
				if ($show_watchlist_button) {
				?>
					<li><a class="remove watchremove_<?php echo $spot['id']; ?>" onclick="toggleWatchSpot('<?php echo $spot['messageid']; ?>','remove', <?php echo $spot['id']; ?>)" <?php if($spot['isbeingwatched'] == false) { ?> style="display: none" <?php } ?> title="<?php echo _('Delete from watchlist (w)'); ?>"><i class="fa fa-bookmark"></i></a></li>
					<li><a class="remove watchremove_<?php echo $spot['id']; ?>" onclick="toggleWatchSpot('<?php echo $spot['messageid']; ?>','add', <?php echo $spot['id']; ?>)" <?php if($spot['isbeingwatched'] == true) { ?> style="display: none" <?php } ?> title="<?php echo _('Position in watchlist (w)'); ?>"><i class="fa fa-bookmark-o"></i></a></li>
				<?php
				}
				if ($show_nzb_button) { 
				?>
					<li><a class="nzb<?php if ($spot['hasbeendownloaded']) { echo " downloaded"; } ?>" href="<?php echo $tplHelper->makeNzbUrl($spot); ?>" title="<?php echo _('Download NZB'); if ($spot['hasbeendownloaded']) {echo _('(this spot has already been downloaded)');} echo " (n)"; ?>"><i class="fa fa-hdd-o"></i> </a></li>
				<?php 
				}
				if ((!empty($spot['nzb'])) && (!empty($spot['sabnzbdurl']))) {
					if ($spot['hasbeendownloaded']) {
				?>
					<li><a onclick="downloadSabnzbd('<?php echo $spot['id']; ?>','<?php echo $spot['sabnzbdurl']; ?>','<?php echo $spot['nzbhandlertype']; ?>')" rel="tooltip" title="<?php echo _('Add NZB to SABnzbd queue (you already downloaded this spot) (s)'); ?>"><i class="sab_<?php echo $spot['id']; ?> fa fa-check"></i> </a></li>
				<?php
					}
					else{
				?>
					<li><a onclick="downloadSabnzbd('<?php echo $spot['id']; ?>','<?php echo $spot['sabnzbdurl']; ?>','<?php echo $spot['nzbhandlertype']; ?>')" rel="tooltip" title="<?php echo _('Add NZB to SABnzbd queue (you already downloaded this spot) (s)'); ?>"><i class="sab_<?php echo $spot['id']; ?> fa fa-download"></i> </a></li>
				<?php
					}
				}
				?>
				</ul>
  			</div>
  		</div>  
	</div>


	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $spot['title']; ?></h3>
		</div>
		<div class="panel-body">
			<table class="spotheader table table-condensed">
				<tbody>
					<tr>
					<?php 
					if ($tplHelper->allowed(SpotSecurity::spotsec_report_spam, '')) {
						if ($currentSession['user']['userid'] > 2) {
							if (!$tplHelper->isReportPlaced($spot['messageid'])) {
					?>
						<th class="spamreport"><a onclick="openDialog('editdialogdiv', '<?php echo _('Report spam'); ?>', '?page=render&tplname=reportspot&data[messageid]=<?php echo urlencode($spot['messageid']); ?>', postReportForm, 'autoclose', null, null);" class="spamreport-button" title="<?php echo _('Report this spot as spam'); ?>"></a> </th>
					<?php 	
							} 
							else { 
					?>
						<th class="spamreport"><a onclick="return false;" class="spamreport-button success" title="<?php echo _('You already reported this spot as spam'); ?>"></a> </th>
					<?php 	}	
						} 
					} 
					?>
						<th class="nzb">
					<?php 
					if ($show_nzb_button) { 
					?>
							<a class="nzb<?php if ($spot['hasbeendownloaded']) { echo " downloaded"; } ?>" href="<?php echo $tplHelper->makeNzbUrl($spot); ?>" title="<?php echo _('Download NZB'); if ($spot['hasbeendownloaded']) {echo _('(this spot has already been downloaded)');} echo " (n)"; ?>"></a>
					<?php 
					} 
					?>				
						</th>
						<th class="search"><a href="<?php echo $spot['searchurl'];?>" title="<?php echo _('Find NZB');?>" rel="nofollow"></a></th>
					<?php 
					if ($show_watchlist_button) {
					?>
						<th class="watch">
							<a class="remove watchremove_<?php echo $spot['id']; ?>" onclick="toggleWatchSpot('<?php echo $spot['messageid']; ?>','remove',<?php echo $spot['id']; ?>)" <?php if($spot['isbeingwatched'] == false){ echo 'style="display: none;"'; } ?> title=<?php echo _('Delete from watchlist (w)'); ?>"></a>
							<a class="add watchadd_<?php echo $spot['id']; ?>" onclick="toggleWatchSpot('<?php echo $spot['messageid']; ?>','add',<?php echo $spot['id']; ?>)" <?php if($spot['isbeingwatched'] == true) { echo 'style="display: none;"'; } ?> title="<?php echo _('Place in watchlist (w)'); ?>"> </a>
						</th>
					<?php
					} 
					?>
					</tr>
				</tbody>
			</table>			
		</div>
		
		<?php 
		if (!$spot['verified'] || $tplHelper->isModerated($spot) || $isBlacklisted) {
		?>
		<div class="alert alert-dismissable alert-danger">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<?php
			if (!$spot['verified']) {
			?>
			<p><i class="fa fa-warning"></i> <?php echo _('This spot is not verified, the name of the sender has not been confirmed'); ?></p>
			<?php
			}
			if ($tplHelper->isModerated($spot)) {
			?>
			<p><i class="fa fa-warning"></i> <?php echo _('This spot is marked as potentional spam'); ?></p>
			<?php
			}
			if ($isBlacklisted) {
			?>
			<p><i class="fa fa-warning"></i> <?php echo _('This spotter is already blacklisted'); ?></p>
			<?php
			}
			?>
		</div>
		<?php
		} 
		if ($isWhitelisted) {
		?>
		<div class="alert alert-dismissable alert-info">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<p><i class="fa fa-thumbs-up"></i> <?php echo _('This spotter is already whitelisted'); ?></p>
		</div>
		<?php
		} 
		?>
			
		<div class="container">
			<div class="col-lg-12">                    
				<div class="col-lg-3">
                    <a data-toggle="modal" data-target="#lightbox" class="thumbnail">
						<img src="<?php echo $tplHelper->makeImageUrl($spot, 260, 260); ?>" alt="<?php echo $spot['title'];?>">
					</a>
				</div>
                    				
				<div class="col-lg-9">
					<table class="table table-condensed">
						<tbody>
							<tr>
								<th><?php echo _('Category'); ?></th>
								<td><a href="<?php echo $tplHelper->makeCatUrl($spot); ?>" title='<?php echo _('Find spots in this category'); ?> "<?php echo $spot['catname']; ?>"'><?php echo $spot['catname']; ?></a></td>
							</tr>
							<?php
							foreach(array('a', 'b', 'c', 'd', 'z') as $subcatType) {
								$subList = explode('|', $spot['subcat' . $subcatType]);
								foreach($subList as $sub) {
									if (!empty($sub)) {
							?>
							<tr>
								<th><?php echo SpotCategories::SubcatDescription($spot['category'], $subcatType); ?></th>
								<td><a href="<?php echo $tplHelper->makeSubCatUrl($spot, $sub); ?>" title="<?php echo _('Find spots in this category') . ' ' . SpotCategories::Cat2Desc($spot['category'], $sub); ?>"><?php echo SpotCategories::Cat2Desc($spot['category'], $sub); ?></a></td>
							</tr>
							<?php
									}
								}
							}
							?>
							<tr>
								<th><?php echo _('Date'); ?></th> 
								<td title='<?php echo $tplHelper->formatDate($spot['stamp'], 'force_spotlist'); ?>'> <?php echo $tplHelper->formatDate($spot['stamp'], 'spotdetail'); ?> </td> 
							</tr>
							<tr>
								<th><?php echo _('Size'); ?></th> 
								<td><?php echo $tplHelper->format_size($spot['filesize']); ?></td> 
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<th><?php echo _('Website'); ?></th>
								<td><a href='<?php echo $spot['website']; ?>' rel="nofollow"><?php echo $spot['website'];?></a></td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<th><?php echo _('Sender'); ?></th>
								<td><a href="<?php echo $tplHelper->makePosterUrl($spot); ?>" title='<?php echo sprintf(_('Find spots from %s'), $spot['poster']); ?>'><span class="label label-primary"><?php echo $spot['poster']; ?></span></a>
								<?php 
								if (!empty($spot['spotterid'])) { 
								?> 
								<a href="<?php echo $tplHelper->makeSpotterIdUrl($spot); ?>" title='<?php echo sprintf(_('Find spots from %s'), $spot['spotterid']);?>'><span class="label label-default"><?php echo $spot['spotterid']; ?></span></a>
								<?php 
								} 
								if ($allow_blackList) { 
								?>
								<a class="delete blacklistuserlink_<?php echo htmlspecialchars($spot['spotterid']); ?>" title="<?php echo _('Blacklist this sender'); ?>" onclick="blacklistSpotterId('<?php echo htmlspecialchars($spot['spotterid']); ?>');">&nbsp;&nbsp;&nbsp;</a>
								<?php 
								} 
								if ($allow_whiteList) { 
								?> 
								<a class="whitelist blacklistuserlink_<?php echo htmlspecialchars($spot['spotterid']); ?>" title="<?php echo _('Whitelist this sender'); ?>" onclick="whitelistSpotterId('<?php echo htmlspecialchars($spot['spotterid']); ?>');">&nbsp;&nbsp;&nbsp;</a>
								<?php 
								} 
								if ((!empty($spot['spotterid'])) && ($tplHelper->allowed(SpotSecurity::spotsec_keep_own_filters, ''))) { 
								?> 
								<a href="" class="addspotterasfilter" title="<?php echo _("Add filter for this spotter"); ?>" onclick="addSpotFilter('<?php echo $tplHelper->generateXsrfCookie('editfilterform'); ?>', 'SpotterID', '<?php echo urlencode($spot['spotterid']); ?>', 'Zoek spots van &quot;<?php echo urlencode($spot['poster']); ?>&quot;', 'addspotterasfilter'); return false; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
								<?php 
								} 
								?> 
								</td>
							</tr>
							<tr>
								<th><?php echo _('Tag'); ?></th>
								<td><a href="<?php echo $tplHelper->makeTagUrl($spot); ?>" title='<?php echo sprintf(_('Search spots with the tag: %s'), $spot['tag']); ?>'><?php echo $spot['tag']; ?></a> 
								<?php 
								if ((!empty($spot['tag'])) && ($tplHelper->allowed(SpotSecurity::spotsec_keep_own_filters, ''))) { 
								?> 
								<a href="#" class="addtagasfilter" title="<?php echo _("Add filter for this tag"); ?>" onclick="addSpotFilter('<?php echo $tplHelper->generateXsrfCookie('editfilterform'); ?>', 'Tag', '<?php echo urlencode($spot['tag']); ?>', 'Zoek op tag &quot;<?php echo urlencode($spot['tag']); ?>&quot;', 'addtagasfilter'); return false; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
								<?php 
								} 
								?> 
								</td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<th><?php echo _('Searchengine'); ?></th>
								<td><a href='<?php echo $spot['searchurl']; ?>'><?php echo _('Search'); ?></a></td>
							</tr>
							<?php 
							if ($show_nzb_button) { 
							?>		
							<tr>
								<th><?php echo _('NZB'); ?></th>
								<td><a href='<?php echo $tplHelper->makeNzbUrl($spot); ?>' title='<?php echo _('Download NZB (n)'); ?>'><?php echo _('NZB'); ?></a></td>
							</tr>
							<?php 
							} 
							?>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<th><?php echo _('Number of spamreports'); ?></th>
								<td><?php echo $spot['reportcount']; ?></td>
							</tr>
							<?php 
							if ($show_spot_edit && $spot['editstamp']) { 
							?>
							<tr>
								<th><?php echo _('Spot edited'); ?></th>
								<td title='<?php echo $tplHelper->formatDate($spot['editstamp'], 'force_spotlist'); ?>'> <?php echo $tplHelper->formatDate($spot['editstamp'], 'spotdetail'); ?> <?php if ($show_editor) echo "(" . $spot['editor'] . ")"?></td>
							</tr>
							<?php 
							} 
							?>
						</tbody>
					</table>
				</div>				
			</div>
		</div>
	</div>
</div>
								
<div class="description">
	<h4><?php echo _('Post Description'); ?></h4>
	<pre><?php echo html_entity_decode($spot['description']); ?></pre>
</div>
			
<?php 
if ($tplHelper->allowed(SpotSecurity::spotsec_view_comments, '')) { 
?>
<div class="col col-lg-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo _('Comments'); ?></h3>
		</div>
		<div class="panel-body">
			<ul class="nav nav-tabs" style="margin-bottom: 15px;">
				<li class="active"><a href="#comments" data-toggle="tab"><?php echo _('Comments'); ?> <span class="commentcount badge alert-info"># 0</span></a></li>
				<li><a href="#addComment" data-toggle="tab"><?php echo _('Add comment'); ?></a></li>
			</ul>
			
			<div id="myTabContent" class="tab-content">
				<div class="tab-pane fade active in" id="comments">
					<ul id="commentslist"></ul>
				</div>
				<div class="tab-pane fade" id="addComment"><?php include('postcomment.inc.php'); ?></div>
			</div>
		</div>
	</div>
</div>
<?php
} 
?>

<input type="hidden" id="messageid" value="<?php echo $spot['messageid'] ?>" />
	
<?php
require_once "includes/footer.inc.php";
?>

<script type="text/javascript">
    $(document).ready(function(){
        // Attach an onLoad() listener to the image so we can bring the image into view
        loadSpotImage();

        $("#details").addClass("external");

        $("a[href^='http']").attr('target','_blank');

        $("a.closeDetails").click(function(){
            window.close();
        });

        var messageid = $('#messageid').val();
        postCommentsForm();
        postBlacklistForm();
        if (spotweb_retrieve_commentsperpage > 0) {
            loadComments(messageid,spotweb_retrieve_commentsperpage,'0');
        } // if
    });

    function addText(text,element_id) {
        document.getElementById(element_id).value += text;
    }
</script>



<div id="lightbox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        		<h4 class="modal-title"><?php echo $spot['title'];?></h4>
      		</div>
            <div class="modal-body">
                <img src="<?php echo $tplHelper->makeImageUrl($spot, 520, 300); ?>" alt="<?php echo $spot['title'];?>" />
            </div>
            <div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	</div>
        </div>
    </div>
</div>