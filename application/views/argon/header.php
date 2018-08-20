<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">

    <title><?=(isset($ui_title)?$ui_title:'')?></title>

    <!-- Favicon -->
    <link href="<?=site_url('assets/custom/images/konfigurasi/APP_LOGO/' .$app_favicon)?>" rel="icon" type="image/png">
    <!-- Fonts -->
    <!-- Icons -->
    <link href="<?=site_url('assets/argon/vendor/nucleo/css/nucleo.css')?>" rel="stylesheet">
    <link href="<?=site_url('assets/argon/vendor/@fortawesome/fontawesome-free/css/all.min.css')?>" rel="stylesheet">
    
    <!-- Default -->
    <link type="text/css" href="<?=site_url('assets/custom/css/default.css')?>" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="<?=site_url('assets/argon/css/argon.css?v=1.0.0')?>" rel="stylesheet">

    <!-- Dynamic CSS Source -->
    <?php 
        if (isset($ui_css)) {
            if (is_array($ui_css)) {
                foreach ($ui_css as $css) {
                    echo "<link href='" . site_url('assets/' .$css). "' rel='stylesheet' type='text/css'>";
                }
            }
            else {
                echo "<link href='" . site_url('assets/' .$css). "' rel='stylesheet' type='text/css'>";
            }
        }
    ?>
</head>

<body style="background: url('<?=site_url('assets/custom/images/background-logged.jpg')?>')">