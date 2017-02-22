<?php
/**
 * Soporteav Project
 * Repository/PersonRepository.php
 */

namespace US\Soporteav\Repository;

use Doctrine\ORM\EntityRepository;
use US\Soporteav\Entity\Person;


/**
 * Class PersonRepository
 */
class PersonRepository extends EntityRepository
{
    /**
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return array Person
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Guarda una persona en la base de datos
     * @param Person $person
     */
    public function save(Person $person)
    {
        parent::getEntityManager()->persist($person);
        parent::getEntityManager()->flush();
    }

    /**
     * @param mixed $id
     * @param null $lockMode
     * @param null $lockVersion
     * @return null|item
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return parent::find($id, $lockMode, $lockVersion);
    }


    /**
     * @param Person $person
     */
    public function delete(Person $person)
    {
        parent::getEntityManager()->remove($person);
        parent::getEntityManager()->flush();
    }

    /**
     * Cuenta el número de personas existente.
     *
     * @return integer Número total de personas.
     */
    public function count()
    {
        $dql = 'SELECT COUNT(p.id) FROM US\Soporteav\Entity\Person p';
        $query = parent::getEntityManager()->createQuery($dql);
        return $query->getSingleScalarResult();
    }
}