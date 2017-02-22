<?php

namespace US\Soporteav\Entity;
//use Entity\Projector;

/**
 * @Entity 
 * @table(name="tbl_projector")
 **/
class Projector
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
    private $room;

    /**
     * @Column(type="string")
     * @var string
     */
    private $room_id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $brand;


    /**
     * @Column(type="string")
     * @var string
     */
    private $model;


    /**
     * @Column(type="string")
     * @var string
     */
    private $projectorIp;


    /**
     * @Column(type="string")
     * @var string
     */
    private $projectorEthernet;

    /**
     * @Column(type="integer")
     * @var int
     */
    private $pc_id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $projectorRoseta;

    /**
     * @Column(type="string")
     * @var string
     */
    private $serialNum;

    /**
     * @Column(type="string")
     * @var string
     */
    private $ref;

    /**
     * @Column(type="string")
     * @var string
     */
    private $inventory;

    /**
     * @Column(type="datetime")
     * @var datetime
     */
    private $datePurchase;

    /**
     * @param array $data
     */
    function __construct($data)
    {
        $this->room = $data['room'];
        $this->room_id = $data['room_id'];
        $this->brand = $data['brand'];
        $this->model = $data['model'];
        $this->projectorIp = $data['projectorIp'];
        $this->projectorEthernet = $data['projectorEthernet'];
        $this->pc_id = $data['pc_id'];
        $this->projectorRoseta = $data['projectorRoseta'];
        $this->serialNum = $data['serialNum'];
        $this->ref = $data['ref'];
        $this->inventory = $data['inventory'];
        $this->datePurchase = $data['datePurchase'];
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
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @return int
     */
    public function getRoom_id()
    {
        return $this->room_id;
    }

    /**
     * @param string $brand
     */
    public function setRoom_id($room_id)
    {
        $this->brand = $room_id;
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param string $firstName
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getProjectorIp()
    {
        return $this->projectorIp;
    }

    /**
     * @param string $description
     */
    public function setProjectorIp($projectorIp)
    {
        $this->projectorIp = $projectorIp;
    }

    /**
     * @return string
     */
    public function getProjectorEthernet()
    {
        return $this->projectorEthernet;
    }

    /**
     * @param string $description
     */
    public function setProjectorEthernet($projectorEthernet)
    {
        $this->projectorEthernet = $projectorEthernet;
    }

    /**
     * @return int
     */
    public function getPc_id()
    {
        return $this->pc_id;
    }

    /**
     * @param int $pc_id
     */
    public function setPc_id($pc_id)
    {
        $this->pc_id = $pc_id;
    }

    /**
     * @return string
     */
    public function getProjectorRoseta()
    {
        return $this->projectorRoseta;
    }

    /**
     * @param string $projectorRoseta
     */
    public function setProjectorRoseta($projectorRoseta)
    {
        $this->projectorRoseta = $projectorRoseta;
    }

    /**
     * @return string
     */
    public function getSerialNum()
    {
        return $this->serialNum;
    }

    /**
     * @param string $serialNum
     */
    public function setSerialNum($serialNum)
    {
        $this->serialNum = $serialNum;
    }
    
    /**
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    }
 
    /**
     * @return string
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * @param string $inventory
     */
    public function setInventory($inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     * @return datetime
     */
    public function getDatePurchase()
    {
        return $this->datePurchase;
    }

    /**
     * @param datetime $datePurchase
     */
    public function setDatePurchase($datePurchase)
    {
        $this->datePurchase = $datePurchase;
    }

}