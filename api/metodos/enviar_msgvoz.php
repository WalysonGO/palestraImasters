<?php
include "../class/api.php";
$API = new API;
$accessToken = $API->getAccessToken();
if (isset($_POST["origem"])) {

    $variaveis = ["origem" => $_POST["origem"],
        "destino" => $_POST["destino"],
        "texto" => $_POST["texto"],
        "cron" => $_POST["cron"],
        "tipo" => "voz", //TIPO DE MENSAGEM DE TEXTO
        "access_token" => $accessToken,
        "format" => "json"];
    $resultApi = $API->enviaDadosInfo('https://api.directcallsoft.com/sms/send', $variaveis);
}

include "header.php";
?>

    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-volume-control-phone"></i> Enviar Mensagem de Voz
            </div>
            <div class="panel-body">
                <form class="form" method="post">

                    <div class="form-group ">
                        <label class="control-label label-origem">Origem: </label>
                        <input class="form-control" id="origem" name="origem" type="number"
                               placeholder="Ex 554140621860"
                               value="<?= isset($_POST["origem"]) ? $_POST["origem"] : ''; ?>"/ required>
                    </div>

                    <div class="form-group ">
                        <label class="control-label label-destino">Destino: </label>
                        <input class="form-control" id="destino" name="destino" type="number"
                               placeholder="Ex. 5541988887777"
                               value="<?= isset($_POST["destino"]) ? $_POST["destino"] : ''; ?>"/ required>
                    </div>

                    <div class="form-group ">
                        <label class="control-label">Texto: </label>
                        <textarea class="form-control" id="texto" name="texto" rows="3"
                                  placeholder="Digite sua mensagem"></textarea>
                    </div>

                    <div class="form-group ">
                        <label class="control-label">
                            Access Token: </label>
                        <textarea class="form-control"><?= $accessToken; ?></textarea>
                    </div>

                    <div class="form-group ">
                        <label class="control-label">
                            Agendar o envio para: </label>
                        <input class="form-control" id="cron" name="cron" type="datetime"
                               placeholder="Ex. dd-mm-YYYY-HH-ii-ss"
                               value="<?= isset($_POST["cron"]) ? $_POST["cron"] : ''; ?>"/>
                        <span class="help-block">
                           Este campo é opcional. Caso o envio seja imediato, este campo deve estar vazio.
                        </span>
                    </div>



                    <button class="btn btn-primary">Enviar</button>
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
        <div class="col-md-6">
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
                                    if (is_array($value)) {
                                        ?>
                                        <li><?= $field; ?>
                                            <ul>
                                                <?php
                                                foreach ($value as $fieldAux => $valueAux) {
                                                    ?>
                                                    <li><?= $fieldAux; ?> <?= sprintf('=> %s', $valueAux); ?></li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </li>
                                        <?php

                                    } else {
                                        ?>
                                        <li><?= $field; ?> <?= sprintf('=> %s', $value); ?></li>
                                        <?php
                                    }
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