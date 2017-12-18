<?php

namespace App;

use ActiveResourceBase;
use CurlTransporter;
use JsonSerializer;
use TypeMarshaller;


class Synchro extends ActiveResourceBase
{
    public $site = 'http://intranet.cpnv.ch/';
    protected $app_key = "demo";
    protected $app_secret = "secret";

    static $marshaller;

    function __construct($data = []) {
        if (!$this->transporter) $this->transporter = new CurlTransporter();
        if (!$this->serializer) $this->serializer = new JsonSerializer(self::$marshaller);

        parent::__construct($data);
    }
}

Synchro::$marshaller = new TypeMarshaller([
    'Cpnv::Student' => 'User',
    'Cpnv::FormerStudent' => 'User',
    'Cpnv::CurrentStudent' => 'User',
    'Cpnv::Collaborator' => 'User',
    'Cpnv::Teacher' => 'User',
    'Cpnv::HeadTeacher' => 'User',
    'Cpnv::Dean' => 'User',
    'Class' => 'Qlass'
]);