<?php
    SpotTiming::start('tpl:filters');

	// We definieeren hier een aantal settings zodat we niet steeds dezelfde check hoeven uit te voeren
	$count_newspots = ($currentSession['user']['prefs']['count_newspots']);
	$show_multinzb_checkbox = ($currentSession['user']['prefs']['show_multinzb']);
?>

<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-spotweb">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php"><img src="templates/bootspot/images/spotweb-logo.png" width="120" border="0" /></a>
		</div>
		<div class="navbar-collapse collapse" id="navbar-spotweb">
			
			<ul class="nav navbar-nav navbar-left">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i> <?php echo _('Maintenance'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<?php if ($currentSession['user']['userid'] > SPOTWEB_ADMIN_USERID) {
							if ( ($tplHelper->allowed(SpotSecurity::spotsec_retrieve_spots, '')) && ($tplHelper->allowed(SpotSecurity::spotsec_consume_api, ''))) { ?>
								<li><a href="<?php echo $tplHelper->makeRetrieveUrl(); ?>" onclick="retrieveSpots(this)" class="greyButton retrievespots"><i class="fa fa-refresh"></i> <?php echo _('Retrieve'); ?></a></li>
						<?php 	}
						} 
						?>
						<?php if (($tplHelper->allowed(SpotSecurity::spotsec_keep_own_downloadlist, '')) && ($tplHelper->allowed(SpotSecurity::spotsec_keep_own_downloadlist, 'erasedls'))) { ?>
							<li><a href="<?php echo $tplHelper->getPageUrl('erasedls'); ?>" onclick="eraseDownloads()" class="greyButton erasedownloads"><i class="fa fa-trash-o"></i> <?php echo _('Erase downloadhistory'); ?></a></li>
						<?php } ?>
						<?php if ($tplHelper->allowed(SpotSecurity::spotsec_keep_own_seenlist, '')) { ?>
							<li><a href="<?php echo $tplHelper->getPageUrl('markallasread'); ?>" onclick="markAsRead()" class="greyButton markasread"><i class="fa fa-eye-slash"></i> <?php echo _('Mark everything as read'); ?></a></li>
						<?php } ?>
						<?php if ($tplHelper->allowed(SpotSecurity::spotsec_view_spotweb_updates, '')) { 
						?>
							<li><a href="?page=versioncheck" data-target="#myModal" data-toggle="modal" title="<?php echo _('Spotweb updates'); ?>"><i class="fa fa-medkit"></i> <?php echo _('Spotweb updates');?></a></li>
						<?php } ?>
						<li><a data-target="#mySAB" data-toggle="modal"><i class="fa fa-download"></i> SABnzbd Panel</a></li>
						<li><a href="https://github.com/Goeny/BootSpot" target="_blank"><i class="fa fa-github-alt"></i> BootSpot on Github</a></li>
					</ul>
				</li>
			</ul>	
						
			<ul class="nav navbar-nav navbar-left">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-external-link-square"></i> <?php echo _('Quick Links'); ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<?php 
						foreach($quicklinks as $quicklink) {
							if ($tplHelper->allowed($quicklink[4][0], $quicklink[4][1])) {
								if (empty($quicklink[5]) || $currentSession['user']['prefs'][$quicklink[5]]) {
									$newCount = ($count_newspots && stripos($quicklink[2], 'New:0')) ? $tplHelper->getNewCountForFilter($quicklink[2]) : "";
								?>
									<li><a class="filter <?php if (parse_url($tplHelper->makeSelfUrl("full"), PHP_URL_QUERY) == parse_url($tplHelper->makeBaseUrl("full") . $quicklink[2], PHP_URL_QUERY)) { echo " selected"; } ?>" href="<?php echo $quicklink[2]; ?>">
									<?php echo $quicklink[0]; if ($newCount > 0) { echo " <span class='badge'>".$newCount."</span>"; } ?></a>
					
								<?php
								}
							}
						} 
						?>
					</ul>
				</li>
			</ul>
			
			<ul class="nav navbar-nav navbar-right">	
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" id="user" <?php if ($currentSession['user']['userid'] != SPOTWEB_ANONYMOUS_USERID) { ?> title="<?php echo sprintf(_('Last seen: %s ago'), $tplHelper->formatDate($currentSession['user']['lastvisit'], 'lastvisit')); ?>"><i class="fa fa-user"></i> <?php echo $currentSession['user']['username']; ?> <b class="caret"></b></a>
					<?php } else { ?>
					><?php echo _("Log in"); ?>
					</a>
					<?php } ?>
					<ul class="dropdown-menu">
						<?php if (($tplHelper->allowed(SpotSecurity::spotsec_perform_login, '')) && ($currentSession['user']['userid'] == $settings->get('nonauthenticated_userid'))) { ?>
						<li><a href="<?php echo $tplHelper->makeLoginAction(); ?>" onclick="return openDialog('editdialogdiv', '<?php echo _('Login'); ?>', '?page=login&data[htmlheaderssent]=true', null, 'autoclose', function() { window.location.reload(); }, null); "><?php echo _('Login'); ?></a></li>
						<?php } ?>
						<?php if ($tplHelper->allowed(SpotSecurity::spotsec_create_new_user, '')) { ?>
						<li><a href="" onclick="return openDialog('editdialogdiv', '<?php echo _('Add user'); ?>', '?page=createuser', null, 'showresultsonly', null, null); "><i class="fa fa-plus"></i> <?php echo _('Add user'); ?></a></li>
						<?php } ?>
						<?php if ($tplHelper->allowed(SpotSecurity::spotsec_edit_own_user, '')) { ?>
						<li><a href="<?php echo $tplHelper->makeEditUserUrl($currentSession['user']['userid'], 'edit'); ?>" onclick="return openDialog('editdialogdiv', '<?php echo _('Change user'); ?>', '?page=edituser&userid=<?php echo $currentSession['user']['userid'] ?>', null, 'autoclose',  function() { window.location.reload(); }, null);"><i class="fa fa-edit"></i> <?php echo _('Change user'); ?></a></li>
						<?php } ?>
						<?php if ($tplHelper->allowed(SpotSecurity::spotsec_perform_logout, '')) { ?>
						<li><a href="#" onclick="userLogout()"><i class="fa fa-sign-out"></i> <?php echo _('Log out'); ?></a></li>
						<?php } ?>
					</ul>
				</li>
			</ul>
				
			<?php if (($tplHelper->allowed(SpotSecurity::spotsec_edit_own_userprefs, '')) || ($tplHelper->allowed(SpotSecurity::spotsec_view_spotweb_updates, '')) || ($tplHelper->allowed(SpotSecurity::spotsec_edit_settings, '')) || ($tplHelper->allowed(SpotSecurity::spotsec_edit_other_users, '')) || ($tplHelper->allowed(SpotSecurity::spotsec_edit_securitygroups, '')) || ($tplHelper->allowed(SpotSecurity::spotsec_list_all_users, ''))) { ?>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> <?php echo _('Config'); ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<?php if ($tplHelper->allowed(SpotSecurity::spotsec_edit_own_userprefs, '')) { ?>
						<li><a data-target="#myModal" data-toggle="modal" href="<?php echo $tplHelper->makeEditUserPrefsUrl($currentSession['user']['userid']); ?>"><i class="fa fa-cog"></i> <?php echo _('Change preferences'); ?></a></li>
						<?php } ?>
						<?php if (($tplHelper->allowed(SpotSecurity::spotsec_view_spotweb_updates, '')) || ($tplHelper->allowed(SpotSecurity::spotsec_edit_settings, ''))) { ?>
						<li><a href="?page=editsettings"><i class="fa fa-wrench"></i> <?php echo _('Settings'); ?></a></li>
						<?php } ?>
						<?php if (($tplHelper->allowed(SpotSecurity::spotsec_edit_other_users, '')) || ($tplHelper->allowed(SpotSecurity::spotsec_edit_securitygroups, '')) || ($tplHelper->allowed(SpotSecurity::spotsec_list_all_users, ''))) { ?>
						<li><a data-target="#myModal" data-toggle="modal" href="?page=render&amp;tplname=usermanagement"><i class="fa fa-users"></i> <?php echo _('User &amp; group management'); ?></a></li>
						<?php } ?>
					</ul>
				</li>
			</ul>
			<?php 
			}
			?>
			<ul class="nav navbar-nav navbar-right">
				  <?php if ($tplHelper->allowed(SpotSecurity::spotsec_post_spot, '') && $currentSession['user']['userid'] > SPOTWEB_ADMIN_USERID) { ?>
				<li><a onclick="return openDialog('editdialogdiv', '<?php echo _('Add spot'); ?>', '<?php echo $tplHelper->getPageUrl('postspot'); ?>', function() { new SpotPosting().postNewSpot(this.form, postSpotUiStart, postSpotUiDone); return false; }, 'autoclose', null, null);" title='<?php echo _('Add spot'); ?>'><i class="fa fa-plus"></i> <?php echo _('Add spot'); ?></a></li>
				<?php } ?>
			</ul>
		




			<?php if ($tplHelper->allowed(SpotSecurity::spotsec_perform_search, '')) { ?>
				  
				  <form id="filterform" action="<?php echo $tplHelper->makeSelfUrl('')?>" onsubmit="submitFilterBtn(this)" class="navbar-form navbar-left">
				  <input type="hidden" id="searchfilter-includeprevfilter-toggle" name="search[includeinfilter]" value="false" />
			
			<?php include('templates/bootspot/lib/filters.search.php'); ?>


					<script type='text/javascript'>
    var sliderMinFileSize = <?php echo (isset($minFilesize)) ? $minFilesize : "0"; ?>;
    var sliderMaxFileSize = <?php echo (isset($maxFilesize)) ? $maxFilesize : (1024*1024*1024) * 512; ?>;
    var sliderMaxReportCount = <?php echo (isset($maxReportCount)) ? $maxReportCount : "21"; ?>;
					</script>
					<input type="hidden" id="search-tree" name="search[tree]" value="<?php echo $tplHelper->categoryListToDynatree(); ?>">
					<input class="form-control col-lg-8" type="text" name="search[text]" placeholder="Zoeken" value="<?php echo htmlspecialchars($searchText); ?>"><i class="icon-search"></i>
					<button class="btn btn-default" type='submit' onclick='$("#searchfilter-includeprevfilter-toggle").val("true");' title='<?php echo _('Search within current filters'); ?>'><i class='fa fa-search-plus'></i></button>
					<button class="btn btn-default" type='submit' onclick='$("#searchfilter-includeprevfilter-toggle").val(""); return true;' title='<?php echo _('Search'); ?>'><i class='fa fa-search'></i></button>
		</div>
	</div>
</div>
</div>

<p class="clearfix"></p>


<div class="modal">
  <div class="modal-dialog">
    <div class="modal-content">

					<div class="sidebarPanel advancedSearch">
					<h4><a class="toggle" onclick="toggleSidebarPanel('.advancedSearch')" title="<?php echo _("Close 'Advanced Search'"); ?>">[x]</a><?php echo _('Search on:'); ?></h4>
						<ul class="search sorting fourcol">
							<li> <input type="radio" name="search[type]" value="Title" <?php echo $searchType == "Title" ? 'checked="checked"' : "" ?> ><label><?php echo _('Title'); ?></label></li>
							<li> <input type="radio" name="search[type]" value="Poster" <?php echo $searchType == "Poster" ? 'checked="checked"' : "" ?> ><label><?php echo _('Poster'); ?></label></li>
							<li> <input type="radio" name="search[type]" value="Tag" <?php echo $searchType == "Tag" ? 'checked="checked"' : "" ?> ><label><?php echo _('Tag'); ?></label></li>
							<li> <input type="radio" name="search[type]" value="SpotterID" <?php echo $searchType == "SpotterID" ? 'checked="checked"' : "" ?> ><label><?php echo _('SpotterID'); ?></label></li>
                            <li> <input type="radio" name="search[type]" value="Year" <?php echo $searchType == "Year" ? 'checked="checked"' : "" ?> ><label><?php echo _('Year'); ?></label></li>
                            <li> <input type="radio" name="search[type]" value="Season" <?php echo $searchType == "Season" ? 'checked="checked"' : "" ?> ><label><?php echo _('Season'); ?></label></li>
                            <li> <input type="radio" name="search[type]" value="Episode" <?php echo $searchType == "Episode" ? 'checked="checked"' : "" ?> ><label><?php echo _('Episode'); ?></label></li>
                            <li> <input type="radio" name="search[type]" value="Collection" <?php echo $searchType == "Collection" ? 'checked="checked"' : "" ?> ><label><?php echo _('Collection'); ?></label></li>
                        </ul>

<?php
	if ($textSearchCount > 0) {
?>
						<h4><?php echo _('Active filters:'); ?></h4>
						<table class='search currentfilterlist'>
<?php
	foreach($parsedsearch['filterValueList'] as $filterType) {
		if (in_array($filterType['fieldname'], array('Titel', 'Title', 'Poster', 'Tag', 'SpotterID', 'CollectionId', 'Collection', 'Season', 'Episode', 'Year'))) {
?>
							<tr> <th> <?php echo ($filterType['fieldname'] == 'Title') ? _('Title') : _($filterType['fieldname']); ?> </th> <td> <?php echo htmlspecialchars($filterType['booloper'], ENT_QUOTES, 'UTF-8'); ?> </td> <td> <?php echo htmlentities($filterType['value'], ENT_QUOTES, 'UTF-8'); ?> </td> <td> <a href="javascript:location.href=removeFilter('?page=index<?php echo addcslashes(urldecode($tplHelper->convertFilterToQueryParams()), "\\\'\"&\n\r<>"); ?>', '<?php echo $filterType['fieldname']; ?>', '<?php echo $filterType['operator']; ?>', '<?php echo $filterType['booloper']; ?>', '<?php echo addcslashes(htmlspecialchars($filterType['value'], ENT_QUOTES, 'utf-8'), "\\\'\"&\n\r<>"); ?>');">x</a> </td> </tr>
<?php
		} # if
	} # foreach
?>
						</table>
<?php						
	}
