<?php
/**
 * Created by PhpStorm.
 * User: mario
 * Date: 1/06/17
 * Time: 18:24
 */

namespace US\Soporteav\Entity\Issue;

/**
 * @Entity
 * @table (name="tbl_issue_state");
 *
 */
class State
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}