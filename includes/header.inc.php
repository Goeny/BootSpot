<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
	<!-- JQuery -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>
	<!-- FontAwesome -->
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<!-- Bootswatch Latest compiled and minified CSS -->
	<link rel="stylesheet" href="templates/bootspot/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="http://bootswatch.com/assets/css/bootswatch.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<!-- Custom theme related css -->
	<link rel="stylesheet" href="templates/bootspot/css/custom-bootstrap.css">
	
	<!-- Bootstrap switch css and js-->
	<link rel="stylesheet" href="templates/bootspot/css/bootstrap-switch.css">
	<script src="templates/bootspot/js/bootstrap-switch.min.js"></script>
	
	<!-- Bootstrap Lightbox css and js -->
	<link rel="stylesheet" href="templates/bootspot/css/bootstrap-lightbox.min.css">
	<script src="templates/bootspot/js/bootstrap-lightbox.min.js"></script>
	
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
		<title>SpotWeb - <?php echo $pagetitle?></title>
		<meta name="generator" content="SpotWeb v<?php echo SPOTWEB_VERSION; ?>">
		<?php 
			if ($settings->get('deny_robots')) { 
				echo "\t\t<meta name=\"robots\" content=\"noindex, nofollow\">\r\n"; 
			} 
		?>
		<base href='<?php echo $tplHelper->makeBaseUrl("full"); ?>'>
		<?php 
			if ($tplHelper->allowed(SpotSecurity::spotsec_view_rssfeed, '')) { ?>
				<link rel='alternate' type='application/rss+xml' href='<?php echo $tplHelper->makeRssUrl(); ?>'>
		<?php 
			} 
		?>
		<script type='text/javascript'>
			// console.timeEnd("parse-css");
		</script>
		<script type="text/javascript">
$(document).ready(function(){
    $('[rel="tooltip"]').tooltip({
        placement : 'left'
    });
});
</script>
             
	</head>
	<body>
		<div id="overlay"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</div>
		<div class="container" id="container">
