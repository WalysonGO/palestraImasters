<?php
include "../class/api.php";


$API = new API;
$accessToken = $API->getAccessToken();

if (isset($_POST["access_token"])) {
    $variaveis = ["token" => $accessToken, "format" => "json", 'action' => 'get-limit'];
    $resultApi = $API->enviaDadosInfo('https://www.directcallsoft.com/api/menu/config/controller.php', $variaveis);
}

include "header.php";
?>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o"></i> Consultar Saldo de Teste
            </div>
            <div class="panel-body">
                <form class="form" method="post">

                    <div class="form-group ">
                        <label class="control-label">Token: </label>
                        <textarea class="form-control" id="access_token"
                                  name="access_token"><?= $accessToken; ?></textarea>
                    </div>
                    <button class="btn btn-primary">Consultar</button>
                </form>
            </div>
        </div>
    </div>
<?php
if (isset($resultApi)) {
    ?>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-send"></i> Informações enviadas
            </div>
            <div class="panel-body" style="overflow: auto;">
                <code>
                    <?php
                    if (isset($resultApi['request'])) {
                        echo htmlspecialchars_decode($resultApi['request']);
                    }
                    ?>
                </code>
            </div>
        </div>
    </div>
    <?php

    if (isset($resultApi['response'])) {

        $response = json_decode($resultApi['response']);
        $bootstrapClass = "success";
        $titulo = "OK";


        if ($response->status != "ok") {
            $bootstrapClass = "danger";
            $titulo = "Erro";
        }
        $responseConsulta = $response;
        ?>
        <div class="col-md-12">
            <div class="panel panel-<?= $bootstrapClass; ?>">
                <div class="panel-heading">
                    <i class="fa fa-cloud-download"></i> Resposta Servidor - <?= $titulo; ?>
                </div>
                <div class="panel-body" style="overflow: auto;">
                    <ul>
                        <li>Reposta Detalhada
                            <ul>
                                <li>status => <?= $response->status; ?></li>
                                <li>msg => <?= $response->msg; ?></li>
                                <li>data =>
                                    <ul>
                                        <li> recursos =>
                                            <ul>
                                                <?php
                                                foreach ($response->data->recursos as $indice => $value) {
                                                    ?>
                                                    <li><?= sprintf("%s => %s", $indice, $value); ?></li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </li>

                    </ul>
                    <ul>
                        <li>
                            Resposta JSON
                            <ul>
                                <li> <?= $resultApi['response']; ?></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }
}
include "footer.php";