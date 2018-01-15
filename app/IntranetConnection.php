<?php

namespace App;

class IntranetConnection
{
    private $studentsList;
    private $curlErrors;
    private $http;

    public function generateSignature()
    {
        $queryParams = "alter[extra]current_classapi_key" . getenv('API_KEY') . getenv('API_SECRET');
        $signature = md5($queryParams);

        return $signature;
    }

    public function __construct()
    {
        $connection = curl_init();

        curl_setopt_array($connection, [
            CURLOPT_URL => "http://intranet.cpnv.ch/info/etudiants.json?alter[extra]=current_class&api_key=" . getenv('API_KEY') . "&signature=" . $this->generateSignature(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "cache-control: no-cache"
            ],
        ]);

        $response = curl_exec($connection);
        $this->studentsList = json_decode($response, true);

        curl_close($connection);
    }

    public function getStudents()
    {
        return $this->studentsList;
    }
}