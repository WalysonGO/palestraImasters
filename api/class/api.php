<?php

class API
{
    private $apiUrl = "https://api.directcallsoft.com/";

    private $clientId = "adress@email.com";
    private $clientSecret = "password";

    public function getLoginPass()
    {
        return ["client_id" => $this->clientId, "client_secret" => $this->clientSecret];
    }

    public function enviaDados($url, $dados)
    {

        if (is_array($dados)) {
            $dados = http_build_query($dados);
        }

        $curlOptions = array(CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $dados,
        );

        $curlHandle = curl_init();
        curl_setopt_array($curlHandle, $curlOptions);

        $curlResponse = curl_exec($curlHandle);
        $resposta = (curl_errno($curlHandle) > 0) ? curl_error($curlHandle) : $curlResponse;


        return $resposta;
    }

    public function enviaDadosInfo($url, $dados)
    {

        if (is_array($dados)) {
            $dados = http_build_query($dados);
        }

        $curlOptions = array(CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $dados,
        );

        $curlHandle = curl_init();
        curl_setopt_array($curlHandle, $curlOptions);

        $curlResponse = curl_exec($curlHandle);
        $resposta = (curl_errno($curlHandle) > 0) ? curl_error($curlHandle) : $curlResponse;

        $info = implode("<br>", ["url" => $url, "variaveis" => $dados]);

        return ['request' => $info, 'response' => $resposta];
    }

    public function requestToken($client_id, $client_secret)
    {

        $resultado = $this->enviaDados("request_token", array("client_id" => $client_id, "client_secret" => $client_secret, "format" => "json"));
        $resultado = json_decode($resultado, true);
        return $resultado['access_token'];
    }

    public function getAccessToken()
    {
        $resultado = $this->enviaDados("https://api.directcallsoft.com/request_token", array("client_id" => $this->clientId, "client_secret" => $this->clientSecret, "format" => "json"));
        $resultado = json_decode($resultado, true);
        return $resultado['access_token'];
    }

    public function enviarSMS($dados)
    {
        $resultado = $this->enviaDados("sms/send", $dados);
        return json_decode($resultado, true);
    }
}