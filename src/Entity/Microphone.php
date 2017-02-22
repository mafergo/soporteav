<?php

namespace US\Soporteav\Entity;
//use Entity\Microphone;

/**
 * @Entity 
 * @table(name="tbl_microphone")
 **/
class Microphone
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
    private $ip;


    /**
     * @Column(type="string")
     * @var string
     */
    private $ethernet;

    /**
     * @Column(type="string")
     * @var string
     */
    private $roseta;

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
        $this->ip = $data['ip'];
        $this->ethernet = $data['ethernet'];
        $this->microphone_id = $data['microphone_id'];
        $this->roseta = $data['roseta'];
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
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return string
     */
    public function getEthernet()
    {
        return $this->ethernet;
    }

    /**
     * @param string $ethernet
     */
    public function setEthernet($ethernet)
    {
        $this->ethernet = $ethernet;
    }

    /**
     * @return string
     */
    public function getRoseta()
    {
        return $this->roseta;
    }

    /**
     * @param string $roseta
     */
    public function setRoseta($roseta)
    {
        $this->roseta = $roseta;
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