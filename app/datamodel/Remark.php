<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 25.11.17
 * Time: 11:44
 */

namespace App\Datamodel;

class Remark
{
    private $timestamp;
    private $person;
    private $text;

    /**
     * Remark constructor.
     * @param $timestamp
     * @param $person
     * @param $text
     */
    public function __construct($timestamp, $person, $text)
    {
        $this->timestamp = $timestamp;
        $this->person = $person;
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return mixed
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @param mixed $person
     */
    public function setPerson($person)
    {
        $this->person = $person;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }


}