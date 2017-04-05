<?php

namespace US\Soporteav\Entity\Issue;

use US\Soporteav\Entity\Room;

/**
 * @Entity 
 * @table(name="tbl_issue")
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
     * @ManyToOne(targetEntity="Category", inversedBy="issues")
     * @var Category
     */
    private $category;

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
     * @Column(type="string")
     * @var string
     */
    private $description;

    /**
     * @Column(type="string")
     * @var string
     */
    private $encryptedId;
    
    /**
     * @ManyToOne(targetEntity="\US\Soporteav\Entity\Room", inversedBy="issues")
     * @var Room
     */
    private $room;
    
    /**
     * @Column(type="integer")
     * @var int
     */
    private $state_id;

    /**
     * @Column(type="integer")
     * @var int
     */
    private $user_id;

    /**
     * @ManyToOne(targetEntity="\US\Soporteav\Entity\Person", inversedBy="issues")
     * @var Person
     */
    private $user;
    

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
        $this->category = $data['category'];
        $this->user_id = $data['user_id'];
        $this->user = $data['user'];
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
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
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

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


}