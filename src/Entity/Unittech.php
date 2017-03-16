<?php

namespace US\Soporteav\Entity;
//use Entity\Center;

/**
 * @Entity 
 * @table(name="tbl_unittech")
 **/
class Unittech
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
     * @OneToMany(targetEntity="\US\Soporteav\Entity\Center", mappedBy="unittech")
     * @var Center[]
     */
    private $centers;
    

    /**
     * @param array $data
     */
    function __construct($data)
    {
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->center = $data['center'];
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
     * @param string name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Center[]
     */
    public function getCenters()
    {
        return $this->centers;
    }

    /**
     * @param Center[] $centers
     */
    public function setCenters($centers)
    {
        $this->centers = $centers;
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


}