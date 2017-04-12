<?php
include "../class/api.php";
$API = new API;
$accessToken = $API->getAccessToken();

if (isset($_POST["origem"])) {

    $variaveis = ["origem" => $_POST["origem"],
        "destino" => $_POST["destino"],
        "texto" => $_POST["texto"],
        "gravar" => $_POST["gravar"],
        "inverter_discagem" => $_POST["inverter_discagem"],
        "access_token" => $accessToken,
        "format" => "json"];
    $resultApi = $API->enviaDadosInfo('https://api.directcallsoft.com/voz/call', $variaveis);
}

include "header.php";
?>

    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-phone"></i> Fazer ligação
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
                        <label class="control-label">Gravar a ligação ?</label>
                        <select name="gravar " class="form-control">
                            <option value="n" <?= (isset($_POST["gravar"]) || $_POST["gravar "] == "n") ? ' SELECTED ' : ''; ?>>Não</option>
                            <option value="s" <?= ($_POST["gravar"] == "s") ? ' SELECTED ' : ''; ?>>
                            Sim
                            </option>
                        </select>
                    </div>

                    <div class="form-group ">
                        <label class="control-label">Inverter a primeira chamada ?</label>
                        <select name="inverter_discagem" id="inverter_discagem" class="form-control">
                            <option value="n" <?= (isset($_POST["inverter_discagem"]) || $_POST["inverter_discagem "] == "n") ? ' SELECTED ' : ''; ?>>Não</option>
                            <option value="s" <?= ($_POST["inverter_discagem"] == "s") ? ' SELECTED ' : ''; ?>>
                            Sim
                            </option>
                        </select>
                        <span class="help-block">
                            Ao inverter a chamada o destino é chamado primeiro e depois a origem.
                        </span>
                    </div>

                    <div class="form-group ">
                        <label class="control-label">
                            Access Token: </label>
                        <textarea class="form-control"><?= $accessToken; ?></textarea>
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