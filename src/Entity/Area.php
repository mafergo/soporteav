<?php

namespace US\Soporteav\Entity;
use US\Soporteav\Entity\Room;

/**
 * @Entity 
 * @table(name="tbl_area")
 **/
class Area
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
    private $area_name;

    /**
     * @OneToMany(targetEntity="\US\Soporteav\Entity\Room", mappedBy="area")
     * @var Room[]
     */
    private $rooms;

    

    /**
     * @param array $data
     */
    function __construct($data)
    {
        $this->disabled = $data['disabled'];
        $this->area_name = $data['$area_name'];
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
    public function getArea_name()
    {
        return $this->area_name;
    }

    /**
     * @param string $room_name
     */
    public function setArea_name($area_name)
    {
        $this->area_id = $area_name;
    }





}