?>
						<h4><?php echo _('Sorteren op:'); ?></h4>
						<input type="hidden" name="sortdir" value="<?php if($sortType == "stamp" || $sortType == "spotrating" || $sortType == "commentcount") {echo "DESC";} else {echo "ASC";} ?>">
						<ul class="search sorting threecol">
							<li> <input type="radio" name="sortby" value="" <?php echo $sortType == "" ? 'checked="checked"' : "" ?>><label><?php echo _('Relevance'); ?></label> </li>
							<li> <input type="radio" name="sortby" value="title" <?php echo $sortType == "title" ? 'checked="checked"' : "" ?>><label><?php echo _('Title'); ?></label> </li>
							<li> <input type="radio" name="sortby" value="poster" <?php echo $sortType == "poster" ? 'checked="checked"' : "" ?>><label><?php echo _('Poster');?></label> </li>
							<li> <input type="radio" name="sortby" value="stamp" <?php echo $sortType == "stamp" ? 'checked="checked"' : "" ?>><label><?php echo _('Date');?></label> </li>
							<li> <input type="radio" name="sortby" value="commentcount" <?php echo $sortType == "commentcount" ? 'checked="checked"' : "" ?>><label><?php echo _('Comments'); ?></label> </li>
							<li> <input type="radio" name="sortby" value="spotrating" <?php echo $sortType == "spotrating" ? 'checked="checked"' : "" ?>><label><?php echo _('Rating'); ?></label> </li>
						</ul>

						<h4><?php echo _('Limit age'); ?></h4>
						<ul class="search age onecol">
