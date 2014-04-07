<?php
	// Omdat we nu op meerdere criteria tegelijkertijd kunnen zoeken is dit onmogelijk
	// om 100% juist in de UI weer te geven. We doen hierdoor een gok die altijd juist
	// is zolang je maar zoekt via de UI.
	// Voor uitgebreide filters tonen we een lijst met op dat moment actieve filters
	$searchType = 'Title';
	$searchText = '';
	
	# Zoek nu een filter op dat eventueel matched, dan gebruiken we die. We willen deze 
	# boom toch doorlopen ook al is er meer dan 1 filter, anders kunnen we de filesize
	# en reportcount niet juist zetten
    $textSearchCount = 0;
    foreach($parsedsearch['filterValueList'] as $filterType) {
		if (in_array($filterType['fieldname'], array('Titel', 'Title', 'Poster', 'Tag', 'SpotterID', 'CollectionId', 'Collection', 'Season', 'Episode', 'Year'))) {
			$searchType = $filterType['fieldname'];
			$searchText = $filterType['value'];
            $textSearchCount++;
		} elseif ($filterType['fieldname'] == 'filesize' && $filterType['operator'] == ">") {
			$minFilesize = $filterType['value'];
		} elseif ($filterType['fieldname'] == 'filesize' && $filterType['operator'] == "<") {
			$maxFilesize = $filterType['value'];
		} elseif ($filterType['fieldname'] == 'reportcount' && $filterType['operator'] == "<=") {
			$maxReportCount = $filterType['value'];
		} elseif ($filterType['fieldname'] == 'date') {
			$ageFilter = $filterType['operator'] . $filterType['value'];
		} # if
	} # foreach

	# Als er een sortering is die we kunnen gebruiken, dan willen we ook dat
	# in de UI weergeven
	$tmpSort = $tplHelper->getActiveSorting();
	$sortType = strtolower($tmpSort['friendlyname']);
	$sortOrder = strtolower($tmpSort['direction']);
	
	/*
	 * Als er geen sorteer volgorde opgegeven is door de user, dan gebruiken we de user
	 * preference om een sorteerveld te pakken
	 */	
	if (empty($sortType)) {
		$sortType = $currentSession['user']['prefs']['defaultsortfield'];
	} # if

	# als er meer dan 1 filter is, dan tonen we dat als een lijst
	if ($textSearchCount > 1) {
		$searchText = '';
		$searchType = 'Title';
	} # if

	# Zorg er voor dat de huidige filterwaardes nog beschikbaar zijn
	foreach($parsedsearch['filterValueList'] as $filterType) {
		if (in_array($filterType['fieldname'], array('Titel', 'Title', 'Poster', 'Tag', 'SpotterID', 'CollectionId', 'Collection', 'Season', 'Episode', 'Year'))) {
			echo '<input data-currentfilter="true" type="hidden" name="search[value][]" value="' . $filterType['fieldname'] . ':=:'  . htmlspecialchars($filterType['booloper']) . ':' . htmlspecialchars($filterType['value'], ENT_QUOTES, 'utf-8') . '">';
		} # if
	} # foreach
?>
