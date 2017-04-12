<?php
include '../botoes.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#af2226">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#af2226">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <link
            href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic"
            rel="stylesheet" type="text/css">

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/api.css">
    <style>
        footer {
            font-size: 0.8em;
            color: #888888;
        }
        #screenBlock {
            display: none;
            position: fixed;
            background-color: #000000;
            opacity: 0.3;
            top: 0!important;
            z-index: 99999999;
        }
    </style>
</head>
<body>
<div id="screenBlock">
    <div class="text-center">Carregando</div>
</div>
<header>
    <header>
        <div id="custom-bootstrap-menu" class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="/imasters/api">API´s</a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse navbar-menubuilder">
                    <ul class="nav navbar-nav navbar-left">
                        <?php
                        foreach ($arrBotoes as $btn) {
                            ?>
                            <li><a href="<?= $btn["programa"];?>"><i class="fa <?= $btn["fa"];?>"></i> <?= $btn["titulo"];?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</header>
<div class="container-fluid">