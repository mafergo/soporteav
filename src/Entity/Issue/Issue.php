<?php

namespace US\Soporteav\Entity\Issue;

use US\Soporteav\Entity\Room;

/**
 * @Entity 
 * @table(name="tbl_incident")
 **/
class Issue
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
    private $encryptedId;


    /**
     * @Column(type="string")
     * @var string
     */
    private $description;

    /**
     * @Column(type="integer")
     * @var int
     */
    private $state_id;

    /**
     * @Column(type="datetime")
     * @var datetime
     */
    private $dateNotification;

    /**
     * @Column(type="datetime")
     * @var datetime
     */
    private $dateResolution;

    /**
     * @ManyToOne(targetEntity="Category", inversedBy="issues")
     * @var Category
     */
    private $category;

    /**
     * @Column(type="integer")
     * @var int
     */
    private $user_id;
    

    /**
     * @param array $data
     */
    function __construct($data)
    {
        $this->encryptedId = $data['encryptedId'];
        $this->room = $data['room'];
        $this->description = $data['description'];
        $this->dateNotification = $data['dateNotification'];
        $this->dateResolution = $data['dateResolution'];
        $this->estado = $data['estado_id'];
        $this->category_id = $data['category_id'];
        $this->user_id = $data['user_id'];
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
    public function getEncryptedId()
    {
        return $this->encryptedId;
    }

    /**
     * @param string $encryptedId
     */
    public function setEncryptedId($encryptedId)
    {
        $this->encryptedId = $encryptedId;
    }

    /**
     * @return Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param Room $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
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
     * @return datetime
     */
    public function getDateNotification()
    {
        return $this->dateNotification;
    }

    /**
     * @param datetime $dateNotification
     */
    public function setDateNotification($dateNotification)
    {
        $this->dateNotification = $dateNotification;
    }

    /**
     * @return datetime
     */
    public function getDateResolution()
    {
        return $this->dateResolution;
    }

    /**
     * @param datetime $dateResolution
     */
    public function setDateResolution($dateResolution)
    {
        $this->dateResolution = $dateResolution;
    }

    /**
     * @return int
     */
    public function getState_id()
    {
        return $this->state_id;
    }

    /**
     * @param int $state_id
     */
    public function setState_id($state_id)
    {
        $this->state_id = $state_id;
    }

    /**
     * @return int
     */
    public function getCategory_id()
    {
        return $this->category_id;
    }

    /**
     * @param int $category_id
     */
    public function setCategory_id($category_id)
    {
        $this->user_id = $category_id;
    }

    /**
     * @return int
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }


}