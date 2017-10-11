<?php

namespace US\Soporteav\Entity\Issue;

use US\Soporteav\Entity\Person;
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
     * @var \DateTime
     */
    private $dateNotification;

    /**
     * @Column(type="datetime")
     * @var \DateTime
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
     * @ManyToOne(targetEntity="\US\Soporteav\Entity\Issue\State", inversedBy="issues")
     * @var State
     */
    private $state;


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
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
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
     * @return State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param State $state
     */
    public function setState($state)
    {
        $this->state = $state;
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
     * @return \DateTime
     */
    public function getDateNotification()
    {
        return $this->dateNotification;
    }

    /**
     * @param \DateTime $dateNotification
     */
    public function setDateNotification($dateNotification)
    {
        $this->dateNotification = $dateNotification;
    }

    /**
     * @return \DateTime
     */
    public function getDateResolution()
    {
        return $this->dateResolution;
    }

    /**
     * @param \DateTime $dateResolution
     */
    public function setDateResolution($dateResolution)
    {
        $this->dateResolution = $dateResolution;
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
     * @return Person
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