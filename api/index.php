<?php
include 'botoes.php';

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/x-icon" href="http://directcall.com.br/public/favicon.png">
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

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="../agenda/js/agenda.js"></script>

    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/api.css">
    <style>
        .botoes {
            border: 0px solid #000;
            width: 33%;
            float: left;
            text-align: center;
            padding: 15px;
        }

        .botoes > a {
            width: 60%;
        }

        .font-size-3 {
            font-size: 3em;
        }
        .font-size-4 {
            font-size: 4em;
        }
        .font-size-5 {
            font-size: 5em;
        }

        footer {
            font-size: 0.8em;
            color: #888888;
        }
    </style>
    <script>
        var dialog = $('#dialog-op');
        var dialogContent = $('#dialog-op .modal-body');
        dialogContent.html('<div style="text-align: center"><img src="/img/ajax-loader-hex.gif"></div>');
        dialog.modal('show');
//        $.ajax({
//            url: '/operador/historico-pausa/data/'+periodo+'/operador/' + nome+'/id/'+id,
//            method: "POST",
//            dataType: 'html',
//        }).done(function (r) {
//            dialogContent.html(r);
//        }).fail(function (e) {
//            console.log(e);
//        });
    </script>
</head>
<body>
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
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">Selecione a API:</div>
        <div class="panel-body hidden-lg hidden-md">

                <?php
                foreach ($arrBotoes as $btn) {
                    ?>
                    <div style="margin: 10px 0px 0px 0px;">
                        <a class="btn btn-custom btn-custom-short" href="metodos/<?= $btn["programa"];?>"><i class="fa <?= $btn["fa"];?>"
                                                                                            style=""></i> <?= $btn["titulo"];?></a>
                    </div>
                    <?php
                }
                ?>
        </div>
        <div class="panel-body hidden-xs hidden-sm">
            <?php
            foreach ($arrBotoes as $btn) {
             ?>
                <div class="botoes">
                    <a class="btn btn-custom" href="metodos/<?= $btn["programa"];?>"><i class="fa <?= $btn["fa"];?> font-size-5"
                                                                                  style=""></i><br><?= $btn["titulo"];?></a>
                </div>
                <?php
            }
            ?>

        </div>
    </div>
</div>

<div id="dialogAgenda" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<footer>
    <div class="text-center">1994 -<?= date('Y');?> Directcall &reg;</div>
</footer>
</body>
</html>