<?php if (!isset($ageFilter)) { $ageFilter = ''; } ?>
							<li><select name="search[value][]">
								<option value=""><?php echo _('Show all'); ?></option>
								<option value="date:>:DEF:-1 day" <?php echo $ageFilter == ">-1 day" ? 'selected="selected"' : "" ?>><?php echo _('1 day'); ?></option>
								<option value="date:>:DEF:-3 days" <?php echo $ageFilter == ">-3 days" ? 'selected="selected""' : "" ?>><?php echo _('3 days'); ?></option>
								<option value="date:>:DEF:-1 week" <?php echo $ageFilter == ">-1 week" ? 'selected="selected""' : "" ?>><?php echo _('1 week'); ?></option>
								<option value="date:>:DEF:-2 weeks" <?php echo $ageFilter == ">-2 weeks" ? 'selected="selected"' : "" ?>><?php echo _('2 weeks'); ?></option>
								<option value="date:>:DEF:-1 month" <?php echo $ageFilter == ">-1 month" ? 'selected="selected"' : "" ?>><?php echo _('1 month'); ?></option>
								<option value="date:>:DEF:-3 months" <?php echo $ageFilter == ">-3 months" ? 'selected="selected"' : "" ?>><?php echo _('3 months'); ?></option>
								<option value="date:>:DEF:-6 months" <?php echo $ageFilter == ">-6 months" ? 'selected="selected"' : "" ?>><?php echo _('6 months'); ?></option>
								<option value="date:>:DEF:-1 year" <?php echo $ageFilter == ">-1 year" ? 'selected="selected"' : "" ?>><?php echo _('1 year'); ?></option>
							</select></li>
						</ul>
					
						<h4><?php echo _('Size'); ?></h4>
						<input type="hidden" name="search[value][]" id="min-filesize" />
						<input type="hidden" name="search[value][]" id="max-filesize" />
						<div id="human-filesize"></div>
						<div id="slider-filesize"></div>

						<h4><?php echo _('Categories'); ?></h4>
						<div id="tree"></div>
						<ul class="search clearCategories onecol">
							<li> <input type="checkbox" name="search[unfiltered]" value="true" <?php echo $parsedsearch['unfiltered'] == "true" ? 'checked="checked"' : '' ?>>
							
							<label><?php if ($parsedsearch['unfiltered'] == 'true') { echo _("Use categories"); } else { echo _("Don't use categories"); } ?></label> </li>
						</ul>

