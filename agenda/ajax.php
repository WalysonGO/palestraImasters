<?php
if ($_POST["action"] == "getToken") {
    include 'class/api.php';
    $api = new API();
    $token = $api->getAccessToken();
    die(json_encode(["token" => $token]));
}

include "class/Database.php";
$conn = Database::conect();

if ($_POST["action"] == "read") {
    $sql = "SELECT id, nome, empresa, email, celular, fixo, criado_em, alterado_em 
                FROM 
                  agenda.contatos
                WHERE id > 0 ORDER BY nome, empresa";
    $rs = $conn->prepare($sql);
    $rs->execute();

    die(json_encode($rs->fetchAll(PDO::FETCH_ASSOC)));
}

if ($_POST["action"] == "new") {
    $sql = "INSERT INTO agenda.contatos (nome, empresa, email, celular, fixo, criado_em, alterado_em) VALUES (:nome, :empresa, :email, :celular, :fixo, NOW(), NOW())";
    $rs = $conn->prepare($sql);
    $rs->bindParam(':nome', $_POST["nome"]);
    $rs->bindParam(':empresa', $_POST["empresa"]);
    $rs->bindParam(':email', $_POST["email"]);
    $rs->bindParam(':celular', $_POST["celular"]);
    $rs->bindParam(':fixo', $_POST["fixo"]);
    if ($rs->execute()) {
        $json = json_encode(["status" => "OK", "msg" => "Contato incluído com sucesso"]);
    } else {
        $json = json_encode(["status" => "ER", "msg" => "Erro ao incluir o contato"]);
    }
    die($json);
}

if ($_POST["action"] == "cons") {
    $sql = "SELECT id, nome, empresa, email, celular, fixo, criado_em, alterado_em 
                FROM 
                  agenda.contatos
                WHERE id = ?";
    $rs = $conn->prepare($sql);
    $rs->execute([$_POST['contatoId']]);
    die(json_encode($rs->fetchAll(PDO::FETCH_ASSOC)[0]));
}

if ($_POST["action"] == "alter") {
    $stmt = $conn->prepare('UPDATE agenda.contatos SET nome = :nome, empresa = :empresa, email = :email, celular = :celular, fixo = :fixo, alterado_em = NOW() WHERE id = :id');
    $stmt->execute(array(
        ':id' => $_POST["contatoId"],
        ':nome' => $_POST["nome"],
        ':empresa' => $_POST["empresa"],
        ':email' => $_POST["email"],
        ':celular' => $_POST["celular"],
        ':fixo' => $_POST["fixo"],
    ));

    if ($stmt->rowCount() > 0) {
        $json = json_encode(["status" => "OK", "msg" => "Contato alterado com sucesso"]);
    } else {
        $json = json_encode(["status" => "ER", "msg" => "Erro ao alterar o contato"]);
    }
    die($json);
}

if ($_POST["action"] == "delete") {
    $stmt = $conn->prepare('DELETE FROM agenda.contatos WHERE id = ?');
    $stmt->execute([$_POST["contatoId"]]);

    if ($stmt->rowCount() > 0) {
        $json = json_encode(["status" => "OK", "msg" => "Contato excluído com sucesso"]);
    } else {
        $json = json_encode(["status" => "ER", "msg" => "Erro ao excluir o contato"]);
    }
    die($json);
}