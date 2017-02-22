<?php
/**
 * Soporteav Project
 * Repository/CenterRepository.php
 */

namespace US\Soporteav\Repository;

use Doctrine\ORM\EntityRepository;
use US\Soporteav\Entity\Center;


/**
 * Class CenterRepository
 */
class CenterRepository extends EntityRepository
{
    /**
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return array Center
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Guarda un Centro en la base de datos
     * @param Center $center
     */
    public function save(Center $center)
    {
        parent::getEntityManager()->persist($center);
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
     * @param Center $center
     */
    public function delete(Center $center)
    {
        parent::getEntityManager()->remove($center);
        parent::getEntityManager()->flush();
    }

    /**
     * Cuenta el número de Centros existente.
     *
     * @return integer Número total de Centros.
     */
    public function count()
    {
        $dql = 'SELECT COUNT(c.id) FROM US\Soporteav\Entity\Center c';
        $query = parent::getEntityManager()->createQuery($dql);
        return $query->getSingleScalarResult();
    }
}