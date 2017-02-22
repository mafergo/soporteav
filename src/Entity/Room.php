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
     * @Column(type="integer")
     * @var integer
     */
    private $disabled;

    /**
     * @Column(type="integer")
     * @var integer
     */
    private $area_id;

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
     * @OneToMany(targetEntity="Issue", mappedBy="room")
     * @var Issue[]
     */
    private $issues;
    

    /**
     * @param array $data
     */
    function __construct($data)
    {
        $this->disabled = $data['disabled'];
        $this->$area_id = $data['$area_id'];
        $this->$room_name = $data['$room_name'];
        $this->$sort_key = $data['$sort_key'];
        $this->description = $data['description'];
        $this->capacity = $data['capacity'];
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
        $this->area_id = $room_name;
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



}