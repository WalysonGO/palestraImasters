<?php
include "../class/api.php";
$API = new API;
$accessToken = $API->getAccessToken();

if (isset($_POST["numero"])) {
    $variaveis = ["numero" => $_POST["numero"], "access_token" => $accessToken, "format" => "json"];
    $resultApi = $API->enviaDadosInfo('https://api.directcallsoft.com/portabilidade/consultar', $variaveis);
}

include "header.php";
?>

    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-exchange"></i> Portabilidade
            </div>
            <div class="panel-body">
                <form class="form" method="post">

                    <div class="form-group ">
                        <label class="control-label " for="status_venda_cod">Número de telefone: </label>
                        <input class="form-control" id="numero" name="numero" type="number"
                               placeholder="Ex. 41988887777"
                               value="<?= isset($_POST["numero"]) ? $_POST["numero"] : ''; ?>"/ required>
                    </div>

                    <div class="form-group ">
                        <label class="control-label">
                            Access Token: </label>
                        <textarea class="form-control"><?= $accessToken; ?></textarea>
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