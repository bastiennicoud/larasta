<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 22.01.18
 * Time: 09:10
 */

namespace CPNVEnvironment;


/**
 * Class InternshipFilter
 *
 * Bundles various filtering conditions of different types
 *
 * @package CPNVEnvironment
 */
class InternshipFilter
{
    private $stateFilter;     // array of ids of states in which the internship can be
    private $mine;          // Keep only internships managed by the user currently logged in
    private $inProgress;

    /**
     * @return mixed
     */
    public function getStateFilter()
    {
        return $this->stateFilter;
    }

    /**
     * @param mixed $stateFilter
     */
    public function setStateFilter($stateFilter)
    {
        $this->stateFilter = $stateFilter;
    }

    /**
     * @return mixed
     */
    public function getMine()
    {
        return $this->mine;
    }

    /**
     * @param mixed $mine
     */
    public function setMine($mine)
    {
        $this->mine = $mine;
    }

    /**
     * @return mixed
     */
    public function getInProgress()
    {
        return $this->inProgress;
    }

    /**
     * @param mixed $inProgress
     */
    public function setInProgress($inProgress)
    {
        $this->inProgress = $inProgress;
    }    // internships started before now and ending after now


}