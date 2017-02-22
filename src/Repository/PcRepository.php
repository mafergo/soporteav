<?php
/**
 * Soporteav Pc
 * Repository/PcRepository.php
 */

namespace US\Soporteav\Repository;

use Doctrine\ORM\EntityRepository;
use US\Soporteav\Entity\pc;


/**
 * Class PcRepository
 */
class PcRepository extends EntityRepository
{
    /**
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return array Pc
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    //public function findBy(array $criteria, array $orderBy = 'id', $limit = null, $offset = null)
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Guarda una incidencia en la base de datos
     * @param Pc $pc
     */
    public function save(Pc $pc)
    {
        parent::getEntityManager()->persist($pc);
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
    public function delete(Pc $pc)
    {
        parent::getEntityManager()->remove($pc);
        parent::getEntityManager()->flush();
    }

    /**
     * Cuenta el número de Centros existente.
     *
     * @return integer Número total de Centros.
     */
    public function count()
    {
        $dql = 'SELECT COUNT(c.id) FROM US\Soporteav\Entity\Pc c';
        $query = parent::getEntityManager()->createQuery($dql);
        return $query->getSingleScalarResult();
    }
}