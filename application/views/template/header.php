<!--
	* dibuat oleh 	: M. Badar Wildanie
	* contact 		: 0822-6613-4686 (WA, SMS, LINE, DLL)
	* Jangan merubah source kode dibawah tanpa seizin programmer
	* Hanya boleh dirubah oleh seorang programmer
-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="<?=site_url('assets/custom/images/konfigurasi/APP_LOGO/' . $app_favicon)?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title><?=$ui_title?></title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="<?=site_url('assets/bootstrap-3.3.7/css/bootstrap.css')?>" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="<?=site_url('assets/light-bootstrap-dashboard/css/animate.min.css')?>" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="<?=site_url('assets/light-bootstrap-dashboard/css/light-bootstrap-dashboard.css?v=1.4.0')?>" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?=site_url('assets/light-bootstrap-dashboard/css/demo.css')?>" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="<?=site_url('assets/font-awesome-4.7.0/css/font-awesome.min.css')?>" rel="stylesheet">
    
    <script type="text/javascript" src="<?=site_url('assets/font-awesome-5.0.8/js/fontawesome-all.min.js')?>"></script>
    <link href="<?=site_url('assets/light-bootstrap-dashboard/css/pe-icon-7-stroke.css')?>" rel="stylesheet" />
    <link rel="icon" href="<?=site_url('assets/custom/images/' .$app_favicon)?>">
    <link href="<?=site_url('assets/custom/css/default.css')?>" rel="stylesheet" />

	<?php 
		foreach ($ui_css as $css) {
	?>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/<?=$css?>">
	<?php
		}
	?>
</head>
<body>
	<div class="wrapper">