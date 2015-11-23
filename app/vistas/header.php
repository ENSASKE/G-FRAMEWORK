<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximun-scale=1">

    <title><?php if(isset($titulo)){ echo $titulo; } else { echo "Página Principal"; } ?></title>

    <?php 
        $html->includeCss('bootstrap.min');
        $html->includeCss('bootstrap.min.lumen');
        $html->includeCss('bootstrap-theme.min');
        $html->includeCss('font-awesome');
        $html->includeCss('general');

        $html->includeJs('jquery-2.1.4.min');
        $html->includeJs('bootstrap.min');
        $html->includeJs('general');

        if(isset($xajax)){
            $xajax->printJavascript(BASE_PATH . '/public/js/');
        }
    ?>

</head>

<body>
    