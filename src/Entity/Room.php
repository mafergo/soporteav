<?php

namespace US\Soporteav\Entity;
use US\Soporteav\Entity\Issue\Issue;

/**
 * @Entity 
 * @table(name="tbl_room")
 **/
class Room
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="\US\Soporteav\Entity\Area", inversedBy="rooms")
     * @var Area
     */
    private $area;

    /**
     * @Column(type="integer")
     * @var integer
     */
    private $area_id;

    /**
     * @ManyToMany(targetEntity="\US\Soporteav\Entity\Center", inversedBy="rooms")
     * @JoinTable(name="room_center")
     *
     *
     *     joinColumns={@JoinColumn(name="room_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="center_id", referencedColumnName="id")}
     *
     */
    private $centers;

    /**
     * @Column(type="integer")
     * @var integer
     */
    private $disabled;

    /**
     * @Column(type="string")
     * @var string
     */
    private $room_name;

    /**
     * @Column(type="string")
     * @var string
     */
    private $sort_key;

    /**
     * @Column(type="string")
     * @var string
     */
    private $description;

    /**
     * @Column(type="integer")
     * @var int
     */
    private $capacity;
    
    /**
     * @OneToMany(targetEntity="\US\Soporteav\Entity\Issue\Issue", mappedBy="room")
     * @var Issue[]
     */
    private $issues;

    /**
     * @OneToMany(targetEntity="\US\Soporteav\Entity\Projector", mappedBy="room")
     * @var Projector[]
     */
    private $projectors;

    /**
     * @OneToMany(targetEntity="\US\Soporteav\Entity\Microphone", mappedBy="room")
     * @var Microphone[]
     */
    private $microphones;

    /**
     * @OneToMany(targetEntity="\US\Soporteav\Entity\Pc", mappedBy="room")
     * @var Pc[]
     */
    private $pcs;







    

    /**
     * @param array $data
     */
    function __construct($data)
    {
        $this->area = $data['area'];
        //$this->center = $data['center'];
        $this->disabled = $data['disabled'];
        $this->area_id = $data['$area_id'];
        $this->room_name = $data['$room_name'];
        $this->sort_key = $data['$sort_key'];
        $this->description = $data['description'];
        $this->capacity = $data['capacity'];
        //$this->center = $data['center'];
        //$this->rooms = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * @return area
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * @param int $disabled
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
    }

    /**
     * @return int
     */
    public function getArea_id()
    {
        return $this->area_id;
    }

    /**
     * @param int $area_id
     */
    public function setArea_id($area_id)
    {
        $this->area_id = $area_id;
    }

     /**
     * @return string
     */
    public function getRoom_name()
    {
        return $this->room_name;
    }

    /**
     * @param string $room_name
     */
    public function setRoom_name($room_name)
    {
        $this->$room_name = $room_name;
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
     * @return int
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param int $capacity
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @return string
     */
    public function getSortKey()
    {
        return $this->sort_key;
    }

    /**
     * @param string $sort_key
     */
    public function setSortKey($sort_key)
    {
        $this->sort_key = $sort_key;
    }

    /**
     * @return Issue[]
     */
    public function getIssues()
    {
        return $this->issues;
    }

    /**
     * @param Issue[] $issues
     */
    public function setIssues($issues)
    {
        $this->issues = $issues;
    }

    /**
     * @return Projector[]
     */
    public function getProjectors()
    {
        return $this->projectors;
    }

    /**
     * @param Projector[] $projectors
     */
    public function setProjectors($projectors)
    {
        $this->projectors = $projectors;
    }

    /**
     * @return Microphone[]
     */
    public function getMicrophones()
    {
        return $this->microphones;
    }

    /**
     * @param Microphone[] $microphones
     */
    public function setMicrophones($microphones)
    {
        $this->microphones = $microphones;
    }

    /**
     * @return Pc[]
     */
    public function getPcs()
    {
        return $this->pcs;
    }

    /**
     * @param Pc[] $pcs
     */
    public function setPcs($pcs)
    {
        $this->pcs = $pcs;
    }


    /**
     * @return Center[]
     */
    public function getCenters()
    {
        return $this->centers;
    }

    /**
     * @param Center[] $center
     */
    public function setCenter($center)
    {
        $this->center = $center;
    }



}