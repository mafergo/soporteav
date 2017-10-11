<?php
/**
 * Soporteav Project
 * Repository/IssueRepository.php
 */

namespace US\Soporteav\Repository;

use Doctrine\ORM\EntityRepository;
use US\Soporteav\Entity\Issue\State;


/**
 * Class IssueStateRepository
 */
class IssueStateRepository extends EntityRepository
{
    /**
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return array State[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    //public function findBy(array $criteria, array $orderBy = 'id', $limit = null, $offset = null)
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param State $state
     */
    public function save(State $state)
    {
        parent::getEntityManager()->persist($state);
        parent::getEntityManager()->flush();
    }

    /**
     * @param mixed $id
     * @param null $lockMode
     * @param null $lockVersion
     * @return object|null
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return parent::find($id, $lockMode, $lockVersion);
    }


    /**
     * @param State $state
     */
    public function delete(State $state)
    {
        parent::getEntityManager()->remove($state);
        parent::getEntityManager()->flush();
    }


}