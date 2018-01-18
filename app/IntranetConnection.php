<?php
/*
 * Title : IntranetConnection.php
 * Author : Steven Avelino
 * Creation Date : 20 December 2017
 * Modification Date : 15 January 2017
 * Version : 0.3
 * Model to get informations from the intranet API
*/

namespace App;

class IntranetConnection
{
    private $studentsList;
    private $teachersList;
    private $classesList;

    public function generateSignature($params)
    {
        $queryParams = $params . getenv('API_KEY') . getenv('API_SECRET');
        $signature = md5($queryParams);

        return $signature;
    }

    public function __construct($type)
    {
        $connection = curl_init();

        if ($type == "students")
        {
            $url = "http://intranet.cpnv.ch/info/etudiants.json?alter[extra]=current_class&api_key=";
            $urlSign = "alter[extra]current_classapi_key";
        }
        else if ($type == "teachers")
        {
            $url = "http://intranet.cpnv.ch/info/enseignants.json?api_key=";
            $urlSign = "api_key";
        }
        else if ($type == "classes")
        {
            $url = "http://intranet.cpnv.ch/classes.json?api_key=";
            $urlSign = "api_key";
        }

        curl_setopt_array($connection, [
            CURLOPT_URL => $url . getenv('API_KEY') . "&signature=" . $this->generateSignature($urlSign),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "cache-control: no-cache"
            ],
        ]);

        $response = curl_exec($connection);
        if ($type == "students")
        {
            $this->studentsList = json_decode($response, true);
        }
        else if ($type == "teachers")
        {
            $this->teachersList = json_decode($response, true);
        }
        else if ($type == "classes")
        {
            $this->classesList = json_decode($response, true);
        }

        curl_close($connection);
    }

    public function getStudents()
    {
        return $this->studentsList;
    }

    public function getTeachers()
    {
        return $this->teachersList;
    }

    public function getClasses()
    {
        return $this->classesList;
    }
}