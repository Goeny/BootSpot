<?php
class SpotTemplateHelper_Bootspot extends SpotTemplateHelper {

	/*
	 * Return a list of preferences specific for this template.
	 *
	 * When a user changes their template, and changes their
	 * preferences these settings are lost.
	 *
	 * Settings you want to be able to set must always be 
	 * present in this array with a sane default value, else
	 * the setting will not be saved.
	 */
	function getTemplatePreferences() {
		return array('bootspot' =>
						array('example_setting' => 1)
					);
	} # getTemplatePreferences

	function cat2CssClass($spot) {
        $categoryCss = 'spotcat' . $spot['category'];
        if (!empty($spot['subcatz'])) {
            $categoryCss .= ' spotcat' . $spot['category'] . '_' . substr($spot['subcatz'], 0, -1);
        } # if

		return $categoryCss;
	} # cat2CssClass
	
	function filter2cat($s) {
		$cat = 0;
		if (stripos($s, 'cat0') !== false) {
			return "info";
		} elseif (stripos($s, 'cat1') !== false) {
			return "danger";
		} elseif (stripos($s, 'cat2') !== false) {
			return "success";
		} elseif (stripos($s, 'cat3') !== false) {
			return "warning";
		} # else

        return "N/A";
	} # filter2cat

	function getFilterIcons() {
		return array(
					'application'		=> _('Application'),
					'bluray'			=> _('Blu-Ray'),
					'book'				=> _('Book'),
					'controller'		=> _('Game'),
					'custom'			=> _('Plain'),
					'divx'				=> _('DivX'),
					'female'			=> _('Erotica'),
					'film'				=> _('Movie'),
					'hd'				=> _('HD'),
					'ipod'				=> _('iPod'),
					'linux'				=> _('Linux'),
					'apple'				=> _('Apple'),
					'mpg'				=> _('MPEG'),
					'music'				=> _('Music'),
					'nintendo_ds'		=> _('Nintendo DS'),
					'nintendo_wii'		=> _('Nintendo Wii'),
					'phone'				=> _('Phone'),
					'picture'			=> _('Picture'),
					'playstation'		=> _('Playstation'),
					'tv'				=> _('TV'),
					'vista'				=> _('Vista'),
					'windows'			=> _('Windows'),
					'wmv'				=> _('WMV'),
					'xbox'				=> _('Xbox'),
					'dvd'				=> _('DVD'),
					'pda'				=> _('PDA')
		);
	} # getFilterIconList

	function getSmileyList() {
		return array('biggrin' => 'templates/bootspot/smileys/biggrin.gif',
				'bloos' => 'templates/bootspot/smileys/bloos.gif',
				'buigen' => 'templates/bootspot/smileys/buigen.gif',
				'censored' => 'templates/bootspot/smileys/censored.gif',
				'clown' => 'templates/bootspot/smileys/clown.gif',
				'confused' => 'templates/bootspot/smileys/confused.gif',
				'cool' => 'templates/bootspot/smileys/cool.gif',
				'exactly' => 'templates/bootspot/smileys/exactly.gif',
				'frown' => 'templates/bootspot/smileys/frown.gif',
				'grijns' => 'templates/bootspot/smileys/grijns.gif',
				'heh' => 'templates/bootspot/smileys/heh.gif',
				'huh' => 'templates/bootspot/smileys/huh.gif',
				'klappen' => 'templates/bootspot/smileys/klappen.gif',
				'knipoog' => 'templates/bootspot/smileys/knipoog.gif',
				'kwijl' => 'templates/bootspot/smileys/kwijl.gif',
				'lollig' => 'templates/bootspot/smileys/lollig.gif',
				'maf' => 'templates/bootspot/smileys/maf.gif',
				'ogen' => 'templates/bootspot/smileys/ogen.gif',
				'oops' => 'templates/bootspot/smileys/oops.gif',
				'pijl' => 'templates/bootspot/smileys/pijl.gif',
				'redface' => 'templates/bootspot/smileys/redface.gif',
				'respekt' => 'templates/bootspot/smileys/respekt.gif',
				'schater' => 'templates/bootspot/smileys/schater.gif',
				'shiny' => 'templates/bootspot/smileys/shiny.gif',
				'sleephappy' => 'templates/bootspot/smileys/sleephappy.gif',
				'smile' => 'templates/bootspot/smileys/smile.gif',
				'uitroepteken' => 'templates/bootspot/smileys/uitroepteken.gif',
				'vlag' => 'templates/bootspot/smileys/vlag.gif',
				'vraagteken' => 'templates/bootspot/smileys/vraagteken.gif',
				'wink' => 'templates/bootspot/smileys/wink.gif');
	} # getSmileyList
	
	# Geeft een lijst van onze static files terug die door de static page gelezen wordt
	function getStaticFiles($type) {
		switch($type) {
			case 'js'	: {
				return array('js/jquery/jquery.min.js', 
								'js/jquery/jquery-ui.custom.min.js',
								'js/jquery/jquery.cookie.js',
								'js/jquery/jquery.hotkeys.js',
								'js/jquery/jquery.form.js',
								'js/jquery-json/jquery.json-2.3.js',
								'js/sha1/jquery.sha1.js',
                                'templates/bootspot/js/jquery.address.js',
								'js/posting/posting.js',
								'js/dynatree/jquery.dynatree.min.js',
								'templates/bootspot/js/scripts.js',
                                'templates/bootspot/js/spotdialogs.js',
                                'templates/bootspot/js/sabpanel.js',
								'templates/bootspot/js/bootspotpost.js',
								'templates/bootspot/js/treehelper.js',
								'templates/bootspot/js/jquery.ui.nestedSortable.js',
								'templates/bootspot/js/jquery.tipTip.minified.js',
								'templates/bootspot/js/bootstrap-datepicker.js',
								'templates/bootspot/js/bootstrap-switch.min.js'
								);
				break;
			} # case js
						
		} # switch
		
		return array();
	} # getStaticFiles 
	
} # class bootspotTemplateHelper