<?php if ($settings->get('retrieve_reports')) { ?>
						<h4><?php echo _('Number of reports'); ?></h4>
						<input type="hidden" name="search[value][]" id="max-reportcount" />
						<div id="human-reportcount"></div>
						<div id="slider-reportcount"></div>
<?php } ?>
<?php if ($tplHelper->allowed(SpotSecurity::spotsec_keep_own_filters, '')) { ?>
						<h4><?php echo _('Filters'); ?></h4>
						<a onclick="return openDialog('editdialogdiv', '<?php echo _('Add a filter'); ?>', '?page=render&amp;tplname=editfilter&amp;data[isnew]=true<?php echo addcslashes($tplHelper->convertTreeFilterToQueryParams() .$tplHelper->convertTextFilterToQueryParams() . $tplHelper->convertSortToQueryParams(), "\\\'\"&\n\r<>"); ?>', null, 'autoclose', null, null); " class="greyButton addFilter"><?php echo _('Save search as filter'); ?></a>
<?php } ?>
				</div>
			</form>
<?php } # if perform search ?>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Modal title</h4>

            </div>
            <div class="modal-body"><div class="te"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

</div>
</nav>

		<div class="col-xs-6 col-lg-3">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo _('Filters'); ?></h3>
				</div>
				<div class="panel-body">
					<table class="table table-hover">
					<?php
					function processFilters($tplHelper, $count_newspots, $filterList) {
						$selfUrl = $tplHelper->makeSelfUrl("path");

						foreach($filterList as $filter) {
							$strFilter = $tplHelper->getPageUrl('index') . '&amp;search[tree]=' . $filter['tree'];
							if (!empty($filter['valuelist'])) {
								foreach($filter['valuelist'] as $value) {
									$strFilter .= '&amp;search[value][]=' . $value;
								} # foreach
							} # if
							if (!empty($filter['sorton'])) {
								$strFilter .= '&amp;sortby=' . $filter['sorton'] . '&amp;sortdir=' . $filter['sortorder'];
							} # if
							$newCount = ($count_newspots) ? $tplHelper->getNewCountForFilter($strFilter) : "";

							/* add the current search terms */
							$strFilterInclusive =  $strFilter . $tplHelper->convertSortToQueryParams() . $tplHelper->convertTextFilterToQueryParams();

							# escape the filter values
							$filter['title'] = htmlentities($filter['title'], ENT_QUOTES, 'UTF-8');
							$filter['icon'] = htmlentities($filter['icon'], ENT_QUOTES, 'UTF-8');
			
							# Output de HTML
							echo '<tr class="'. $tplHelper->filter2cat($filter['tree']) .'">';
							// echo '<li class="'. $tplHelper->filter2cat($filter['tree']) .'">';
							echo '<td><a class="filter ' . $filter['title'];
														
							echo '" href="' . $strFilter . '">';
							echo '<span class="spoticon spoticon-' . str_replace('.png', '', $filter['icon']) . '">&nbsp;</span>' . $filter['title'];
							if ($newCount > 0) { 
								echo " <span onclick=\"gotoNew('".$strFilter."')\" class='badge' title='" . sprintf(_('Show new spots in filter &quot;%s&quot;'), $filter['title']) . "'>$newCount</span>";
							} # if 

							# als er children zijn, moeten we de category kunnen inklappen
							if (!empty($filter['children'])) {
								echo '<span class="toggle" title="' . _('Collapse filter') . '" onclick="toggleFilter(this)">&nbsp;</span>';
							} # if
	
							# show the inclusive filter
							echo '<span onclick="gotoFilteredCategory(\'' . $strFilterInclusive . '\')" class="inclusive" title="' . _('Include current search terms') . '"> <i class="fa fa-plus pull-right"></i></span>';
							echo '</a></td>';
				
							# Als er children zijn, output die ook
							if (!empty($filter['children'])) {
								processFilters($tplHelper, $count_newspots, $filter['children']);
							} # if
						} # foreach
					} # processFilters
	
					processFilters($tplHelper, $count_newspots, $filters);
					?>
					</table>
				</div>
			</div>
			
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Informatie</h3>
				</div>
				<div class="panel-body">
					<?php if ($tplHelper->allowed(SpotSecurity::spotsec_view_spotcount_total, '')) { ?>
					<i class="fa fa-clock-o"></i> <?php echo _('Last update:'); ?> <?php echo $tplHelper->formatDate($tplHelper->getLastSpotUpdates(), 'lastupdate'); ?>
					<?php } ?>
				</div>
			</div>
		</div>
		

	
		
<?php
    SpotTiming::stop('tpl:filters');
