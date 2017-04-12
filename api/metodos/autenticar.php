<?php
include "../class/api.php";
$API = new API;
$arrLoginPass = $API->getLoginPass();

if ($arrLoginPass["client_id"] != "") {
    $client_id = $arrLoginPass["client_id"];
    $client_secret = $arrLoginPass["client_secret"];
} else if (isset($_POST["client_id"])) {
    $client_id = $_POST["client_id"];
    $client_secret = $_POST["client_secret"];
}

if (isset($_POST["client_id"])) {
    $variaveis = ["client_id" => $_POST["client_id"], "client_secret" => $_POST["client_secret"], "format" => "json"];
    $resultApi = $API->enviaDadosInfo('https://api.directcallsoft.com/request_token', $variaveis);
}

include "header.php";
?>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-user-o"></i> Autenticação - Resquest Token
            </div>
            <div class="panel-body">
                <form class="form" method="post">

                    <div class="form-group ">
                        <label class="control-label">Login: </label>
                        <input class="form-control" id="client_id" name="client_id" type="email" placeholder="Email"
                               value="<?= isset($client_id) ? $client_id : ''; ?>"/ required>
                    </div>

                    <div class="form-group ">
                        <label class="control-label">Senha </label>
                        <input class="form-control" id="client_secret" name="client_secret" type="text"
                               placeholder="Senha"
                               value="<?= isset($client_secret) ? $client_secret : ''; ?>"/
                        required>
                    </div>

                    <button class="btn btn-primary">Autenticar</button>
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

        if ((int)$response->codigo > 0) {
            $bootstrapClass = "danger";
            $titulo = "Erro";
        }
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
                                <?php
                                foreach ($response as $field => $value) {
                                    ?>
                                    <li><?= $field; ?> <?= sprintf('=> %s', $value); ?></li>
                                    <?php
                                }
                                ?>
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