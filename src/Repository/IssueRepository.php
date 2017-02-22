<?php
/**
 * Soporteav Project
 * Repository/IssueRepository.php
 */

namespace US\Soporteav\Repository;

use Doctrine\ORM\EntityRepository;
use US\Soporteav\Entity\Issue\Issue;
use US\Soporteav\Entity\Room;


/**
 * Class IssueRepository
 */
class IssueRepository extends EntityRepository
{
    /**
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return array Issue
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    //public function findBy(array $criteria, array $orderBy = 'id', $limit = null, $offset = null)
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Guarda una incidencia en la base de datos
     * @param Issue $issue
     */
    public function save(Issue $issue)
    {
        parent::getEntityManager()->persist($issue);
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
    public function delete(Issue $issue)
    {
        parent::getEntityManager()->remove($issue);
        parent::getEntityManager()->flush();
    }

    /**
     * Cuenta el número de Centros existente.
     *
     * @return integer Número total de Centros.
     */
    public function count()
    {
        $dql = 'SELECT COUNT(i.id) FROM US\Soporteav\Entity\Issue\Issue i';
        $query = parent::getEntityManager()->createQuery($dql);
        return $query->getSingleScalarResult();
    }
}