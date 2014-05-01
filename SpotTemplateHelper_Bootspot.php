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
		return array(
				'ambilvalent' => 'templates/bootspot/images/smileys/Ambivalent.png',
				'angry' => 'templates/bootspot/images/smileys/Angry.png',
				'confused' => 'templates/bootspot/images/smileys/Confused.png',
				'content' => 'templates/bootspot/images/smileys/Content.png',
				'cool' => 'templates/bootspot/images/smileys/Cool.png',
				'crazy' => 'templates/bootspot/images/smileys/Crazy.png',
				'cry' => 'templates/bootspot/images/smileys/Cry.png',
				'embarrassed' => 'templates/bootspot/images/smileys/Embarrassed.png',
				'footinmouth' => 'templates/bootspot/images/smileys/Footinmouth.png',
				'frown' => 'templates/bootspot/images/smileys/Frown.png',
				'gasp' => 'templates/bootspot/images/smileys/Gasp.png',
				'grin' => 'templates/bootspot/images/smileys/Grin.png',
				'heart' => 'templates/bootspot/images/smileys/Heart.png',
				'hearteyes' => 'templates/bootspot/images/smileys/HeartEyes.png',
				'innocent' => 'templates/bootspot/images/smileys/Innocent.png',
				'kiss' => 'templates/bootspot/images/smileys/Kiss.png',
				'laughing' => 'templates/bootspot/images/smileys/Laughing.png',
				'minifrown' => 'templates/bootspot/images/smileys/Mini-Frown.png',
				'minismile' => 'templates/bootspot/images/smileys/Mini-Smile.png',
				'moneymouth' => 'templates/bootspot/images/smileys/Money-Mouth.png',
				'naughty' => 'templates/bootspot/images/smileys/Naughty.png',
				'nerd' => 'templates/bootspot/images/smileys/Nerd.png',
				'notamused' => 'templates/bootspot/images/smileys/Not-Amused.png',
				'sarcastic' => 'templates/bootspot/images/smileys/Sarcastic.png',
				'sealed' => 'templates/bootspot/images/smileys/Sealed.png',
				'sick' => 'templates/bootspot/images/smileys/Sick.png',
				'slant' => 'templates/bootspot/images/smileys/Slant.png',
				'smile' => 'templates/bootspot/images/smileys/Smile.png',
				'thumbsdown' => 'templates/bootspot/images/smileys/Thumbs-Down.png',
				'thumbsup' => 'templates/bootspot/images/smileys/Thumbs-Up.png',
				'wink' => 'templates/bootspot/images/smileys/Wink.png',
				'yuck' => 'templates/bootspot/images/smileys/Yuck.png',
				'yum' => 'templates/bootspot/images/smileys/Yum.png');
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
