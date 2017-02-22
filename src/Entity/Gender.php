<?php
/**
 * Project portus - Entity/Gender.php
 * 
 * Developed by Juanan Ruiz <juanan@us.es>
 * Created 10/5/16 - 21:57
 */

/*namespace Entity;*/
namespace US\Soporteav\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class Gender
 * @Entity
 * @UniqueEntity(fields="{description}", message="This gender exists yet.")
 */
class Gender
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column (type="string")
     * @var string
     */
    private $description;

    /**
     * @param array $data
     */
    function __construct($data)
    {
        $this->description = $data['description'];
    }

    /**
     * @param ClassMetadata $metadata
     */
    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
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