<?php

namespace US\Soporteav\Entity\Issue;
//use Entity\Category;

/**
 * @Entity 
 * @table(name="tbl_incidencias_categorias")
 **/
class Category
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
     * @OneToMany(targetEntity="Issue", mappedBy="category")
     * @var Issue[]
     */
    private $Issues;

    /**
     * @param array $data
     */
    function __construct($data)
    {
        $this->name = $data['name'];
        $this->description = $data['description'];
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
     * @param string $firstName
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
     * @param string $lastName
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

}