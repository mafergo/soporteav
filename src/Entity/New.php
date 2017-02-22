<?php

namespace US\Soporteav\Entity;
//use Entity\New;

/**
 * @Entity 
 * @table(name="tbl_new")
 **/
class New
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
    private $title;

    /**
     * @Column(type="string")
     * @var string
     */
    private $subtitle;
    

    /**
     * @param array $data
     */
    function __construct($data)
    {
        $this->title = $data['title'];
        $this->subtitle = $data['subtitle'];
    }

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $firstName
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

}