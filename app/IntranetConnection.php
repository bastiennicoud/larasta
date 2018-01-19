<?php
/*
 * Title : IntranetConnection.php
 * Author : Steven Avelino
 * Creation Date : 20 December 2017
 * Modification Date : 19 January 2018
 * Version : 0.4
 * Model to get informations from the intranet API
*/

namespace App;

class IntranetConnection
{
    /**
     * Class attributes
     * $studentsList : This attribute will contain the list of students returned by the intranet
     * $teachersList : This attribute will contain the list of teachers returned by the intranet
     * $classesList : This attribute will contain the list of classes returned by the intranet
     */
    private $studentsList;
    private $teachersList;
    private $classesList;

    /**
     * generateSignature
     * 
     * This method will take the query parameters and then create a signature after hashing it with MD5 to be later sent to the intranet.
     * 
     * @param $params Parameters for the query that will be then requested to the intranet
     * @return string
     */
    public function generateSignature($params)
    {
        $queryParams = $params . getenv('API_KEY') . getenv('API_SECRET');
        $signature = md5($queryParams);

        return $signature;
    }

    /**
     * __construct
     * 
     * The construct method of the class.
     * It uses curl to get JSON from the intranet.
     * The URLs are already addressed, since we know what type of datas we want to get from the intranet.
     * When the curl request is done, it puts the returned datas in the right attribute and closes the curl connection.
     * 
     * 
     * @param $type The type of datas we want to get (ex. students)
     * @return array
     */
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

    /**
     * getStudents
     * 
     * Getter for the attribute $studentsList
     * 
     * @return array
     */
    public function getStudents()
    {
        return $this->studentsList;
    }

    /**
     * getTeachers
     * 
     * Getter for the attribute $teachersList
     * 
     * @return array
     */
    public function getTeachers()
    {
        return $this->teachersList;
    }

    /**
     * getClasses
     * 
     * Getter for the attribute $classesList
     * 
     * @return array
     */
    public function getClasses()
    {
        return $this->classesList;
    }
}