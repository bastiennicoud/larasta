<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 31.12.17
 * Time: 09:37
 */

namespace CPNVEnvironment;


// Differs from PHI's IntranetUser class for now because it doesn't hold the stuff I need at this point
class IntranetUser
{
    private $initials;  // CPNV style
    private $level;     // 0=student, 1=teacher, 2=MP/deacon and higher
    private $id;        // Intranet_user_id

    /**
     * IntranetUser constructor.
     *
     */
    public function __construct()
    {
        $this->level = 0;
    }

    /**
     * @return mixed
     */
    public function getInitials()
    {
        return $this->initials;
    }

    /**
     * @param mixed $initials
     */
    public function setInitials($initials)
    {
        $this->initials = substr(strtoupper($initials),0,3);
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


}