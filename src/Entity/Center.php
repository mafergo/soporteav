<?php

namespace US\Soporteav\Entity;
//use Entity\Center;

/**
 * @Entity 
 * @table(name="tbl_center")
 **/
class Center
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
     * @Column(type="string")
     * @var string
     */
    private $description;


    /**
     * @OneToMany(targetEntity="\US\Soporteav\Entity\Room", mappedBy="center")
     * @var Room[]
     */
    private $rooms;

    /**
     * @ManyToOne(targetEntity="\US\Soporteav\Entity\Unittech", inversedBy="centers")
     * @var Unittech
     */
    private $unittech;
    

    /**
     * @param array $data
     */
    function __construct($data)
    {
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->unittech = $data['unittech'];
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

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Unittech
     */
    public function getUnittech()
    {
        return $this->unittech;
    }

    /**
     * @param Unittech $unittech
     */
    public function setUnittech($unittech)
    {
        $this->unittech = $unittech;
    }

}