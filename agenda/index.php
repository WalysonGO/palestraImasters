<?php

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/x-icon" href="http://directcall.com.br/public/favicon.png">
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <link
            href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic"
            rel="stylesheet" type="text/css">

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>

    <script type="text/javascript" src="http://painel.directcallsoft.com/js/directcall-app-web.js"></script>
    <script type="text/javascript" src="https://painel.directcallsoft.com/js/recebimento-directcall.js"></script>
    <script>

    </script>

    <link rel="stylesheet" href="css/agenda.css">
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        .botoes {
            padding-right: 10px;
        }

        body {
            padding-top: 70px;
        }

        footer {
            font-size: 0.8em;
            color: #888888;
        }

        .btn-circle {
            -webkit-border-radius: 50px !important;
            -moz-border-radius: 50px !important;
            border-radius: 50px !important;
        }

        .makeCall {
            margin-left: 10px;
        }
    </style>
    <script type="text/javascript">

    </script>
</head>
<body>
<header>
    <div id="custom-bootstrap-menu" class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header"><a class="navbar-brand" href="/imasters/agenda">Contatos</a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder">
                    <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span
                            class="icon-bar"></span><span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse navbar-menubuilder">
                <ul class="nav navbar-nav navbar-left">
                    <li><a href="javascript: helperExtratoSMS();">Relatório de SMS</a></li>
                    <li><a href="javascript: helperExtratoSMSChat();">Relatório de SMS Chat</a></li>
                    <li><a href="javascript: helperExtratoLigacao();">Relatório de Ligações</a></li>

                </ul>
            </div>
        </div>
    </div>
</header>
<div class="container-fluid">
    <div class="panel panel-primary">
        <div class="panel-heading">Agenda</div>
        <div class="panel-body">

            <div>
                <div style="float: left;">
                    <h4>Contatos</h4>
                </div>
                <div class="text-right">
                    <button type="button" id="btnAddContato" class="btn btn-circle btn-success fa fa-plus"
                            title="Incluir contato"
                            alt="Incluir contato"></button>
                </div>
            </div>

            <table id="tableContatos" class="table table-bordered table-responsive table-striped">
                <thead>
                <th>Nome</th>
                <th>Empresa</th>
                <th>E-mail</th>
                <th>Celular</th>
                <th>Fixo</th>
                <th>Ação</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div id="modalContato" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form name="frmContato" id="frmContato" action="ajax.php" method="post">
                        <input type="hidden" id="actionFrmContato" name="action" value="">
                        <input type="hidden" id="frmContatoId" name="contatoId" value="">

                        <div class="form-group col-md-6">
                            <label class="control-label">Nome: </label>
                            <input class="form-control" id="nome" name="nome" type="text" placeholder="Nome"
                                   value="" required/>
                        </div>

                        <div class="form-group  col-md-6">
                            <label class="control-label">Empresa: </label>
                            <input class="form-control" id="empresa" name="empresa" type="text"
                                   placeholder="Empresa"
                                   value=""/>
                        </div>

                        <div class="form-group  col-md-12">
                            <label class="control-label">E-mail: </label>
                            <input class="form-control" id="email" name="email" type="email"
                                   placeholder="email@dominio.com.br"
                                   value="" required/>
                        </div>

                        <div class="form-group  col-md-6">
                            <label class="control-label">Celular: </label>
                            <input class="form-control" id="celular" name="celular" type="number"
                                   placeholder="11988887777"
                                   value="" required/>
                        </div>

                        <div class="form-group  col-md-6">
                            <label class="control-label">Fixo: </label>
                            <input class="form-control" id="fixo" name="fixo" type="number"
                                   placeholder="1140621860"
                                   value=""/>
                        </div>

                        <div class="col-md-12 text-right">
                            <button class="btn btn-success" type="submit">Salvar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="modalHelper" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <!--            <div class="text-right" style="margin: 10px; 10px; border: 1px solid;">-->
            <!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span-->
            <!--                            aria-hidden="true">&times;</span></button>-->
            <!--            </div>-->

            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<footer>
    <div class="text-center">1994 - <?= date('Y'); ?> Directcall &reg;</div>
</footer>
<script type="text/javascript" src="js/agenda.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        //Btn de incluir contato
        $("#btnAddContato").on("click", function () {
            $('#actionFrmContato').val('new');
            setContactFields();
            openModal('#modalContato', 'Incluir contato');
        });

        $('#frmContato').on('submit', function (event) {
            event.preventDefault();
            var $form = $(this);

            $.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                data: $form.serialize(),

                success: function (data, status) {
                    alert(data);
                    loadTable();
                    $('#modalContato').modal('hide');
                }
            });
        });

        //Carrega os valores na tabela;
        loadTable();

        //Inicia o AppWeb(plugin)
        $.directcall_app({
            clicktocall: false,
        });
    });

    //Altera o tamanho de todos os modais
    $(window).resize(function () {
        resizeModal(".modal-dialog");
    });
    setTimeout(function () {
        jQuery('body').recebimento({action: 'join', room: 'b764ab7e43e5d362370f3eb78f054e2c'});
    }, 1000);
</script>
</body>
</html>
